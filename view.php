<?php
include './includes/db.php';
include 'sidebar.php';


$id = $_GET['id'];
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$student = $stmt->fetch();

 if(!$student){
    echo "Student not found";
    exit;
 }
    


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $student['first_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/utility.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="section">
        <div class="container">
            <h2>Student Information</h2>
          
            
            <?php if (!empty($student['img'])): ?>
                <div class="mb-3">

                    <img src="./assets/img/<?= htmlspecialchars($student['img']); ?>" alt="Student Image"
                        style="width: 150px; height: 200px; object-fit:cover;"><br><br>
                </div>
                <?php endif; ?>
            <table class="table" style="width:400px;">

            <tr>
                    <th> Student Id : </th>

                    <td> <?php echo $student['id']; ?></td>
                </tr>
                <tr>
                    <th>Full Name : </th>
                    <td>
                        <?php echo $student['first_name']; ?>
                        <?php echo $student['last_name']; ?> </td>

                </tr>
                <tr>
                    <th> Email : </th>

                    <td> <?php echo $student['email']; ?></td>
                </tr>
           
                <tr>
                    <th> Age : </th>

                    <td> <?php echo $student['age']; ?></td>
                </tr>
               
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>