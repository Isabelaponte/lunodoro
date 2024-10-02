<?php
    function validatorMethodServer($method){
        return (!(strcasecmp($_SERVER['REQUEST_METHOD'], $method)) ? true : false);
    }

?>