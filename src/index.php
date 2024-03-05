<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use GoogleDocs\GoogleDocs;

Dotenv::createImmutable(__DIR__ . '/..')->load();

$credentials = __DIR__ . '/../' . $_ENV['GOOGLE_API_CREDENTIALS'];
$documentId = $_ENV['GOOGLE_DOCUMENT_ID'];
$name = $_ENV['GOOGLE_APP_NAME'];

$service = new GoogleDocs($name, $credentials);
$email = $_ENV['EMAIL_TO_SHARE_DOCUMENT_WITH'];
$newDocumentId = $service->duplicateDocument($documentId, $email);
echo "\nDocument duplicated successfully. New document ID: " . $newDocumentId;