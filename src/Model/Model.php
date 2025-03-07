<?php

/**
 * Class designated to work on the "backend" logic of the Menu project
 * Designed using the strategy pattern, DbContext class as context, 
 * an abstract class to stablish shared methods in the different 
 * strategies, one for every DB operation.
 */

namespace Menu\Model;

use \PDO;

    // Parent class for DB operations
class DbContext
{
    public $Strat = null;
    private $pdo = null;
    private $qry = null;

        // PDO connection on constructor to give $pdo value
    function __construct() {
        $host = "127.0.0.1";
        $dbName = "tecnico_dp";
        $username = "root";
        $password = "1234";

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
                echo "Hubo un error de conexion con la base de datos";
        }
    }

    function setStrat($operation) {
        $this->Strat = $operation;
    }

    function doStrat($data) {
        $this->Strat->prepareQry($this->pdo, $data);
        $result = $this->Strat->executeQry($this->Strat->qry);
        return $result;
    }
}

abstract class Strategy
{
    public $qry = null;

    abstract public function prepareQry($pdo, $data);

    public function executeQry($qry) {
        try {
            $qry->execute();
        } catch (\Throwable $th) {
            echo "Error al realizar la operacion";
            return $th;
        }
        
        $data = $qry->fetchAll(PDO::FETCH_ASSOC);
        return ($data);
    }
}

    // Select statement (all menus)
class SelectData extends Strategy
{
    function executeQry($qry) {
        $result = parent::executeQry($qry);
        return ($result);
    } 

    public function prepareQry($pdo, $data) {
        $this->qry = $pdo->prepare("SELECT * FROM cat_menus");
    }
}

    // Insert statement
class InsertData extends Strategy
{
    function executeQry($qry) {
        $result = parent::executeQry($qry);
        if (!$result) {
            return "Menu creado correctamente";
        }
    } 

    public function prepareQry($pdo, $data){
        try {
            if ($data['newmenu-parent']==='') {
                $parentid = null;
            } else {$parentid = $data['newmenu-parent'];}
            
            $query = sprintf("INSERT INTO cat_menus (menu_name, menu_desc, menu_parent)
                                                VALUES (:name, :desc, :parent)");
                                                
            $this->qry = $pdo->prepare($query);
            $this->qry->bindParam(':name', $data['newmenu-name']);
            $this->qry->bindParam(':desc', $data['newmenu-desc']);
            $this->qry->bindParam(':parent', $parentid);
        } catch (PDOException $e) {
            return $e;
        }
    }
}

    // Delete statement
class DeleteData extends Strategy
{
    function executeQry($qry) {
        $result = parent::executeQry($qry);

        if (!$result) {
            return "Menu eliminado correctamente";
        }
    } 

    public function prepareQry($pdo, $data) {
        try {
            $query = 'DELETE FROM cat_menus WHERE menu_id = '. $data;
            $this->qry = $pdo->prepare($query);
        } catch (PDOException $e) {
            return($e);
        }
    } 
}
    
    //Update statement
class UpdateData extends Strategy
{
    function executeQry($qry) {
        $result = parent::executeQry($qry);

        if (!$result) {
            return "Menu editado correctamente";
        }
    } 

    public function prepareQry($pdo, $data){
        try {
            if ($data['updatemenu-parent']==='') {
                $parentid = null;
            } else {
                $parentid = $data['updatemenu-parent'];
            }

            $query = sprintf("UPDATE cat_menus SET menu_name = :name, menu_desc = :desc, menu_parent = :parent
                                            WHERE menu_id = :id");
            $this->qry = $pdo->prepare($query);
            $this->qry->bindParam(':name', $data['updatemenu-name']);
            $this->qry->bindParam(':desc', $data['updatemenu-desc']);
            $this->qry->bindParam(':parent', $parentid);
            $this->qry->bindParam(':id', $data['updatemenu-id']);
        } catch (PDOException $e) {
            return($e);
        }
    }
}