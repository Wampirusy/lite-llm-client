<?php

namespace PDFfiller\LiteLLMClient\Services;

use PDFfiller\LiteLLMClient\Exceptions\LiteLLMClientException;

class TextService extends LiteLLMServiceAbstract
{
    private const string URI = '/chat/completions';

    /**
     * @throws LiteLLMClientException
     */
    public function ask(string $question, float $temperature = 0): string
    {
        $result = $this->sendMessages([
            ['role' => 'user', 'content' => $question]
        ], $temperature);

        if (isset($result[0]['message']['content'])) {
            return $result[0]['message']['content'];
        }

        throw LiteLLMClientException::createInvalidDataException($result);
    }

    protected function getApiUri(): string
    {
        return self::URI;
    }
}
