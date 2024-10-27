<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/utility.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Sidebar</title>
</head>

<body>
    <div class="sidebar-section">


        <ul class="nav flex-column">
        <?php 

    $current_url = $_SERVER['REQUEST_URI'];

   
    if (strpos($current_url, '/views/') !== false) {
        $dashboard_link = '../index.php';
    } else {
        $dashboard_link = 'index.php';      
    }
?>
            <li class="nav-item">
                <a class="nav-link active  text-dark" aria-current="page" href="<?php echo $dashboard_link ?>"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  text-dark" href="<?php echo $dashboard_link ?>"> <i class="fa fa-user me-2"></i>Manage Students</a>
            </li>
            <li class="nav-item">
                <a class="nav-link  text-dark" href="views/add.php"><i class="fas fa-user-plus me-2"></i> Add Students</a>
            </li>

        </ul>
    </div>
    <div class="topbar">
      <p>Student Management System</p>
      <p>Abhisek Gurung</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>