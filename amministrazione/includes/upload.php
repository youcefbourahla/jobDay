<?php 

function uploadImage($file,$name) {

	$target_dir = "../img/product/";
	$extention = pathinfo($name, PATHINFO_EXTENSION);

	$target_file = $target_dir .$name ;
	$uploadOk = 1;
	
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "ce n'est pas une image !.";
        $uploadOk = 0;
    }

	// Check file size
	if ($file["size"] > 500000) {
	    echo "Fichier image trop large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($extention != "jpg" && $extention != "png" && $extention != "jpeg"
	&& $extention != "gif" ) {
	    echo "Seulement les fichier JPG, JPEG, PNG & GIF sont autorisés.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    return false;
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($file["tmp_name"], $target_file)) {
	        return true;
	    } else {
	        return false;
	    }
	}
}