<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['add'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $jk = $_POST['jenis_kelamin'];
    
    $query = "INSERT INTO member (nama, alamat, telp, jenis_kelamin) VALUES ('$nama', '$alamat', '$telp', '$jk')";
    mysqli_query($conn, $query);
    header("Location: members.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM member WHERE id = $id");
    header("Location: members.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Member - Laundry Tenka</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <a href="dashboard.php" class="nav-brand">Laundry Tenka</a>
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="outlets.php">Outlet</a>
            <a href="members.php">Member</a>
            <a href="users.php">User</a>
            <a href="logout.php" style="color: var(--error);">Logout</a>
        </div>
    </nav>

    <main class="main-content">
        <h1>Kelola Member</h1>

        <div class="grid" style="grid-template-columns: 1fr 2fr; margin-top: 2rem;">
            <div class="card">
                <h3>Tambah Member</h3>
                <form action="" method="POST" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label>Nama Member</label>
                        <input type="text" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label>Telepon</label>
                        <input type="text" name="telp" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" style="width: 100%; padding: 0.75rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.6); color: white; border: 1px solid var(--border);">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Simpan</button>
                </form>
            </div>

            <div class="card">
                <h3>Daftar Member</h3>
                <table>
                    <thead>
                        <tr>
                            <th>NAMA</th>
                            <th>ALAMAT</th>
                            <th>TELP</th>
                            <th>JK</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $members = mysqli_query($conn, "SELECT * FROM member");
                        while($row = mysqli_fetch_assoc($members)):
                        ?>
                        <tr>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['telp']; ?></td>
                            <td><?php echo $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Hapus member ini?')" style="color: var(--error);">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
