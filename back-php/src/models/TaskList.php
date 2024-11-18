<?php

class TaskList
{
    private $id_task;
    private $id_list;

    public function __construct($id_list, $id_task)
    {
        $this->id_list = $id_list;
        $this->id_task = $id_task;
    }

    public function getIdList()
    {
        return $this->id_list;
    }

    public function getIdTask()
    {
        return $this->id_task;
    }

    public function setIdList($id_list)
    {
        $this->id_list = $id_list;
    }

    public function setIdTask($id_task)
    {
        $this->id_task = $id_task;
    }
}
