<?php
include './includes/db.php';
include 'sidebar.php';

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

    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['img']['type'], $allowed_types)) {
            $errors[] = 'Only JPG, PNG, and GIF images are allowed.';
        }

        if ($_FILES['img']['size'] > 2 * 1024 * 1024) {
            $errors[] = 'The image file size should not exceed 2MB.';
        }
    } else {
        $errors[] = 'An image is required.';
    }

    if (empty($errors)) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $age = $_POST['age'];

        if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $target_dir = "./assets/img/"; 
            $img = time() . '_' . basename($_FILES['img']['name']); 
            $target_file = $target_dir . $img;

            if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
                $query = "INSERT INTO students (first_name, last_name, email, age, img) VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$first_name, $last_name, $email, $age, $img]);

                echo "<p style='margin-top:50px;margin-left:200px;' class='alert alert-success'>Student added successfully!</p>";
            } else {
                echo "<p class='alert alert-danger'>Error uploading image.</p>";
            }
        }
    } else {
        foreach ($errors as $error) {
            echo "<p class='alert alert-danger'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/utility.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="section">
        <div class="container">
            <h2>Add New Student</h2>

            <form method="POST" action="" enctype="multipart/form-data" id="studentForm">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="firstName" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="lastName" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" name="age" id="age" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" name="img" id="img" accept="image/*" required>
                </div>
                <button style="background-color:#2271b1;" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('studentForm').addEventListener('submit', function (e) {
            const img = document.getElementById('img').files[0];
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const age = parseInt(document.getElementById('age').value);

            if (firstName.trim() === '' || /[^a-zA-Z\s]/.test(firstName)) {
                alert('First name must contain only letters and spaces.');
                e.preventDefault();
            }

            if (lastName.trim() === '' || /[^a-zA-Z\s]/.test(lastName)) {
                alert('Last name must contain only letters and spaces.');
                e.preventDefault();
            }

            if (age < 1 || age > 50) {
                alert('Age must be between 1 and 50.');
                e.preventDefault();
            }

            if (img) {
                const maxFileSize = 2 * 1024 * 1024; 
                if (img.size > maxFileSize) {
                    alert('File size should not exceed 2MB');
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>
