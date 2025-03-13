<?php 

/**
 * This file contains the menu preview for the selected item (a menu)
 */

// namespace Menu\View;

include __DIR__ . "/src/Controller/Controller.php";

$menu = $_GET['menu'];

$Controller = new Menu\Controller\SelectOperation();
$results = json_decode($Controller->SelectAll(), true);

  	// Separate parent menus from children
$parentmenus = [];
  
foreach ($results as $result) {
    if (empty($result['menu_parent'])){
    	$parentmenus[] = $result;
    }
}

	//Separate children menus from parents
$childrenmenus = [];
  
foreach ($results as $result) {
    if (!empty($result['menu_parent'])){
    	$childrenmenus[] = $result;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Previsualizacion</title>
  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand">Evaluacion</a>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link btn-danger" href="index.php">Regresar <span class="sr-only">(current)</span></a>
			</li>
			
			<?php

			// Foreach parent make a dropdown element
			foreach ($parentmenus as $parent) {
				echo" 
				<li class='nav-item dropdown' ondblclick=OpenParent(".$parent['menu_id'].")>
				<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
					".$parent['menu_name']."
				</a>
				<div class='dropdown-menu' aria-labelledby='navbarDropdown'>
					";

					// Foreach children check if the current parent begin iterated is his parent 
					foreach ($childrenmenus as $children) {
						if ($children['menu_parent'] == $parent['menu_id']) {
							echo"
							<a class='dropdown-item' href='?menu=".$children['menu_id']."'>".$children['menu_name']."</a>
							";
						}
					}
					echo "
				</div>
				</li>
				";
			} 
			
			?>

		</ul>
		</div>
	</nav>
	<p>doble click para "abrir" los menus padre</p>

  	<div style="display:flex;justify-content:center; align-items: center; height:100vh;">
		<p style="border: 1px solid black; padding:3em;">

		<?php
			
			// Search for the opened menu and put his description in the center
		foreach ($results as $result) {
			if ($result['menu_id'] == $menu) {
				echo $result['menu_desc'];
			}
		}

		?>

		</p>
  	</div>
    
	<script>
			function OpenParent(id) {
				window.location.href = 'preview.php?menu='+id;
			}
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>