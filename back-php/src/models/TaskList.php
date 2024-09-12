<?php

class TaskList{
    private $id;
    private $name_list;
    private $type_list;
    private $dt_creation;
    private $dt_atualization;
    private $id_user;
    private $description;

    public function __construct($id, $name_list, $type_list, $dt_creation, $dt_atualization, $id_user, $description) {
        $this->id = $id;
        $this->name_list = $name_list;
        $this->type_list = $type_list;
        $this->dt_creation = $dt_creation;
        $this->dt_atualization = $dt_atualization;
        $this->id_user = $id_user;
        $this->description = $description;
    }

    public function getId() {
        return $this->id;
    }

    public function getNameList() {
        return $this->name_list;
    }

    public function getTypeList() {
        return $this->type_list;
    }

    public function getDtCriacao() {
        return $this->dt_creation;
    }

    public function getDtAtualization() {
        return $this->dt_atualization;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function getDescription() {
        return $this->description;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function setNameList($name_list) {
        $this->name_list = $name_list;
    }

    public function setTypeList($type_list) {
        $this->type_list = $type_list;
    }

    public function setCreationDate($dt_creation) {
        $this->dt_creation = $dt_creation;
    }

    public function setLastUpdateDate($dt_atualization) {
        $this->dt_atualization = $dt_atualization;
    }

    public function setUserId($id_user) {
        $this->id_user = $id_user;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
