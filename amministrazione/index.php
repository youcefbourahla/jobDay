<?php
    include_once 'includes/db-config.php';
    if(!$userService->is_loggedin())
    {
        $userService->redirect('login.php');
    }
    $username = $_SESSION['user_session'];



$addtask = false;
$error = '';
$new = false;
$sort = 'date';


//var_dump($_GET);

if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'title') {
        $sort = 'title';
    } else if ($_GET['sort'] == 'priority') {
        $sort = 'priority';
    }
}

if (isset($_GET['addtask'])) {
    if ($_GET['addtask'] == 'ok') {
        $addtask = true;
    }
}

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'title'){
        $error = 'please provide a title';
    } else if ($_GET['error'] == 'title_length'){
        $error = 'title must be less than 140 characters';
    }
}

if (isset($_GET['delete'])) {
    deleteTask($_GET['delete']);
}

if (isset($_GET['new'])){
    if ($_GET['new'] == true) {
        $new = true;
    }
}

if (isset($_GET['clear'])){
    if ($_GET['clear'] == true) {
        clearTasks();
    }
}

if (isset($_GET['undo'])){
    if ($_GET['undo'] == true) {
        undoLastAction();
    }
}

/**
 * Returns an array containing the tasks in a csv file
 * 
 */
function listTasks(){
    $file = fopen('tasks.csv', 'r');
    $res = [];
    // while (! feof($file)) {
    //  $res[] = fgetcsv($file);
    // }
    while ($task = fgetcsv($file)) {
        $res[] = $task;
    }
    fclose($file);
    //if using the feof method : the last element of the list is a boolean 
    return $res;
}

/**
 *  Returns the highest ID +1 (next available ID), returns -1 if error
 */
function nextId($tasks){
    $highest = -1;
    foreach ($tasks as $key => $task) {
        if ($task[0] > $highest) {
            $highest = $task[0];
        }
    }
    return $highest+1;
}

/**
 * Displays tasklist as an html form
 *
 * 
 */
function taskToTable($tasks){
    echo "<form action='index.php' method='GET'>";
    echo "<table>";
    echo "<thead>
            <tr>
                <th><a href='index.php?sort=title'>Title</a></th>
                <th>Description</th>
                <th><a href='index.php'>Due Date</a></th>
                <th><a href='index.php?sort=priority'>Priority</a></th>
                <th><button>Delete checked</button></th>
            </tr>
        </thead>";
    foreach ($tasks as $i => $task) {
        if (is_array($task)) {
            if (isLate($task[3])){
                echo "<tr class='late'>";
            } else if(isToday($task[3])){
                echo "<tr class='today'>";
            } else {
                echo "<tr>";
            }
            foreach ($task as $j => $value) {
                if($j != 0){    
                    if($j == 4) {
                        echo "<td class='priority ".$value."'>";
                    } else {
                        echo "<td>";
                    }
                    echo $value."</td>";
                }   
            }
            echo "<td><input type='checkbox' name='delete[]' value='".$task[0]."'></td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "</form>";
}


/**
 * Sorts the task list by date, oldest first. Returns an array with sorted dates.
 *
 * 
 */
function sortByDate($tasks){
    $timestamps = [];
    $sortedtasks = [];
    foreach ($tasks as $i => $task) {
        $timestamps[] = strtotime($task[3]);
    }
    sort($timestamps);

    foreach ($tasks as $i => $task) {
        $sortedindex = array_search(strtotime($task[3]), $timestamps);
        $sortedtasks[$sortedindex] = $task;
        unset($timestamps[$sortedindex]);
    }
    
    ksort($sortedtasks); //BOOM!

    return($sortedtasks);
}

function sortByTitle($tasks){
    $titles = [];
    $sortedtasks = [];
    foreach ($tasks as $task) {
        $titles[] = $task[1];
    }
    sort($titles);
    foreach ($tasks as $task) {
        $index = array_search($task[1], $titles);
        $sortedtasks[$index] = $task;
        unset($titles[$index]);
    }
    ksort($sortedtasks);
    return($sortedtasks);
}

function sortByPriority($tasks){

}

function isLate($strDate){
    $taskDate = (strtotime($strDate));
    $now = strtotime(date('Y-m-d'));
    $diff = $taskDate - $now;
    if ($diff < 0) {
        return true;
    }
    return false;
}

function isToday($strDate){
    $taskDate = (strtotime($strDate));
    $now = strtotime(date('Y-m-d'));
    $diff = $taskDate - $now;
    if ($diff == 0) {
        return true;
    }
    return false;
}

function deleteTask($toDelete){
    $toKeep = [];
    $tasks  = listTasks();
    foreach ($tasks as $id => $task) {
        if (!in_array($task[0],$toDelete)){
            $toKeep[] = $task;
        }
    }
    copy('tasks.csv', 'tasks.csv.bak');
    $file = fopen('tasks.csv', 'w');
    foreach ($toKeep as $key => $task) {
        fputcsv($file, $task);
    }
    fclose($file);
}

function clearTasks(){
    copy('tasks.csv', 'tasks.csv.bak');
    $file = fopen("tasks.csv", 'w'); 
    fclose($file); 
}

function undoLastAction(){
    copy('tasks.csv.bak', 'tasks.csv');
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Startmin - <?php echo $username ?></title>


    <!-- global CSS -->
    <link href="css/global.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="css/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="css/dataTables/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Summer note Style -->
    <link href="js/summernote/summernote.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrapper">

    <?php
       include 'includes/header.php';
    ?>


    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Page Content -->
    <div id="page-wrapper">
        <?php
        include 'page.phtml';
        ?>
    </div>

</div>



<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Notify bootstrap Plugin JavaScript -->
<script src="js/bootstrap-notify.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>

<!-- Bootstrap Validator -->
<script type="text/javascript" src="js/validator.min.js"></script>

</body>
</html>

