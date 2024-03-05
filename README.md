# google-docs
Google Docs API using PHP

### How to get the Credentials
1. Go to the [Google Developers Console](https://console.developers.google.com/).
2. Select a project, or create a new one.
3. Click on "+ Enable API and Services" and search for "Google Docs API".
4. Click on the "Google Docs API" and click on "Enable".
5. Go back to the dashboard and click on "Credentials".
6. Click on "Create credentials" and select "Service Account".
7. Fill in the details and click on "Create".
8. Select the role as "Project" > "Owner" and click on "Continue".
9. Click on "Done" and the credentials will be created.
10. Click on the created credentials then select the "Keys" tab.
11. Click on "Add Key" and select "Create new key".
12. Select the key type as "JSON" and click on "Create".
13. The JSON file will be downloaded.
14. Rename the JSON file to `credentials.json` and place it in the root directory.

### How to get the Document ID
1. Open the Google Docs document.
2. The URL will be something like `https://docs.google.com/document/d/DOCUMENT_ID/edit`.
3. The `DOCUMENT_ID` is the ID of the document.
4. Copy the `DOCUMENT_ID` and paste it in the `config.php` file.
5. The `DOCUMENT_ID` will be used to fetch the document.
6. To give access to the service account, share the document with the `client_email` in the `credentials.json` file.

### Install the dependencies
```
composer install
```
