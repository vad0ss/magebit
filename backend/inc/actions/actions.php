<?php
/**
 * Author: Vadims Prilepisevs
 * Date: 10.12.2020
 * Time: 11:05
 */

include '../../vendor/autoload.php';
use App\Models\Email;
use App\Classes\CsvConvert;

if(isset($_POST['check_list'])){
    $checkList = $_POST['check_list'];

    if($_POST['actions'] === 'csv') {

        $csv = new CsvConvert();
        $emailModel = new Email();
        $emails = array();

        $emails[] = ['MAIL_ID', 'Email', 'Created', 'Provider'];

        foreach($checkList as $item) {
            $stmt = $emailModel->getMail($item);

            while ($email = $stmt->fetch(PDO::FETCH_LAZY)) {
                $a = array();

                $a['mail_id'] = $email->id;
                $a['email'] = $email->email;
                $a['created'] = $email->created;
                $a['provider'] = $email->provider;

                $emails[] = $a;
            }

        }

        $csv->createCSV($emails);

    } elseif($_POST['actions'] === 'delete') {

        $email = new Email();

        foreach ($checkList as $item) {
            $email->delete($item);
        }
    }
}

 header('Location: ' . $_SERVER['HTTP_REFERER']);
