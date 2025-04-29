<?php

namespace PDFfiller\LiteLLMClient\Services;

use OpenAI\Client;
use PDFfiller\LiteLLMClient\Enums\ModelType;

abstract class LiteLLMServiceAbstract
{
    protected ModelType $modelType = ModelType::gpt4mini;

    protected Client $client;

    public function __construct(string $host, string $token)
    {
        $this->client = \OpenAI::factory()
            ->withBaseUri($host)
            ->withApiKey($token)
            ->make();
    }

    public function setModelType(ModelType $modelType): static
    {
        $this->modelType = $modelType;

        return $this;
    }
}
