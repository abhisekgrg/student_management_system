<?php
include './includes/db.php';
include 'sidebar.php';

$id = $_GET['id'];
$query = "SELECT * FROM students WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$student = $stmt->fetch();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (empty($_POST['first_name']) || !preg_match("/^[a-zA-Z\s]+$/", $_POST['first_name'])) {
        $errors[] = 'A valid first name is required (letters and spaces only).';
    }

    if (empty($_POST['last_name']) || !preg_match("/^[a-zA-Z\s]+$/", $_POST['last_name'])) {
        $errors[] = 'A valid last name is required (letters and spaces only).';
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email is required.';
    }

    if (empty($_POST['age']) || !filter_var($_POST['age'], FILTER_VALIDATE_INT) || $_POST['age'] <= 0 || $_POST['age'] > 50) {
        $errors[] = 'A valid age between 1 and 50 is required.';
    }

    $image_name = $student['img']; 
    if (!empty($_FILES['img']['name'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['img']['type'], $allowed_types)) {
            $errors[] = 'Only JPG, PNG, and GIF images are allowed.';
        }

        if ($_FILES['img']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'The image file size should not exceed 2MB.';
        }

        
        if (empty($errors)) {
            $image_name = time() . '_' . $_FILES['img']['name'];
            $image_tmp = $_FILES['img']['tmp_name'];
            $image_path = "./assets/img/" . $image_name;
            move_uploaded_file($image_tmp, $image_path);

            
            if (!empty($student['img']) && file_exists("./assets/img/" . $student['img'])) {
                unlink("./assets/img/" . $student['img']);
            }
        }
    }

    
    if (empty($errors)) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $age = $_POST['age'];

        $query = "UPDATE students SET first_name = ?, last_name = ?, email = ?, age = ?, img = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$first_name, $last_name, $email, $age, $image_name, $id]);

        header("Location: ./index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/utility.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="section">
        <div class="container">
            <h2>Edit Student: <?php echo $student['first_name'] ?></h2>
            <?php
           
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p class='alert alert-danger'>$error</p>";
                }
            }
            ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="firstName" value="<?= htmlspecialchars($student['first_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="lastName" value="<?= htmlspecialchars($student['last_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($student['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" name="age" id="age" value="<?= htmlspecialchars($student['age']); ?>" required>
                </div>
              
                <?php if (!empty($student['img'])): ?>
                    <div class="mb-3">
                        <label for="currentImg" class="form-label">Current Image</label><br>
                        <img src="./assets/img/<?= htmlspecialchars($student['img']); ?>" alt="Student Image" style="width: 150px; height: auto;"><br><br>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="img" class="form-label">Upload New Image</label>
                    <input type="file" class="form-control" name="img" id="img" accept="image/*">
                </div>

                <button style="background-color:#2271b1;" type="submit" class="btn btn-primary">Update Student</button>
            </form>
        </div>
    </div>
</body>
</html>
