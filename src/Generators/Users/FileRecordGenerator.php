<?php

namespace Supermetrics\Ambassador\Generators\Users;

use Supermetrics\Ambassador\Enums\Messages;
use Supermetrics\Ambassador\Exceptions\FileReaderException;

class FileRecordGenerator
{
    private const BASE_PATH = './src/';
    private const FILE_SUFFIX = '.txt';

    /**
     * @param array $payload
     *
     * @return array
     * The given array will be serialized, in order to be sure that in the future,
     * nothing will be broken and format and data will be protected.
     */
    public function dataSerializer(array $payload): array
    {
        $result = [];
        foreach ($payload as $userInfo) {
            $result[] = $this->serializer($userInfo);
        }

        return $result;
    }

    /**
     * @param string $filePath
     *
     * @return array
     * @throws FileReaderException
     */
    public function dataUnserializer(string $filePath): array
    {
        $content = file_get_contents($filePath);

        if (!$content) {
            throw new FileReaderException(Messages::FILE_IS_UNAVAILABLE->value);
        }

        return explode("\n", $content);
    }

    /**
     * @param string $entityType
     * @param string $storagePath
     *
     * @return string
     */
    public function pathGenerator(string $entityType, string $storagePath): string
    {
        return self::BASE_PATH . ucfirst($storagePath) . '/' . $entityType . self::FILE_SUFFIX;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    private function serializer(array $data): string
    {
        return serialize($data);
    }
}
