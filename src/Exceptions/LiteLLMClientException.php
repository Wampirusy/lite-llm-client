<?php

namespace PDFfiller\LiteLLMClient\Exceptions;

use OpenAI\Responses\Chat\CreateResponse;

class LiteLLMClientException extends \Exception
{
    private ?CreateResponse $response;

    public static function createInvalidResponseException(CreateResponse $response): self
    {
        $exception = new self('Invalid response', 400);
        $exception->response = $response;

        return $exception;
    }

    public function getResponse(): ?CreateResponse
    {
        return $this->response;
    }
}
