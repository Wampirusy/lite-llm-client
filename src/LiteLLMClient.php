<?php

namespace PDFfiller\LiteLLMClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PDFfiller\LiteLLMClient\Enums\ModelType;
use PDFfiller\LiteLLMClient\Exceptions\LiteLLMClientException;

class LiteLLMClient
{
    private Client $client;

    public function __construct(string $host, private readonly string $token, private int $retries = 3)
    {
        $this->client = new Client(['base_uri' => $host]);
    }

    /**
     * @throws LiteLLMClientException
     */
    public function sendRequest(ModelType $type, string $url, array $messages, float $temperature = 0): array
    {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $type->value,
                'messages' => $messages,
                'temperature' => $temperature,
            ]
        ];

        do {
            try {
                $response = $this->client->post($url, $options);
            } catch (GuzzleException $exception) {
                if ($exception->getCode() === 429 && $this->retries--) {
                    sleep(1);
                } else {
                    throw LiteLLMClientException::createFromGuzzleException($exception);
                }
            }
        } while (empty($response));

        $rawData = $response->getBody()->getContents();
        $data = json_decode($rawData, true);


        if (is_array($data)) {
            return $data;
        }

        throw LiteLLMClientException::createInvalidDataException($rawData);
    }
}
