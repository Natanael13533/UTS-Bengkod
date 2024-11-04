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
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="mt-4">Sudah Punya Akun, <a href="index.php?page=loginUser">Login</a></p>
        </div>
    </div>
</div>