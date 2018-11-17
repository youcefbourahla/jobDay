<?php
    require_once 'includes/db-config.php';

    if($userService->is_loggedin()!="")
    {
       $userService->redirect('index.php');
    }
    if(isset($_POST['btn-login']))
    {
        $uname = $_POST['form-username'];
        $upass = $_POST['form-password'];
      
        if($userService->login($uname,$upass))
        {
            $userService->redirect('index.php');
        }
        else
        {
            $error = "Wrong Details !";
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
                            <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis quam numquam</h5>
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
                                    <a href="#" class="bold"> Forgot password?</a>
                                </div>   

                                <div class="form-group">     
                                    <button type="submit" name="btn-login" class="btn btn-default form-control"><strong>Sign in</strong></button>  
                                </div>   
                                                                              
                            </form>
                        </div> <!-- end  login-body -->                     
                    </div><!-- end  login-content -->  
                    <div class="login-footer text-center template">
                        <h5>Don't have an account?<a href="signup.php" class="bold"> Sign up </a>     </h5>
                                          
                    </div>
                </div>  <!-- end  login-container -->      

            </div>
        </div><!-- end container -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>

</html>
