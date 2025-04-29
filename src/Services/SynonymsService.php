<?php

namespace PDFfiller\LiteLLMClient\Services;

use OpenAI\Responses\Chat\CreateResponse;
use PDFfiller\LiteLLMClient\Exceptions\LiteLLMClientException;

class SynonymsService extends LiteLLMServiceAbstract
{
    private const string MESSAGE_TEMPLATE = <<<TEXT
        Generate up to %d the most relevant synonyms for the word "%s", response must be just in JSON format.
        Response JSON template: `{"synonyms": ["synonym"]}`;
    TEXT;

    /**
     * @throws LiteLLMClientException
     */
    public function ask(string $word, int $count = 10, float $temperature = 0): array
    {
        $response = $this->client->chat()->create([
            'model' => $this->modelType->value,
            'messages' => [
                ['role' => 'user', 'content' => sprintf(self::MESSAGE_TEMPLATE, $count, $word)],
            ],
            'temperature' => $temperature,
        ]);

        return $this->getJsonResponse($response);
    }

    /**
     * @throws LiteLLMClientException
     */
    private function getJsonResponse(CreateResponse $response): array
    {
        $result = $response->choices[0]?->message?->content ?? null;

        if ($result) {
            $result = preg_replace(['/^```json/i', '/```$/'], '', $result);
            $result = json_decode($result, true);

            if (is_array($result)) {
                return $result;
            }
        }

        throw LiteLLMClientException::createInvalidResponseException($response);
    }
}
