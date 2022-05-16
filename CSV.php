<?php 

/** 
* CSV
* 
* Made by phatnt93
* 16/05/2022
* 
* @license MIT License
* @author phatnt <thanhphat.uit@gmail.com>
* @github https://github.com/phatnt93/php-export-csv
* @version 1.0.0
* 
*/

class CSV {
    const EXPORT_TYPE_FILE = 'file';
    const EXPORT_TYPE_DOWNLOAD = 'download';

    private $csvFile;
    private $exportType;
    private $exportFilePath;
    private $separator = ',';

    private $error = '';

    public function setError($msg = ''){
        $this->error = $msg;
    }

    public function getError(){
        return $this->error;
    }

    public function hasError(){
        return ($this->error ? true : false);
    }
    
    function __construct()
    {
        $user_agent = getenv("HTTP_USER_AGENT");
        if (strpos($user_agent, "Mac") !== FALSE) {
            $this->separator = ';';
        }
    }
    
    /**
     * setExportType
     *
     * @param string $type CSV::EXPORT_TYPE_DOWNLOAD|CSV::EXPORT_TYPE_FILE
     * @return void
     */
    public function setExportType(string $type = CSV::EXPORT_TYPE_DOWNLOAD){
        $this->exportType = $type;
    }

    public function getExportType(){
        return $this->exportType;
    }

    /**
     * setExportFilePath
     *
     * @param string $path Destination to save file. If download type is file 
     * @return void
     */
    public function setExportFilePath(string $path){
        $this->exportFilePath = $path;
    }

    public function getExportFilePath(){
        return $this->exportFilePath;
    }

    public function createCsvFile(){
        if($this->getExportType() == CSV::EXPORT_TYPE_DOWNLOAD){
            $this->csvFile = fopen("php://output", 'w');
        }elseif ($this->getExportType() == CSV::EXPORT_TYPE_FILE) {
            $this->csvFile = fopen($this->getExportFilePath(), 'w');
        }else{
            $this->csvFile = null;
        }
    }

    public function addTitleRow(array $params){
        fputcsv($this->csvFile, $params, $this->separator);
    }

    public function addRow(array $params){
        fputcsv($this->csvFile, $params, $this->separator);
    }

    public function closeFile(){
        fclose($this->csvFile);
    }

    // Export to force download file
    public function headersForDownload($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
    
        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
    
        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}.csv");
        header("Content-Transfer-Encoding: binary");

        // Encode UTF-8
        header('Content-Encoding: UTF-8');
        echo "\xEF\xBB\xBF";
    }

    
}
