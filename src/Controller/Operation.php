<?php

namespace Menu\Controller\Operation;

include __DIR__ . '/../Model/Model.php';

use Menu\Model\DbContext as DbContext;

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