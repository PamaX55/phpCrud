<?php

namespace Menu\Controller\Operation;

class Operation
{
    protected $DB = null;

    function __construct() {
        $this->DB = new DbContext();
    }
}

interface UsesContext
{
    public function setContext($data);
}

trait Action
{
    public function useStrategy($data){
        $result = $this->DB->DoStrat($data);
        echo $result;
        return $result;
    }
}