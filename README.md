Install
=======

    composer require merceslab/spreadsheet-client-bundle
    
Configuration
=============

    merces_lab_google_spreadsheet:
        credentials: '{}' # JSON string
        files: # optional, creates a GoogleFile service named 'merces_lab.spreadsheet_client.google.file.my_file'
            my_file:
                file: 'myFileId'
        sheets: # optional, creates a GoogleSheet service named 'merces_lab.spreadsheet_client.google.sheet.my_sheet'
            my_sheet:
                file: 'myFileId'
                sheetName: 'mySheet'
        tables: # optional, creates a GoogleTable service named 'merces_lab.spreadsheet_client.google.table.my_table'
            my_table:
                file: 'myFileId'
                sheetName: 'mySheet'
                tableRange: 'H1:AA1'

Usage
=====

To write data into a Google Spreadsheet:

```php
<?php

use MercesLab\Component\SpreadsheetClient\ClientInterface;

class SomeService
{
    public function export(ClientInterface $client)
    {
        $client->write(['foor', 'bar',], 'myFile');
    }
}
```

To read data from a Google Spreadsheet:

```php
<?php

use MercesLab\Component\SpreadsheetClient\ClientInterface;

class SomeService
{
    public function import(ClientInterface $client)
    {
        $data = $client->read('fileId');
    }
}
```

Check the component documentation: https://github.com/MercesLyon/GoogleFixtures
