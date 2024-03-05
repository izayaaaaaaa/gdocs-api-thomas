<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use GoogleDocs\GoogleDocs;

Dotenv::createImmutable(__DIR__ . '/..')->load();

$credentials = __DIR__ . '/../' . $_ENV['GOOGLE_API_CREDENTIALS'];
$documentId = $_ENV['GOOGLE_DOCUMENT_ID'];
$name = $_ENV['GOOGLE_APP_NAME'];
$imageUrl = $_ENV['IMAGE_URL'];
$imagePlaceholderString = $_ENV['IMAGE_PLACEHOLDER_STRING'];
$email = $_ENV['EMAIL_TO_SHARE_DOCUMENT_WITH'];

$service = new GoogleDocs($name, $credentials);

// Duplicate document
$newDocumentId = $service->duplicateDocument($documentId, $email, $imageUrl, $imagePlaceholderString);
echo "\nDocument duplicated successfully. New document ID: " . $newDocumentId;

$pdfContent = $service->exportDocumentAsPdf($newDocumentId);
if (empty($pdfContent)) {
    echo "\nError: PDF content is empty.";
} else {
    // Save the PDF content to a file
    file_put_contents('C:/Users/franc/Downloads/document.pdf', $pdfContent);
    // echo "\nPDF content: " . $pdfContent->getBody();
    echo "\nPDF exported successfully.";
}