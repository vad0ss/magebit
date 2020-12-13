<?php


namespace App\Classes;

use App\Models\Email;

class MailValidator
{

    public function existsMail($email) {
       $emailModel = new Email();
       return $emailModel->isExists($email);
    }

    public function isMail($email) {
       return !filter_var($email, FILTER_VALIDATE_EMAIL) ? false : true;
    }

    public function isEmpty($email) {
       return empty($email);
    }

    public function isColumbia($email){
        $tld = substr($email, -3);
        return $tld === '.co' ? true : false;
    }

}