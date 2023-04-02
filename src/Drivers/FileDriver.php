<?php

namespace Supermetrics\Ambassador\Drivers;

use Exception;
use Spatie\Async\Pool;
use Supermetrics\Ambassador\Enums\Messages;
use Supermetrics\Ambassador\Contracts\DriverInterface;
use Supermetrics\Ambassador\Exceptions\FileReaderException;
use Supermetrics\Ambassador\Contracts\DriverConnectionInterface;

class FileDriver implements DriverInterface, DriverConnectionInterface
{
    private const BASE_GENERATOR_NAMESPACE = 'Supermetrics\Ambassador\Generators\\';
    private const GENERATOR_CLASS_SUFFIX = 'FileRecordGenerator';

    /**
     * @return bool
     */
    public function connect(): bool
    {
        return true;
    }
    public function findAll(string $entityType): array
    {
        // TODO: Implement findAll() method.
        return [];
    }

    public function findById(string $id, string $entityType): array
    {
        $fileGenerator = $this->getFileGenerator($entityType);
        $storagePath = $fileGenerator->pathGenerator($entityType, $this->getFileStoragePath());
        $content = $fileGenerator->dataUnserializer($storagePath);
        $unserializedData = [];

        foreach ($content as $serializedItem) {
            $unserializedData[] = unserialize($serializedItem, ['allowed_classes' => false]);
        }

        $result = [];
        foreach ($unserializedData as $item) {
            if (isset($item['id']) && $item['id'] === $id) {
                $result[] =  $item;
                break;
            }
        }

        return $result;
    }

    /**
     * @throws FileReaderException
     */
    public function store(array $payload, string $entityType): void
    {
        $fileGenerator = $this->getFileGenerator($entityType);
        $payload = $fileGenerator->dataSerializer($payload);
        $storagePath = $fileGenerator->pathGenerator($entityType, $this->getFileStoragePath());

        /**
         * The import process will be run asynchronous.
         */
        $pool = Pool::create();
        foreach ($payload as $item) {
            $pool->add(
                function () use ($item, $storagePath) {
                    $file = $this->readFile($storagePath);
                    fwrite($file, $item . PHP_EOL);
                    fclose($file);

                    return $item;
                }
            );
        }

        $pool->wait();
    }

    /**
     * @param string $entityType
     *
     * @return mixed
     */
    private function getFileGenerator(string $entityType): mixed
    {
        return new (self::BASE_GENERATOR_NAMESPACE . ucfirst($entityType) . '\\' . self::GENERATOR_CLASS_SUFFIX);
    }

    /**
     * @return string
     */
    private function getFileStoragePath(): string
    {
        if (config('app')['default'] === 'local') {
            return config('database')['connections']['file']['default']['path'];
        }

        // On production will be different
        return config('database')['connections']['file']['production']['path'];
    }

    /**
     * @throws FileReaderException
     */
    private function readFile(string $storagePath)
    {
        try {
            return fopen($storagePath, 'a', true);
        } catch (Exception $ex) {
            throw new FileReaderException(Messages::FILE_IS_UNAVAILABLE->value);
        }
    }
}
