<?php
class UserService
{
	private $db;

	function __construct($DB_con)
    {
      $this->db = $DB_con;
    }

    public function login($name , $password) {
    	try
        {
			$stmt = $this->db->prepare("SELECT * FROM user WHERE username=:uname");
			$stmt->execute(array(':uname'=>$name));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() > 0)
			{
				if(password_verify($password, $userRow['password']))
				{
					$_SESSION['user_session'] = $userRow['username'];
					return true;
				}
				else
				{   
					return false;
				}
			}
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }	

   	public function is_loggedin()
   	{
      	if(isset($_SESSION['user_session']))
    	{
	        return true;
      	}
      	return false;
   	}

   	public function redirect($url)
	{
	 	header("Location: $url");
	}
 
    public function logout()
   	{
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   	}

    public function add_user($username,$password)

    {
      try {
        $db_pw = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("INSERT INTO user (id,username, password) VALUES ('',:username,:password)");
            $result = $stmt->execute(array(
              ':username'   => $username,
              ':password' => $db_pw
              
            ));
            return $result;
        }
        catch(PDOException $e)
        {
           echo $e->getMessage();
        }
        
    }
}