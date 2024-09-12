<?php

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $dt_account_creation;

    public function __construct($id = null, $name = null, $email, $password, $dt_account_creation = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->dt_account_creation = $dt_account_creation;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getDtAccountCreation() {
        return $this->dt_account_creation;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password){
        $this->password = $password;
    }
}

?>
