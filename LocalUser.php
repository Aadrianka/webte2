<?php

class LocalUser implements JsonSerializable {
    private $id, $username, $password;

    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    function __construct5($username, $password) {
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function jsonSerialize() {
        return array (
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password
        );
    }

    public function checkPassword($password) {
        return password_verify($password, $this->password);
    }


    public static function fetchByLogin ($conn, $username) {
        $res = $conn->prepare("SELECT * FROM localUsers WHERE username = '".$username."'");
        $res->setFetchMode(PDO::FETCH_CLASS,'LocalUser');
        return $res->execute()?$res->fetchAll():false;
    }

}