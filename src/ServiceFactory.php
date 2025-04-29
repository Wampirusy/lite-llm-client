<?php

namespace PDFfiller\LiteLLMClient;

use PDFfiller\LiteLLMClient\Services\JsonService;
use PDFfiller\LiteLLMClient\Services\SynonymsService;
use PDFfiller\LiteLLMClient\Services\TextService;

class ServiceFactory
{
    public function __construct(private readonly string $host, private readonly string $token)
    {
    }

    public function createTextService(): TextService
    {
        return new TextService($this->host, $this->token);
    }

    public function createJsonService(): JsonService
    {
        return new JsonService($this->host, $this->token);
    }

    public function createSynonymsService(): SynonymsService
    {
        return new SynonymsService($this->host, $this->token);
    }
}
