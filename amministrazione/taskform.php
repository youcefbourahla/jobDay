<?php
    require_once 'includes/db-config.php';

    
    if(isset($_POST['btn-add-task']))
    {
     
     echo "hahahahaaaaa";
    
	$title = $_POST['title'];
	$description = $_POST['content'];
	$date = $_POST['year']."-".sprintf("%02s",$_POST['month'])."-".sprintf("%02s",$_POST['day']);
	$priority =	$_POST['priority'];
        $verif = "false";

      
                if($TodoService->add_todo($title,$description,$date,$priority))
                {
                    $TodoService->redirect('index.php');
                    return true;
                }
                else
                {
                    $error = "Wrong Details !";
                    return false;
                } 
        }
        
    
?>
<form action="form" method="post">
	<fieldset>
		<legend>New Task</legend>
		<input type="hidden" name="taskid" id="taskid" value=
		<?php echo nextId(listTasks()); ?>
		>
		<label for="title">Title : </label>
		<input type="text" name="title" id="title" placeholder="title"><br>
		<textarea name="content" id="content" cols="30" rows="10"></textarea><br>
		<label for="year">Due date :</label>
		<select name="year" id="year">
			<?php  
				echo date("Y");
				for ($i=date("Y"); $i <= (date("Y")+10); $i++) { 
					echo "<option value='$i'>$i</option>";
				}
			?>				
		</select>
		<select name="month" id="month">
			<?php 
				for ($m=1; $m<=12; $m++) {
				    $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
				    if ($month == date('F')){
				    	echo "<option value='".$m."' selected>".$month."</option>";
				    } else {
					    echo "<option value='".$m."'>".$month."</option>";
				    }
			    }
			?>

		</select>
		<select name="day" id="day">
			<?php for ($i=1; $i <= 31; $i++): ?> 
				<option value=
					<?php echo (date('j')==$i)?"'".$i."' selected":"'".$i."'"; ?>
					>
				<?php echo $i; ?>
			</option>
			<?php endfor; ?>
		</select>
		<br>
		<label for="priority">Priority : </label>
		<select name="priority" id="priority">
			<option value="minor">minor</option>
			<option value="low">low</option>
			<option value="normal" selected>normal</option>
			<option value="high">high</option>
			<option value="critical">critical</option>
		</select>
		<br>
		<button type='submit' name="btn-add-task" >ok</button>
	</fieldset>
</form>