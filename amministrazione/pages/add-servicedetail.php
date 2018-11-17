<?php 
	/* check if someone try to access the folder of these files directly */
	if(strpos($_SERVER['REQUEST_URI'], '/pages/')) {
	    header("Location: ../404.php");
	}
	
	include_once 'includes/db-config.php';
	include_once 'includes/upload.php';

	include 'classes/ServiceItem.class.php';
	include 'services/PrestationService.class.php';
	include 'services/ServiceItemService.class.php';

	if(!$userService->is_loggedin()) {
		$userService->redirect('login.php');
	}

	$prestationService = new PrestationService($DB_con);
	$serviceItemService = new ServiceItemService($DB_con);
	
	/*INITIALISATION*/

	if( isset($_POST['title']) && isset($_POST['parent']) && isset($_POST['description']) ) {
		$errors = [];

		/*CONDITIONS*/
		//Si le titre est vide ou qu'il contient des charactère spéciaux
		if( (isset($_POST['title'])) AND empty($_POST['title']) ) {
		    $errors['title'] = "Titre Obligatoire";
		}
		if( (isset($_POST['parent'])) AND empty($_POST['parent'])){
		    $errors['title'] = "Categorie service Obligatoire";
		}
		if(empty($_POST['description']) ){
		    $errors['description'] = "Description obligatoire !";
		}
		if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE ){
		    $errors['image'] = "Image obligatoire !";
		}

		//Si aucune erreur n'est detecté
		if(empty($errors)){
			$filename = pathinfo($_FILES["image"]["name"], PATHINFO_FILENAME);
			$extention = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
			$newName = $filename."_".time().".".$extention;

			$imgUrl = "";
			if(uploadImage($_FILES["image"],$newName)){
				$imgUrl = $newName;
			};
			
			$serviceDetail = new ServiceItem('', $_POST['title'],$_POST['description'], $_POST['parent'], $imgUrl );
			
			if($serviceItemService->save($serviceDetail)){
				$message = '<div class="alert alert-success alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                Ajout effectuée, <a href="index.php?page=list-detail-service" class="alert-link">retour vers la liste des detail service .</a>.
	            </div>';
				echo $message;
			}			
			else {
				$message = '<div class="alert alert-danger alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                Erreur d\'ajout !
	            </div>';

				echo $message;
			}
		}

		else{
		    $message = '<div class="alert alert-danger alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	                
			foreach ($errors as $error) {
				$message = $message.$error.'<br>';
			}
			$message = $message .'</div>';

			echo $message;
		}
	}
	
?>

<div class="container-fluid">
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Ajout service detail </h1>
        </div>
    </div>
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    Formulaire d'ajout :
                </div>
                <div class="panel-body">
	               <form role="form" data-toggle="validator" class="form-horizontal" method="post" enctype="multipart/form-data" action="#">
		                <div class="form-group">
		                    <label class="control-label col-md-2" for="title">Titre :</label>
						    <div class="col-md-10">
						      <input type="text" name="title" class="form-control" id="title" placeholder="nom menu"  required >
						      <div class="help-block with-errors"></div>
						    </div>
		                </div>
		                
						<div class="form-group">
		                    <label class="control-label col-md-2" for="description">Description :</label>
						    <div class="col-md-10">
						      	<textarea  class="form-control summernote" rows="5" name="description" style="width:100%;" required ></textarea>
	                            <div class="help-block with-errors"></div>
						    </div>
		                </div>
		                <div class="form-group">
		                    <label class="control-label col-md-2" for="parent">Categorie service :</label>
						    <div class="col-md-10">
						    	
						      	<select class="form-control" name="parent" required>
						      		<option value=""></option>
						      		<?php
						      			$categories = $prestationService->getAll();
						      			
						      			foreach ($categories  as $categorie) {
											echo '<option value="'.$categorie->getId().'">'.$categorie->getTitle().'</option>';
										};
						      		?>
	                            </select>
	                            <div class="help-block with-errors"></div>
						    </div>
		                </div>
		                <div class="form-group">
		                    <label class="control-label col-md-2" for="image">
		                    	<p>Image Post :</p> 
		                	</label>
		                	<div class="col-md-10">
						      	<input  id="image" name="image" value="1" type="file" checked="true" required>
	                            <div class="help-block with-errors"></div>
						    </div>
		                </div>
		                <div class="col-md-push-2 col-md-10">
	                        <button type="submit" class="btn btn-success">Valider</button>
	                        <button type="reset" class="btn btn-info">Annuler</button>
                    	</div>
	                </form>
                </div>
		</div>
    </div>
</div>
<script src="js/summernote/summernote.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    $('.summernote').summernote({
	        height: 150,   //set editable area's height
	    });
    });
</script>