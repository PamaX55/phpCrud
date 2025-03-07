<?php 

/**
 * This file handles the first interaction when accesing the project in browser
 */

require_once __DIR__ . "/vendor/autoload.php";
require_once realpath("vendor/autoload.php");
// $test = new Menu\Test\Test();

try {
    $Controller = new Menu\Controller\SelectOperation();
} catch (PDOException $e) {
    echo "Hubo un error de conexion con la base de datos";
    return ;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de menus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div id="list-header" style="justify-content:space-between; bottom-padding:1em;">
            <h1 class="">Menu</h1>
            <button class="btn btn-success" id="create-btn">Crear menu</button>
        </div>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nombre (pulse para abrir)</th>
                <th>Padre</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </tr>
            <?php

            $results = json_decode($Controller->SelectAll(), true);

            foreach ($results as $result) {
                echo "
                    <tr>
                        <td>".$result['menu_id']."</td>
                        <td onClick='OpenMenuPreview(".$result['menu_id'].")'>".$result['menu_name']."</td>
                        <td>".$result['menu_parent']."</td>
                        <td>".$result['menu_desc']."</td>
                        <td>
                            <button onClick='OpenUpdateForm(".$result['menu_id'].")'>Editar</button>
                            <button onClick='DeleteMenu(".$result['menu_id'].")'>Eliminar</button>
                        </td>
                    </tr>
                ";
            }
            ?>
        </table>

    </div>

    <div id="createmenu-div" style="visibility:hidden;">
        <h1>Nuevo menu</h1>
        
        <form id="createmenu-form" class="form-group" onsubmit="CreateMenu(event)">
            <div class="form-group">
                <label for="newmenu-name">Nombre</label>
                <input type="text" name="newmenu-name" id="newmenu-name" maxlength="30" required>
            </div>
            
            <div class="form-group">
                <label for="newmenu-desc">Descripcion</label>
                <input type="text" name="newmenu-desc" id="newmenu-desc" maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="newmenu-parent">Menu padre</label>
                <select name="newmenu-parent" id="newmenu-parent">
                    <option value="">Selecciona</option>
                        <?php

                        foreach ($results as $result) {
                            echo "
                                <option value='".$result['menu_id']."'>".$result['menu_name']."</option>
                            ";
                        } 
                    ?>
                </select>
            </div>
            
            <div>
                <input type="button" id="createmenu-quit" value="Cancelar">
                <input type="submit" name="create" id="createmenu-save" value="Guardar">
            </div>
        </form>
        
    </div>

    <div id="updatemenu-div" style="visibility:hidden;">
        <h1>Modificar menu</h1>	
        <form id="updatemenu-form" onsubmit="UpdateMenu(event)">
            <input type="hidden" name="updatemenu-id" id="updatemenu-id">

            <div class="form-group">
                <label for="updatemenu-name">Nombre</label>
                <input type="text" name="updatemenu-name" id="updatemenu-name"  maxlength="30" required>
            </div>

            <div class="form-group">
                <label for="updatemenu-desc">Descripcion</label>
                <input type="text" name="updatemenu-desc" id="updatemenu-desc" maxlength="100" required>
            </div>

            <div class="form-group">
                <label for="updatemenu-parent">Menu padre</label>
                <select name="updatemenu-parent" id="updatemenu-parent">
                    <option value="">Selecciona</option>
                        <?php
                        
                        foreach ($results as $result) {
                            echo "
                                <option value='".$result['menu_id']."'>".$result['menu_name']."</option>
                            ";
                        } 
                    ?>
                </select>
            </div>

            <div>
                <input type="button" id="updatemenu-quit" value="Cancelar">
                <input type="submit" name="update" id="updatemenu-save" value="Guardar">
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

<script src="script.js"></script>
</html>