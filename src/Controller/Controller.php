<?php

namespace Menu\Controller;

/**
 * Logic designated to the "controller" inside de MVC design model
 * Connection between DB context class and web request 
 */

// require "back.php";
// require_once __DIR__ . "/../../vendor/autoload.php";
// $test = new Menu\Test();
// include("vendor/autoload.php");
// require_once realpath("/../../vendor/autoload.php");

// use Menu\Controller\Operation;

include 'Operation.php';

use Menu\Controller\Operation\Operation as Operation;
use Menu\Controller\Operation\Action as Action;
use Menu\Controller\Operation\UsesContext as UsesContext;

// use Menu\Model\DbContext;
// use Menu\Model\SelectData;
// use Menu\Model\InsertData;
// use Menu\Model\UpdateData;
// use Menu\Model\DeleteData;

class SelectOperation extends Operation
{
    function selectAll() {
        $this->DB->setStrat("select");
        $result = $this->DB->doStrat(null);
        return json_encode($result);
    }
}
    
class CreateOperation extends Operation implements UsesContext
{
    use Action;

    function setContext($data) {
        $this->DB->setStrat("insert");
        $this->useStrategy($data);
    }
}
    
class UpdateOperation extends Operation implements UsesContext
{
    use Action;

    function setContext($data) {
        $this->DB->setStrat("update");
        $this->useStrategy($data);
    }
}

class DeleteOperation extends Operation implements UsesContext
{
    use Action;

    function setContext($data) {
        $this->DB->setStrat("delete");
        $this->useStrategy($data);
    }
}


    // Handle requests from view
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($_POST['action'] == 'create') {
        $controller = new CreateOperation();
        $result = $controller->setContext($_POST);
        return $result;
    } elseif ($_POST['action'] == 'update') {
        $controller = new UpdateOperation();
        $result = $controller->setContext($_POST);
        return $result;
    } elseif ($_POST['action'] == 'delete') {
        $controller = new DeleteOperation();
        $result = $controller->setContext($_POST['id']);
        return $result;
    } else {
        $controller = new SelectOperation();
        $result = $controller->selectAll();
        return $result;
    }
}