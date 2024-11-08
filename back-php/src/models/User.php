<?php

class User
{
    private $name;
    private $email;
    private $password;
    private $dt_account_creation;

    public function __construct($email, $password, $name = null, $dt_account_creation = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->dt_account_creation = $dt_account_creation;
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

    public function getDtAccountCreation()
    {
        return $this->dt_account_creation;
    }

}