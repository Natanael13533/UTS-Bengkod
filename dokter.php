<!-- Form -->
<form action="" method="POST" name="myForm" onsubmit="return validate();">
    <?php
        // Initialize variables
        $nama = '';
        $alamat = '';
        $no_hp = '';
        
        // koneksi database
        $mysqli = mysqli_connect('localhost', 'root', '', 'poliklinik');

        // Check if the 'id' parameter is set in the GET request
        if (isset($_GET['id'])) {
            // Fetch the data from the database
            $ambil = mysqli_query($mysqli, "SELECT * FROM dokter WHERE id='" . $_GET['id'] . "'");
            
            // Check if the query was successful and fetch data
            if ($ambil) {
                while ($row = mysqli_fetch_array($ambil)) {
                    $nama = $row['nama'];
                    $alamat = $row['alamat'];
                    $no_hp = $row['no_hp'];
                }
            } else {
                echo "Error: " . mysqli_error($mysqli);
            }
    ?>
        <!-- Hidden input for the ID -->
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <?php
        }
    ?>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?php echo $nama ?>">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="<?php echo $alamat ?>">
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No. HP</label>
            <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="No. HP" value="<?php echo $no_hp ?>">
        </div>
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
</form>
<br>
<!-- Table -->
<table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No. HP</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut berdasarkan status dan tanggal awal-->
            <?php
                $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++; ?></th>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td><?php echo $data['no_hp']; ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id']; ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3"href="index.php?page=dokter&id=<?php echo $data['id']; ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <script>
        function validate() {
            let nama = document.forms["myForm"]["nama"].value;
            let alamat = document.forms["myForm"]["alamat"].value;
            let no_hp = document.forms["myForm"]["no_hp"].value;

            if (nama === "") {
                alert("Nama kosong");
                return false;
            }
            if (alamat === "") {
                alert("Alamat kosong");
                return false;
            }
            if (no_hp === "") {
                alert("No. HP kosong");
                return false;
            }
            return true;
        }
    </script>


<?php
    if (isset($_POST['simpan'])) { // Corrected $_POST
        if (isset($_POST['id'])) {
            // mengubah/update data
            $ubah = mysqli_query($mysqli, "UPDATE dokter SET
                                            nama = '" . $_POST['nama'] . "',
                                            alamat = '" . $_POST['alamat'] . "',
                                            no_hp = '" . $_POST['no_hp'] . "'
                                            WHERE id = '" . $_POST['id'] . "'");
        } else {
            // menambahkan data
            $tambah = mysqli_query($mysqli, "INSERT INTO dokter(nama, alamat, no_hp)
                                             VALUES (
                                                 '" . $_POST['nama'] . "',
                                                 '" . $_POST['alamat'] . "',
                                                 '" . $_POST['no_hp'] . "'
                                             )");
        }

        // Redirect setelah mengubah data
        echo "<script>
                document.location='index.php?page=dokter';
              </script>";
    }

    if (isset($_GET['aksi'])) { // Corrected $_GET
        if ($_GET['aksi'] == 'hapus') {
            // Hapus data
            $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
        }

        // Redirect setelah mengubah status
        echo "<script>
                document.location='index.php?page=dokter';
              </script>";
    }
?>