<?php

class Task {
    private $id;
    private $name;
    private $description;
    private $start_date;
    private $end_date;
    private $status;
    private $list_id;

    public function __construct($id, $name, $description, $start_date, $end_date, $status, $list_id) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
        $this->list_id = $list_id;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getListId() {
        return $this->list_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setStartDate($start_date) {
        $this->start_date = $start_date;
    }

    public function setEndDate($end_date) {
        $this->end_date = $end_date;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setListId($list_id) {
        $this->list_id = $list_id;
    }

}
