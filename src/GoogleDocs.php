<?php

namespace GoogleDocs;

use Exception;
use Google\Service\Docs\Document;
use Google_Client;
use Google_Service_Docs;
use Google_Service_Docs_Document;
use Google_Service_Drive;
use Google_Service_Drive_Permission;
use Google_Service_Docs_Request;
use Google_Service_Docs_BatchUpdateDocumentRequest;

class GoogleDocs
{
    private Google_Service_Docs $docsService;
    private Google_Service_Drive $driveService;

    public function __construct(string $name, string $credentials, string|array $scopes = [Google_Service_Docs::DOCUMENTS, 'https://www.googleapis.com/auth/drive'])
    {
        $client = new Google_Client();
        $client->setApplicationName($name);
        $client->setScopes($scopes);
        $client->setAuthConfig($credentials);
        $client->setHttpClient(new \GuzzleHttp\Client(['verify' => false])); // Disables SSL verification
        $this->docsService = new Google_Service_Docs($client);
        $this->driveService = new Google_Service_Drive($client);
    }

    public function duplicateDocument($documentId, $email) {
        // Create a new document
        $newDocument = new Google_Service_Docs_Document();
        $newDocument->setTitle('Duplicate of ' . $documentId);
        $newDocument = $this->docsService->documents->create($newDocument);

        // Copy the content from the original document to the new document
        $originalDocument = $this->docsService->documents->get($documentId);
        $content = $originalDocument->getBody()->getContent();

        // Prepare the requests to update the new document's content
        $requests = [];
        foreach ($content as $element) {
            if ($element->getParagraph()) {
                $paragraph = $element->getParagraph();
                foreach ($paragraph->getElements() as $paragraphElement) {
                    if ($paragraphElement->getTextRun()) {
                        $textRun = $paragraphElement->getTextRun();
                        $requests[] = new Google_Service_Docs_Request([
                            'insertText' => [
                                'location' => [
                                    'index' => 1,
                                ],
                                'text' => $textRun->getContent(),
                            ],
                        ]);
                    }
                }
            }
        }

        // Apply the updates to the new document
        $batchUpdateRequest = new Google_Service_Docs_BatchUpdateDocumentRequest([
            'requests' => $requests,
        ]);
        $this->docsService->documents->batchUpdate($newDocument->getDocumentId(), $batchUpdateRequest);

        // Share the document with the specified email address
        $permission = new Google_Service_Drive_Permission([
            'type' => 'user',
            'role' => 'writer',
            'emailAddress' => $email
        ]);
        $this->driveService->permissions->create($newDocument->getDocumentId(), $permission);

        return $newDocument->getDocumentId();
    }
}