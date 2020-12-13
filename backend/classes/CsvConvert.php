<?php
/**
 * Author: Vadims Prilepisevs
 * Date: 12.12.2020
 * Time: 14:22
 */

namespace App\Classes;

class CsvConvert
{
    private $path;

    public function __construct() {
        $this->path = '../../csvFiles/';
    }

    public function createCSV($emails) {
        $file = $this->path.'emails_'.date('m-d-Y_his').'.csv';

        $fp = fopen($file, 'w');

        foreach($emails as $email) {
            fputcsv($fp, $email);
        }

        fclose($fp);

        $this->csvFileDownload($file);

    }

    private function csvFileDownload($file){
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

}