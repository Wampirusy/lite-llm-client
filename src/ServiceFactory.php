<?php

namespace PDFfiller\LiteLLMClient;

use PDFfiller\LiteLLMClient\Enums\ServiceType;
use PDFfiller\LiteLLMClient\Services\JsonService;
use PDFfiller\LiteLLMClient\Services\TextService;
use PDFfiller\LiteLLMClient\Services\LiteLLMServiceAbstract;

class ServiceFactory
{
    public function __construct(private readonly LiteLLMClient $client)
    {
    }

    public function createService(ServiceType $type): LiteLLMServiceAbstract
    {
        return match ($type) {
            ServiceType::text => new TextService($this->client),
            ServiceType::json => new JsonService($this->client),
        };
    }
}
