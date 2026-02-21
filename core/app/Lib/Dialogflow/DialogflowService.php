<?php

namespace App\Lib\Dialogflow;

use Google\Client;
use Google\Service\Dialogflow;
use App\Models\DialogflowConfig;
use Exception;

class DialogflowService
{
    protected $client;
    protected $service;
    protected $projectId;

    public function __construct(DialogflowConfig $config)
    {
        $credentials = json_decode($config->credentials_json, true);

        if (!$credentials) {
            throw new Exception("Invalid Dialogflow credentials.");
        }

        $this->projectId = $credentials['project_id'] ?? $config->project_id;

        $this->client = new Client();
        $this->client->setAuthConfig($credentials);
        $this->client->addScope('https://www.googleapis.com/auth/dialogflow');

        $this->service = new Dialogflow($this->client);
    }

    public function detectIntent($sessionId, $text, $languageCode = 'en')
    {
        $session = "projects/{$this->projectId}/agent/sessions/{$sessionId}";

        $textInput = new Dialogflow\GoogleCloudDialogflowV2TextInput();
        $textInput->setText($text);
        $textInput->setLanguageCode($languageCode);

        $queryInput = new Dialogflow\GoogleCloudDialogflowV2QueryInput();
        $queryInput->setText($textInput);

        $request = new Dialogflow\GoogleCloudDialogflowV2DetectIntentRequest();
        $request->setQueryInput($queryInput);

        try {
            $response = $this->service->projects_agent_sessions->detectIntent($session, $request);
            $queryResult = $response->getQueryResult();

            return [
                'fulfillmentText' => $queryResult->getFulfillmentText(),
                'action' => $queryResult->getAction(),
                'parameters' => $queryResult->getParameters(),
                'intent' => $queryResult->getIntent() ? $queryResult->getIntent()->getDisplayName() : null,
                'confidence' => $queryResult->getIntentDetectionConfidence()
            ];
        } catch (Exception $e) {
            // Log error
            return null;
        }
    }
}
