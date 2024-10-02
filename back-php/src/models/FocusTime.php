<?php

class FocusTime {
    private $task_id;
    private $duration;
    private $recorded_date;
    private $focus_time_id;

    // Constructor
    public function __construct($task_id, $duration, $focus_time_id) {
        $this->task_id = $task_id;
        $this->duration = $duration;
        $this->focus_time_id = $focus_time_id;
    }

    // Getters
    public function getTaskId() {
        return $this->task_id;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getRecordedDate() {
        return $this->recorded_date;
    }

    public function getFocusTimeId() {
        return $this->focus_time_id;
    }

    // Setters
    public function setTaskId($task_id) {
        $this->task_id = $task_id;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function setFocusTimeId($focus_time_id) {
        $this->focus_time_id = $focus_time_id;
    }

    // ToString method
    public function __toString() {
        return "FocusTime{" .
            "task_id=" . $this->task_id .
            ", duration='" . $this->duration . '\'' .
            ", recorded_date='" . $this->recorded_date . '\'' .
            ", focus_time_id=" . $this->focus_time_id .
            '}';
    }
}

?>
