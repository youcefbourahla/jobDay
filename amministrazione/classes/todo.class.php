<?php
class TODO
{
    private $db;
    private $title;
    private $description;
    private $date;
    private $priority;

    public function gettitle() {
      return $this->title;
    } 

    public function getDescription() {
      return $this->description;
    } 

    public function getDate() {
      return $this->date;
    } 
    public function getPriority() {
      return $this->priority;
    } 

    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function addTodo($title,$description,$date,$priority)
    {
       try
       {
           
   
           $stmt = $this->db->prepare("INSERT INTO todo (id,title,description,date,priority) 
                                                       VALUES('',:title, :description, :date,:priority)");
              
           $stmt->bindparam(":title", $title);
           $stmt->bindparam(":description", $description);
           $stmt->bindparam(":date", $date);   
           $stmt->bindparam(":priority", $priority);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    
 
   
 
   

}
?>