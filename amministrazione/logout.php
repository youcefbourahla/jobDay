<?php
	include_once 'includes/db-config.php';
    $userService->logout();
    $userService->redirect('login.php');