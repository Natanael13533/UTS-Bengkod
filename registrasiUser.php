<div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow" style="width: 30rem;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Register</h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="register">Register</button>
            </form>
            <p class="mt-4">Sudah Punya Akun, <a href="index.php?page=loginUser">Login</a></p>
        </div>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Passwords do not match!');
              </script>";
    } else {
        // Check if username is already taken
        $stmt = $mysqli->prepare("SELECT id FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Username is already taken
            echo "<script>
                    alert('Username is already taken!');
                  </script>";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $mysqli->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                // Display a JavaScript alert and redirect to the login page
                echo "<script>
                        alert('User successfully registered!'); 
                        window.location.href = 'index.php?page=loginUser';
                      </script>";
                exit();
            } else {
                // Handle error if the insert fails
                echo "<script>
                        alert('Registration failed. Please try again.');
                      </script>";
            }
        }
        $stmt->close();
    }
}
?>
