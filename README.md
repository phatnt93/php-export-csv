# php export csv
php export csv

Mac OS, separator = ';'

Window OS, separator = ','

## Example download file
```
$filename = 'csv_export_' . date('Ymdhis');
$csv = new \Library\Export\CSV();
$csv->setExportType(\Library\Export\CSV::EXPORT_TYPE_DOWNLOAD);
$csv->createCsvFile();
$csv->headersForDownload($filename);
$titles = ['#', 'Name'];
$csv->addTitleRow($titles);
foreach ($params as $key => $param) {
    $row = [
        $key + 1,
        $param['name']
    ];
    $csv->addRow($row);
}
$csv->closeFile();
exit;
```

## Example save file
```
$pathSaveFile = 'csv_export_' . date('Ymdhis');
$csv = new \Library\Export\CSV();
$csv->setExportType(\Library\Export\CSV::EXPORT_TYPE_FILE);
$csv->setExportFilePath($pathSaveFile);
$csv->createCsvFile();
$titles = ['#', 'Name'];
$csv->addTitleRow($titles);
foreach ($params as $key => $param) {
    $row = [
        $key + 1,
        $param['name']
    ];
    $csv->addRow($row);
}
$csv->closeFile();
exit;
```
