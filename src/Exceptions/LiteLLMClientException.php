<?php

namespace PDFfiller\LiteLLMClient\Exceptions;

use GuzzleHttp\Exception\GuzzleException;

class LiteLLMClientException extends \Exception
{
    public static function createFromGuzzleException(GuzzleException $exception): self
    {
        return new self(
            'Call to LiteLLM service failed with message: '.$exception->getMessage(),
            $exception->getCode() ?: 400
        );
    }

    public static function createInvalidDataException(mixed $rawData): self
    {
        $rawData = is_array($rawData) ? json_encode($rawData) : (string)$rawData;
        $rawData = strlen($rawData) > 100 ? substr($rawData, 0, 100).'...' : $rawData;

        return new self('Invalid response from LiteLLM service: '.$rawData, 400);
    }
}
