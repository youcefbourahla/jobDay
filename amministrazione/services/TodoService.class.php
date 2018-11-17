<?php
include_once $path.'amministrazione/classes/todo.class.php';
class TodoService
{
	private $db;

	function __construct($DB_con)
    {
      $this->db = $DB_con;
    }

  


    public function add_todo($title,$description,$date,$priority)

    {
      try {
      
        
            $stmt = $this->db->prepare("INSERT INTO todo (id,title, description,date,priority) VALUES ('',:title,:description,:date,:priority)");
            $result = $stmt->execute(array(
              ':title'   => $_POST['title'],
              ':description' => $_POST['content'],
              ':date'   => $date,
              ':priority' => $_POST['priority']

              
            ));
            return $result;
        }
        catch(PDOException $e)
        {
           echo $e->getMessage();
        }
        
    }

    public function getAll() {

      $products = array();
    try
        {
        $sql =  'SELECT * FROM todo';
        if ($res =  $this->db->query($sql)) {
            if ($res->fetchColumn() > 0) {
              foreach  ($this->db->query($sql) as $todoRow) {
            $todo = new todo($todoRow['id'], $todoRow['title'], $todoRow['description'], $todoRow['date'], $todoRow['priority']);
            array_push($todos, $todo);
                  };
                }
          }
          return $todos;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return $products;
        }
    }
}