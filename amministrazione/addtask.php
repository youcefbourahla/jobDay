<?php 

	var_dump($_POST);

	if (isset($_POST['taskid']) &&
		isset($_POST['title']) && 
		isset($_POST['content']) && 
		isset($_POST['year']) &&
		isset($_POST['month']) && 
		isset($_POST['day']) && 
		isset($_POST['priority'])){
		
		//todo: controles sur les donnees
		if (empty($_POST['title'])) {
			header("Location: index.php?error=title");
			die();
		}
		if (strlen($_POST['title'])>140){
			header("Location: index.php?error=title_length");
			die();
		}

		$date = $_POST['year']."-".sprintf("%02s",$_POST['month'])."-".sprintf("%02s",$_POST['day']);
		$task = [$_POST['taskid'],$_POST['title'],$_POST['content'],$date,$_POST['priority']];
		var_dump($task);


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
		copy('tasks.csv', 'tasks.csv.bak');

		$file = fopen('tasks.csv', 'a');
		fputcsv($file, $task);
		fclose($file);

	}

	header("Location: index.php?addtask=ok");
	die();

	// header('refresh:5;url=index.php');

