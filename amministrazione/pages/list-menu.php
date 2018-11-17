<?php
	include_once "services/PrestationService.class.php";

	try
	{
	    $menuService = new MenuService($DB_con);
		print_r($menuService->getAll());
	}
	catch(PDOException $e)
	{
	     echo $e->getMessage();
	}

	
?>