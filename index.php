<?php
    //DB connection
    $db = mysqli_connect('localhost', 'root', '', 'todo');
    $errors = "";

    //Insert task to DB
    if(isset($_POST['submit'])){
        $task = $_POST['task'];

        if(empty($task)){
            $errors = "Task cannot be empty!";
        }
        else{
            mysqli_query($db, "INSERT INTO todo (task) VALUES ('$task')");
            header('location: index.php');
        }
    }

    //Delete task
    if(isset($_GET['del-task'])){
        $id = $_GET['del-task'];
        mysqli_query($db, "DELETE FROM todo WHERE id=$id");
        header('location: index.php');
    }

    //Get all tasks
    $tasks = mysqli_query($db, "SELECT * FROM todo");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <title>Todo List</title>

    <style>
        section{
            background-image: url("./blob.svg");
            background-repeat: no-repeat;
            background-size : cover;
            background-attach: fixed;
        }

        #card{
            background-color : rgba(255, 255, 255, 0.8);
            border-radius : 10px;
        }
    </style>

</head>
<body>
    <section class="min-vh-100" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7" >
                    <div class="card" id="card">
                        <div class="card-body p-4">
                            <h2 class="text-center my-3 pb-3">To-Do List</h2>
                            
                            <?php if(isset($errors)){ ?>
                                <div class="col-10 text-center text-danger"> <?php echo $errors; ?> </div>
                            <?php } ?>

                            <form action="index.php" method="POST" class="row row-cols-lg-auto g-3 justify-content-center align-items-center mb-4 pb-2">
                                <div class="col-12">
                                    <div class="form-outline">
                                        <input type="text" name="task" class="form-control" placeholder="Enter a task here"/>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" name="submit">Add</button>
                                </div>
                            </form>

                            <table class="text-center table mb-4">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tasks</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; while($row = mysqli_fetch_array($tasks)){ ?>
                                        <tr>
                                            <th scope="row"><?php echo $i; ?></th>
                                            <td><?php echo $row['task']; ?></td>
                                            <td>
                                                <a class="btn btn-danger py-1 px-2" href="index.php?del-task=<?php echo $row['id']; ?>">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>