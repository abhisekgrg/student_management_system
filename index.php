<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Management System</title>
    <link rel="stylesheet" href="./assets/css/utility.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    require 'includes/db.php';
    include 'views/sidebar.php';

    
    $query = "SELECT * FROM students";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>



    <div class="section">
        <div class="container">
            <h1>Students List</h1>
            <div>
                <table class="table table-striped table-hover " style="border:1px solid #d6d6d6">
                    <thead class="table-dark">
                        <tr >
                            <th scope="col">Id</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Age</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
              foreach ($students as $student):
              ?>
                        <tr>
                            <th scope="row"><?php echo $student['id'] ?></th>
                            <td><?php echo $student['first_name'] ?></td>
                            <td><?php echo $student['last_name'] ?></td>
                            <td><?php echo $student['email'] ?></td>
                            <td><?php echo $student['age'] ?></td>
                            <td>
                                <?php if ($student['img']): ?>
                                <img src="assets/img/<?php echo $student['img']; ?>" alt="Student Image"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                <?php else: ?>
                                <p>No image available</p>
                                <?php endif; ?>
                            </td>
                            <td class="action-buttons">
                                <a href="views/view.php?id=<?php echo $student['id']; ?>">

                                    <button class="btn btn-success">View</button>
                                </a>
                                <a href="views/edit.php?id=<?php echo $student['id']; ?>">

                                    <button class="btn btn-primary">Edit</button>
                                </a>
                                <a href="delete.php?id=<?php echo $student['id']; ?>">
                                  
                                  <button class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>