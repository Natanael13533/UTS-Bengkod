<div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow" style="width: 30rem;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Login</h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
            </form>
            <p class="mt-4">Sudah Punya Akun, <a href="index.php?page=registrasiUser">Daftar</a></p>
        </div>
    </div>
</div>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Retrieve the user from the database
        $stmt = $mysqli->prepare("SELECT id, password FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Set session variable to indicate the user is logged in
                $_SESSION['is_authenticated'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;

                // Redirect to the main page
                header("Location: index.php");
                exit();
            } else {
                echo "<script>
                        alert('Password Salah');
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Login Invalid');
                  </script>";
        }

        $stmt->close();
    }
?>