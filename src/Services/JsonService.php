<?php

namespace PDFfiller\LiteLLMClient\Services;

use OpenAI\Responses\Chat\CreateResponse;
use PDFfiller\LiteLLMClient\Exceptions\LiteLLMClientException;

class JsonService extends LiteLLMServiceAbstract
{
    private const string MESSAGE_TEMPLATE = <<<TEXT
        Answer the questions and generate response, response must be just in JSON format 
        and must implement JSON template: %s
        Response JSON template: `%s`;
    TEXT;

    /**
     * @throws LiteLLMClientException
     */
    public function ask(string $question, array $template, float $temperature = 0): array
    {
        $response = $this->client->chat()->create([
            'model' => $this->modelType->value,
            'messages' => [
                ['role' => 'user', 'content' => sprintf(self::MESSAGE_TEMPLATE, $question, json_encode($template))],
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
