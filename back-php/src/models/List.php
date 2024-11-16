<?php

class Listing
{
    private $id_list;
    private $name_list;
    private $description;
    private $id_type_list;

    public function __construct($name_list, $description, $id_type_list = 4, $id_list = 0)
{
    $this->id_list = $id_list;
    $this->name_list = $name_list;
    $this->description = $description;
    $this->id_type_list = $id_type_list;
}

    public function getIdList(){
        return $this->id_list;
    }

    public function setIdList($id_list){
        $this->id_list = $id_list;
    }

    public function getNamelist()
    {
        return $this->name_list;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getID_type_list()
    {
        return $this->id_type_list;
    }

    public function setID_type_list($id_type_list){
        $this->id_type_list = $id_type_list;
    }
}
