<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo-List-PHP by Goodness</title>
</head>
<body>
    <?php
    ///Coded By Goodness(Dev Craea8ive)
    ///Let's Connect our database
    $db = mysqli_connect('localhost', 'root', '', 'todo') or die("Could not connect to DB");
    //Define the input - todoval
    $todoval = '';
    $update = 0;
    /*if the button that has the name addtodo is clicked
    begin query
    */
    if(isset($_POST['addtodo'])){
        $todoval = $_POST['todoval'];
        $sql = "INSERT INTO todos (todoval) VALUES ('$todoval')";
        mysqli_query($db, $sql);
        $_SESSION['msg'] = "Todo added successfully!!!";
        $_SESSION['alertType'] = "success";

    }
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $sql = "DELETE FROM todos WHERE id=$id";
        mysqli_query($db, $sql);
        $_SESSION['msg'] = "Todo Deleted successfully!!!";
        $_SESSION['alertType'] = "danger";
    }
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $update = 1;
        $sql = "SELECT * FROM todos WHERE id=$id";
        $result = mysqli_query($db, $sql);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $todoval = $row['todoval'];
        }
    }
    if(isset($_POST['updatetodo'])){
        $id = $_POST['id'];
        $todoval = $_POST['todoval'];
        $sql = "UPDATE todos SET todoval='$todoval' WHERE id='$id'";
        mysqli_query($db, $sql);
        $_SESSION['msg'] = "Todo Updated successfully!!!";
        $_SESSION['alertType'] = "warning";

    }
    ?>
    <?php
    if(isset($_SESSION['msg'])):
    ?>
    <div class="alert alert-<?php echo $_SESSION['alertType'];?>">
    <h2>
<?php
echo $_SESSION['msg'];
unset($_SESSION['msg']);
?>
</h2>
</div>
    <?php endif?>
     <h1>PHP Todo-List By Goodness <a href="index.php"><span class="glyphicon glyphicon-list" style="color: crimson;"></span></a></h1>
<div class="todo">
    <form action="index.php" method="post">
        <div class="todoRow">
        <span id="ll" class="glyphicon glyphicon-list"></span>
        <input type="hidden" name='id' value="<?php echo $id;?>">
        <input type="text" value="<?php echo $todoval;?>" class="todoIn" name='todoval' placeholder="Add Todo">
        <?php if($update == 1) :?>
         <button class="addBtn up" name="updatetodo"><span class="glyphicon glyphicon-plus"></span></button>
         <?php else:?>
        <button class="addBtn" name="addtodo"><span class="glyphicon glyphicon-plus"></span></button>  
         <?php endif;?>      
        </div>
    </form>
    <?php
    $sql = "SELECT * FROM todos";
    $result = mysqli_query($db, $sql);
    
    while($row = mysqli_fetch_array($result)) :
    ?>
    <div class="list">
            <li><?php echo $row['todoval']?><a href="index.php?delete=<?php echo $row['id'];?>"><span class="glyphicon glyphicon-minus"><a href="index.php?edit=<?php echo $row['id'];?>"><span class="glyphicon glyphicon-pencil"></span></a></li>
        </div>
    <?php endwhile;?>
</div>
</body>
</html>
