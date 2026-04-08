<?php

namespace OperationGpt\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('operation-gpt.openai_api_key');
        $this->model = config('operation-gpt.model', 'gpt-4o');

        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    public function sendMessage(string $message)
    {
        $allowedTables = config('operation-gpt.allowed_tables');
        $schemaInfo = json_encode($allowedTables);

        $systemPrompt = "You are a professional database operation assistant. 
        Your task is to convert natural language into structured JSON operations.
        
        ALLOWED TABLES AND COLUMNS: {$schemaInfo}
        
        RULES:
        1. ONLY return JSON. 
        2. NEVER explain anything.
        3. NEVER return raw SQL.
        4. ONLY use the following structures:

        For data insertion:
        {
          \"type\": \"action\",
          \"operations\": [
            { \"action\": \"insert\", \"table\": \"users\", \"data\": { \"name\": \"...\", \"email\": \"...\" } }
          ]
        }

        For updates:
        {
          \"type\": \"action\",
          \"operations\": [
            { \"action\": \"update\", \"table\": \"users\", \"where\": { \"id\": 1 }, \"data\": { \"role\": \"admin\" } }
          ]
        }

        For reports/selects:
        {
          \"type\": \"report\",
          \"table\": \"users\",
          \"columns\": [\"id\", \"name\", \"email\"],
          \"filters\": { \"role\": \"admin\" }
        }

        If the request is invalid or outside the allowed schema, return:
        { \"type\": \"error\", \"message\": \"Reasoing why it's not possible\" }";

        try {
            $response = $this->client->post('chat/completions', [
                'json' => [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $message],
                    ],
                    'response_format' => ['type' => 'json_object']
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['choices'][0]['message']['content'] ?? '';
            
        } catch (\Exception $e) {
            Log::error('OperationGpt OpenAI Error: ' . $e->getMessage());
            return json_encode([
                'type' => 'error',
                'message' => 'Failed to connect to AI service: ' . $e->getMessage()
            ]);
        }
    }
}