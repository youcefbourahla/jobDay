<?php
    require_once 'includes/db-config.php';

    if($userService->is_loggedin()!="")
    {
       $userService->redirect('index.php');
    }
    if(isset($_POST['btn-signup']))
    {
        $uname = $_POST['form-username'];
        $upass = $_POST['form-password'];
        $verif = "false";

      if (filter_var($uname, FILTER_VALIDATE_EMAIL)) {
            $verif="true";

        } else {
            $verif="false";
        }

         if($verif!="true"){
alert("Veuillez remplir correctement tous les champs");
        }
        else 
            {
                if($userService->add_user($uname,$upass))
                {
                    $userService->redirect('index.php');
                }
                else
                {
                    $error = "Wrong Details !";
                } 
        } 
        
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login form</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/custom.css">
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">

    </head>

    <body>
        <div class="container ">
            <div class="row">            
                <div class="login-container col-lg-4 col-md-6 col-sm-8 col-xs-12">
                     <div class="login-title text-center">
                            <h2><span>Logo<strong>Name</strong></span></h2>
                     </div>
                    <div class="login-content">
                        <div class="login-header ">
                            <h3><strong>Welcome,</strong></h3>
                            
                        </div>
                        <div class="login-body">
                            <form role="form" action="" method="post" class="login-form">
                                <div class="form-group ">
                                    <div class="pos-r">                                        
                                        <input   id="form-username" type="text" name="form-username" placeholder="Username..." class="form-username form-control">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="pos-r">                                    
                                        <input id="form-password" type="password" name="form-password" placeholder="Password..." class="form-password form-control" >
                                        <i class="fa fa-lock"></i>                                        
                                    </div>
                                </div>
                                <div class="form-group text-right">     
                                   
                                </div>   

                                <div class="form-group">     
                                    <button type="submit" name="btn-signup" class="btn btn-default form-control"><strong>Create Account</strong></button>  
                                </div>   
                                                                              
                            </form>
                        </div> <!-- end  login-body -->                     
                    </div><!-- end  login-content -->  
                    <div class="login-footer text-center template">
                       
                                          
                    </div>
                </div>  <!-- end  login-container -->      

            </div>
        </div><!-- end container -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>

</html>
