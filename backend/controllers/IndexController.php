<?php
/**
 * Author: Vadims Prilepisevs
 * Date: 09.12.2020
 * Time: 17:03
 */

namespace App\Controllers;

use App\Models\Email;
use App\Config\Config;
use PDO;

class IndexController
{

    private $email;
    private $config;

    public $paginateLimit;
    public $mailsCount;


    public function __construct() {
        $this->email = new Email();
        $this->config = new Config();

        $this->paginateLimit = $this->config->PAGINATION_LIMIT;
        $this->mailsCount = $this->email->mailsCount();
    }

    public function allEmails() {
        return $this->email->allEmails();
    }

    public function getMailsForPaginate($offset, $limit){
        return $this->email->getMailsForPaginate($offset, $limit);
    }

    public function getProviders() {
        return $this->email->allProviders();
    }

    public function sortByNameDate($param) {
        if($param === 'name') return $this->email->sortByName();
        elseif($param === 'date') return $this->email->sortByDate();
    }

    public function providerFilter($emails, $param) {
         $result = array();

         foreach($emails as $email) {
             if($email['provider'] === $param) {
                 $result[] = $email;
             }
         }

         return $result;
    }

    public function withoutProviderFilter($emails, $param) {
        $result = array();

        foreach($emails as $email) {
            if($email['provider'] != $param) {
                $result[] = $email;
            }
        }

        return $result;
    }

    public function search($searchstr) {
        $result = array();
        $stmt = $this->allEmails();

        while ($email = $stmt->fetch(PDO::FETCH_LAZY))
        {
            $a = array();

            $a['id'] = $email->id;
            $a['email'] = $email->email;
            $a['created'] = $email->created;
            $a['provider'] = $email->provider;

            $pos = mb_strripos($email['email'], $searchstr);

            if($pos !== false) {
                $result[] = $a;
            }
        }

        return $result;
    }

}