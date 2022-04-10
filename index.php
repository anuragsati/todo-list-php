<?php
    //DB connection
    $db = mysqli_connect('localhost', 'root', '', 'todo');
    $errors = "";

    if(isset($_POST['submit'])){
        $task = $_POST['task'];

        if(empty($task)){
            $errors = "Enter an item";
        }
        else{
            mysqli_query($db, "INSERT INTO todo (task) VALUES ('$task')");
            header('location: index.php');
        }
    }

    //delete todo task
    if(isset($_GET['del-task'])){
        $id = $_GET['del-task'];
        mysqli_query($db, "DELETE FROM todo WHERE id=$id");
        header('location: index.php');
    }

    $tasks = mysqli_query($db, "SELECT * FROM todo");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo app</title>
</head>
<body>
    <div class="heading">Todo List</div>
    <form action="index.php" method="POST">
        <?php if(isset($errors)){ ?>
            <p> <?php echo $errors; ?> </p>
        <?php } ?>

        <input type="text" name="task" id="task-input">
        <button type="submit" class="submit-btn" name="submit">Add Task</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tasks</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $i=1; while($row = mysqli_fetch_array($tasks)){ ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row['task']; ?></td>
                    <td>
                        <a href="index.php?del-task=<?php echo $row['id']; ?>">X</a>
                    </td>
                </tr>
            <?php $i++; } ?>
        </tbody>
    </table>
</body>
</html>