<?php
    session_start();
    include_once("koneksi.php");

    // Redirect to login page if user is not logged in and is trying to access a restricted page
    if (!isset($_SESSION['is_authenticated']) && (!isset($_GET['page']) || !in_array($_GET['page'], ['loginUser', 'registrasiUser']))) {
        header("Location: index.php?page=loginUser");
        exit();
    }

    // Handle logout functionality
    if (isset($_GET['page']) && $_GET['page'] === 'logout') {
        session_unset();
        session_destroy();
        header("Location: index.php?page=loginUser");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sistem Informasi Poliklinik</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data Master
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
                            <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=periksa">Periksa</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'] === true): ?>
                        <!-- Show Logout if user is logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- Show Register and Login if user is not logged in -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=registrasiUser">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=loginUser">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <main role="main" class="container my-4">
        <?php
        // Load the requested page if it exists
        if (isset($_GET['page'])) {
            $page = basename($_GET['page']); // Sanitize the input to avoid directory traversal
            $allowed_pages = ['loginUser', 'registrasiUser', 'dokter', 'pasien', 'periksa'];
            
            if (in_array($page, $allowed_pages) && file_exists($page . ".php")) {
                echo "<h2>" . ucwords($page) . "</h2>";
                include($page . ".php");
            } else {
                echo "<div class='alert alert-danger'>Page not found.</div>";
            }
        } else {
            echo "<h2>Selamat Datang di Sistem Informasi Poliklinik</h2>";
        }
        ?>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
