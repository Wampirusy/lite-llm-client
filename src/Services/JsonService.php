<?php

namespace PDFfiller\LiteLLMClient\Services;

use PDFfiller\LiteLLMClient\Exceptions\LiteLLMClientException;

class JsonService extends LiteLLMServiceAbstract
{
    private const string URI = '/chat/completions';

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
        $result = $this->sendMessages([
            ['role' => 'user', 'content' => sprintf(self::MESSAGE_TEMPLATE, $question, json_encode($template))],
        ], $temperature);

        return $this->getJsonResponse($result);
    }

    protected function getApiUri(): string
    {
        return self::URI;
    }

    /**
     * @throws LiteLLMClientException
     */
    private function getJsonResponse(array $result): array
    {
        $result = $result[0]['message']['content'] ?? '';
        $result = preg_replace(['/^```json/i', '/```$/'], '', $result);
        $result = json_decode($result, true);

        if (is_array($result)) {
            return $result;
        }

        throw LiteLLMClientException::createInvalidDataException($result);
    }
}
