<?php 
	/* check if someone try to access the folder of these files directly */
	if(strpos($_SERVER['REQUEST_URI'], '/pages/')) {
	    header("Location: ../404.php");
	}

	$path = $_SERVER['DOCUMENT_ROOT']."/site/";
	include $path.'amministrazione/services/FicheTechTitleService.class.php';
	
	include_once 'includes/db-config.php';
	include_once 'includes/upload.php';

	include 'classes/Product.class.php';
	include 'services/ProductService.class.php';
	include 'classes/ProductDetail.class.php';

	include 'services/ProductDetailService.class.php';

	if(!$userService->is_loggedin()) {
		$userService->redirect('login.php');
	}

	$productService = new ProductService($DB_con);
	$productDetailService = new ProductDetailService($DB_con);
	$ficheTechTitleService = new FicheTechTitleService($DB_con);
	
	// echo "<pre>";
	// echo print_r($_POST);
	// echo "</pre>";

	// $length = count($_POST['names']);
	// for ($i=0; $i < $length ; $i++) { 
	// 	echo "<br>".$i."<br>";
	// 	if(empty($_POST['names'][$i])) echo "empty";
	// 	if($_POST['names'][$i] == null) echo "null";
	// 	if($_POST['names'][$i]) echo "true";
	// 	if(!$_POST['names'][$i]) echo "false";
	// 	if($_POST['names'][$i] == "") echo "''";
	// 	if($_POST['names'][$i+1]) echo "out of bound";
	// }
	/*INITIALISATION*/
	$ficheTechs = $ficheTechTitleService->getAll();
	
	if( isset($_POST['name']) && isset($_POST['code']) && isset($_POST['description']) ) {
		$errors = [];

		/*CONDITIONS*/
		//Si le titre est vide ou qu'il contient des charactère spéciaux
		if( (isset($_POST['name'])) AND empty($_POST['name']) || !preg_match('/^[a-zA-Z0-9_ é]+$/', $_POST['name'])) {
		    $errors['name'] = "Non invalide (seulement caractére alphanumérique sont autorisés)";
		}
		if( (isset($_POST['code'])) AND empty($_POST['code'])) {
		    $errors['code'] = "Code produit Obligatoire";
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
			
			$product = new Product('', $_POST['name'],$_POST['description'], $_POST['code'], $imgUrl );
			
			$return = $productService->save($product);
			if( $return > 0 ) {
				$length = min(count($_POST['names']),count($_POST['values']));
	            if($length > 0){

		            for ($i=0; $i < $length ; $i++) { 
		            	if( !empty($_POST['names'][$i])  && !empty($_POST['values'][$i]) ) {
		            		$productDetail = new ProductDetail(null,$_POST['names'][$i],$_POST['values'][$i],$return,$_POST['fiche_title'][$i]);
		            		$productDetailService->save($productDetail);
		            	}
	        		}
	            }

				$message = '<div class="alert alert-success alert-dismissable">
	                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	                Ajout effectuée, <a href="index.php?page=list-produit" class="alert-link">retour vers la liste des produits.</a>.
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
            <h1 class="page-header">Ajout produit :</h1>
        </div>
    </div>
    <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    Formulaire d'ajout :
                </div>
                <div class="panel-body">
	               <form id="dynamic-form" role="form" data-toggle="validator" class="form-horizontal" method="post" enctype="multipart/form-data" action="#">
		                <div class="form-group">
		                    <label class="control-label col-md-2" for="name">Nom produit :</label>
						    <div class="col-md-10">
						      	<input type="text" name="name" class="form-control" id="name" placeholder="nom produit" required>
						      	<div class="help-block with-errors"></div>
						    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-md-2" for="code">Code produit :</label>
						    <div class="col-md-10">
						      	<input type="text" name="code" class="form-control" id="code" placeholder="code produit" required>
						      	<div class="help-block with-errors"></div>
						    </div>
		                </div>
		                
						<div class="form-group">
		                    <label class="control-label col-md-2" for="description">Description :</label>
						    <div class="col-md-10">
						      	<textarea  class="form-control summernote" rows="5" name="description" style="width:100%;" required></textarea>
	                            <div class="help-block with-errors"></div>
						    </div>
		                </div>

		                <div class="form-group">
		                    <label class="control-label col-md-2" for="image">
		                    	<p>Image produit :</p> 
		                	</label>
		                	<div class="col-md-10">
						      	<input  id="image" name="image" value="1" type="file" checked="true" required>
	                            <div class="help-block with-errors"></div>
						    </div>
		                </div>

		                <div><h3><i class="fa fa-plus"> </i> Fiche technique :</h3></div>
		                <div class="well form-group">

					        <div class="col-sm-4">
					            <span  data-title="Carateristique" class="input-title"><input type="text"   class="form-control" id="caractestique" name="names[]" /></span>
					        </div>
					        <div class="col-sm-3">
					            <span  data-title="Valeur" class="input-title"><input type="text"   class="form-control" name="values[]" /></span>
					        </div>
					        <div class="col-sm-3">
						    	<span data-title="titre englobant !"  class="input-title">
						    		<select name="fiche_title[]" class="form-control">
						    			<option></option>
						                <?php 
						                	foreach ($ficheTechs as $ficheTech) {
						                		echo '<option value="'.$ficheTech->getId().'">'.$ficheTech->getTitle().'</option>';
						            		}
						        		?>
						            </select>
						    	</span>
						    </div>
					        <div class="col-sm-2">
					            <span  data-title="&nbsp;" class="input-title"><button type="button" class="btn btn-primary addButton"><i class="fa fa-plus"></i></button></span>
					        </div>
					    </div>

					    <span id="insert"></span>

		                <div class="col-sm-10">
	                        <button type="submit" class="btn btn-success">Valider</button>
	                        <button type="reset" class="btn btn-info">Annuler</button>
                    	</div>
	                </form>
                </div>
			</div>
	    </div>
	</div>
</div>
<!-- The option field template containing an option field and a Remove button -->
<div class="well form-group hide" id="productTemplate">
	<div class="col-sm-4">
    	
        <span data-title="Carateristique"  class="input-title"><input type="text"  class="form-control" id="caractestique" name="names[]" placeholder='Carateristique'/></span>
    </div>
    <div class="col-sm-3">
    	<span data-title="Valeur"  class="input-title"><input type="text"  class="form-control" id="value" name="values[]" placeholder='Valeur' /></span>
    </div>

    <div class="col-sm-3">
    	<span data-title="titre englobant !"  class="input-title">
    		<select name="fiche_title[]" class="form-control">
    			<option></option>
                <?php 
                	foreach ($ficheTechs as $ficheTech) {
                		echo '<option value="'.$ficheTech->getId().'">'.$ficheTech->getTitle().'</option>';
            		}
        		?>
            </select>
    	</span>
    </div>
    <div class="col-sm-2">
        <span  data-title="&nbsp;" class="input-title"><button type="button" class="btn btn-danger removeButton"><i class="fa fa-minus"></i></button></span>
    </div>
</div>

<script src="js/summernote/summernote.js"></script>
<script type="text/javascript" src="js/product-attributes.js" ></script>
<script type="text/javascript">

	
</script>