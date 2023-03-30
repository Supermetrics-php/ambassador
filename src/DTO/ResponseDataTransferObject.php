<?php

namespace Supermetrics\Ambassador\Returner;

use Supermetrics\Ambassador\Enums\StatusCodes;

class ResponseDataTransferObject
{
	/**
	 * @param StatusCodes $statusCode
	 * @param array       $data
	 */
	public function __construct(
		public StatusCodes $statusCode,
		public array $data
	) {}
}
