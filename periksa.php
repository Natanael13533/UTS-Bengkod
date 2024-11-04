<!-- Form -->
<form action="" method="POST" name="myForm" onsubmit="return validate();">
    <?php
        // Initialize variables
        $id_pasien = '';
        $id_dokter = '';
        $tgl_periksa = '';
        $catatan = '';
        $obat = '';
        
        // koneksi database
        $mysqli = mysqli_connect('localhost', 'root', '', 'poliklinik');

        // Check if the 'id' parameter is set in the GET request
        if (isset($_GET['id'])) {
            // Fetch the data from the database
            $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
            
            // Check if the query was successful and fetch data
            if ($ambil) {
                while ($row = mysqli_fetch_array($ambil)) {
                    $id_pasien = $row['id_pasien'];
                    $id_dokter = $row['id_dokter'];
                    $tgl_periksa = $row['tgl_periksa'];
                    $catatan = $row['catatan'];
                    $obat = $row['obat'];
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
            <label for="id_pasien" class="sr-only">Pasien</label>
            <select class="form-control" name="id_pasien">
                <?php
                $selected = '';
                // Replace `mysqli` with your connection variable, e.g., `$conn`
                $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                while ($data = mysqli_fetch_array($pasien)) {
                    // Assume `$id_pasien` is the currently selected ID, defined before this code block
                    if ($data['id'] == $id_pasien) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id']; ?>" <?php echo $selected; ?>><?php echo $data['nama']; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_dokter" class="sr-only">Dokter</label>
            <select class="form-control" name="id_dokter">
                <?php
                $selected = '';
                // Replace `mysqli` with your connection variable, e.g., `$conn`
                $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
                while ($data = mysqli_fetch_array($dokter)) {
                    // Assume `$id_dokter` is the currently selected ID, defined before this code block
                    if ($data['id'] == $id_dokter) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id']; ?>" <?php echo $selected; ?>><?php echo $data['nama']; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tgl_periksa" class="form-label">Tanggal Periksa</label>
            <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" value="<?php echo $tgl_periksa ?>">
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <input type="text" class="form-control" id="catatan" name="catatan" placeholder="Catatan" value="<?php echo $catatan ?>">
        </div>
        <div class="mb-3">
            <label for="obat" class="form-label">Obat</label>
            <input type="text" class="form-control" id="obat" name="obat" placeholder="Obat" value="<?php echo $obat ?>">
        </div>
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
</form>
<br>
<!-- Table -->
<table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Pasien</th>
                <th scope="col">Dokter</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">Catatan</th>
                <th scope="col">Obat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut berdasarkan status dan tanggal awal-->
            <?php
                $result = mysqli_query($mysqli, "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++; ?></th>
                    <td><?php echo $data['nama_pasien']; ?></td>
                    <td><?php echo $data['nama_dokter']; ?></td>
                    <td><?php echo $data['tgl_periksa']; ?></td>
                    <td><?php echo $data['catatan']; ?></td>
                    <td><?php echo $data['obat']; ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id']; ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3"href="index.php?page=periksa&id=<?php echo $data['id']; ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <script>
        function validate() {
            let tgl_periksa = document.forms["myForm"]["tgl_periksa"].value;
            let catatan = document.forms["myForm"]["catatan"].value;
            let obat = document.forms["myForm"]["obat"].value;

            if (tgl_periksa === "") {
                alert("Tanggal periksa kosong");
                return false;
            }
            if (catatan === "") {
                alert("Catatan kosong");
                return false;
            }
            if (obat === "") {
                alert("Obat kosong");
                return false;
            }
            return true;
        }
    </script>


<?php
    if (isset($_POST['simpan'])) { // Corrected $_POST
        if (isset($_POST['id'])) {
            // mengubah/update data
            $ubah = mysqli_query($mysqli, "UPDATE periksa SET
                                            id_pasien = '" . $_POST['id_pasien'] . "',
                                            id_dokter = '" . $_POST['id_dokter'] . "',
                                            tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                            catatan = '" . $_POST['catatan'] . "',
                                            obat = '" . $_POST['obat'] . "'
                                            WHERE id = '" . $_POST['id'] . "'");
        } else {
            // menambahkan data
            $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien, id_dokter, tgl_periksa, catatan, obat)
                                             VALUES (
                                                 '" . $_POST['id_pasien'] . "',
                                                 '" . $_POST['id_dokter'] . "',
                                                 '" . $_POST['tgl_periksa'] . "',
                                                 '" . $_POST['catatan'] . "',
                                                 '" . $_POST['obat'] . "'
                                             )");
        }

        // Redirect setelah mengubah data
        echo "<script>
                document.location='index.php?page=periksa';
              </script>";
    }

    if (isset($_GET['aksi'])) { // Corrected $_GET
        if ($_GET['aksi'] == 'hapus') {
            // Hapus data
            $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
        }

        // Redirect setelah mengubah status
        echo "<script>
                document.location='index.php?page=periksa';
              </script>";
    }
?>