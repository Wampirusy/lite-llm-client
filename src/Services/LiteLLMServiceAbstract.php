<?php

namespace PDFfiller\LiteLLMClient\Services;

use PDFfiller\LiteLLMClient\Enums\ModelType;
use PDFfiller\LiteLLMClient\Exceptions\LiteLLMClientException;
use PDFfiller\LiteLLMClient\LiteLLMClient;

abstract class LiteLLMServiceAbstract
{
    protected ModelType $modelType = ModelType::gpt4mini;

    public function __construct(private readonly LiteLLMClient $client)
    {
    }

    public function setModelType(ModelType $modelType): static
    {
        $this->modelType = $modelType;

        return $this;
    }

    abstract protected function getApiUri(): string;

    /**
     * @throws LiteLLMClientException
     */
    protected function sendMessages(array $messages, float $temperature = 0): array
    {
        $result = $this->client->sendRequest($this->modelType, $this->getApiUri(), $messages,$temperature);

        if (isset($result['choices'])) {
            return $result['choices'];
        }

        throw LiteLLMClientException::createInvalidDataException($result);
    }
}
