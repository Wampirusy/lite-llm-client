<?php

namespace PDFfiller\LiteLLMClient\Services;

use PDFfiller\LiteLLMClient\Exceptions\LiteLLMClientException;

class TextService extends LiteLLMServiceAbstract
{
    /**
     * @throws LiteLLMClientException
     */
    public function ask(string $question, float $temperature = 0): string
    {
        $response = $this->client->chat()->create([
            'model' => $this->modelType->value,
            'messages' => [
                ['role' => 'user', 'content' => $question],
            ],
            'temperature' => $temperature,
        ]);

        if (isset($response->choices[0]->message->content)) {
            return $response->choices[0]->message->content;
        }

        throw LiteLLMClientException::createInvalidResponseException($response);
    }
}
