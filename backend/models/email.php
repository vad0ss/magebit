<?php
/**
 * Author: Vadims Prilepisevs
 * Date: 09.12.2020
 * Time: 9:43
 */

namespace App\Models;

use App\Config\Database;
use PDO;

class Email {

    private $connect;
    private $table_name = "emails";

    public $id;
    public $email;
    public $created;
    public $provider;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->connect = $db;
    }

    public function create($data) {

        if($data->email){
           $this->email = $data->email;
           $this->created = date('Y-m-d H:i:s');
           $this->provider = array_pop(explode('@', $this->email));
           $this->provider = array_shift(explode('.', $this->provider ));
           $this->provider = ucfirst($this->provider);
        } else {
            $this->email = $data;
            $this->created = date('Y-m-d H:i:s');
            $this->provider = array_pop(explode('@', $data));
            $this->provider = array_shift(explode('.', $this->provider ));
            $this->provider = ucfirst($this->provider);
        }

        $query = "INSERT INTO " . $this->table_name . "
            SET email=:email, created=:created, provider=:provider";

        $stmt = $this->connect->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->created=htmlspecialchars(strip_tags($this->created));

        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":created", $this->created);
        $stmt->bindValue(":provider", $this->provider);

        if ($stmt->execute()) return true;

        return false;
    }

    public function allEmails() {

        $query = "SELECT * FROM " . $this->table_name;

        $stmt = $this->connect->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function getMail($id){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->connect->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function getMailsForPaginate($offset, $limit) {
        $query = "SELECT * FROM
                " . $this->table_name . " LIMIT ?, ?";

        $stmt = $this->connect->prepare( $query );

        $stmt->bindParam(1, $offset, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function mailsCount() {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name;

        $stmt = $this->connect->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    public function allProviders() {
        $query = "SELECT DISTINCT provider FROM " . $this->table_name .
            " WHERE NOT ((provider = 'Gmail') OR (provider = 'Yahoo') OR (provider = 'Outlook')) ";

        $stmt = $this->connect->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function sortByName() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY `email`";

        $stmt = $this->connect->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function sortByDate() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY `created`";

        $stmt = $this->connect->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function delete($id) {

        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->connect->prepare($query);

        $id=htmlspecialchars(strip_tags($id));

        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function isExists($email) {

        $query = "SELECT email FROM " . $this->table_name . "  WHERE email =:email";

        $stmt = $this->connect->prepare($query);

        $stmt->bindValue(':email', $email);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(empty($result)) {
            return false;
        }

        return true;
    }

}