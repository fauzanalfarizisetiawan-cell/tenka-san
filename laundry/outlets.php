<?php
require 'config.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Handle Add
if (isset($_POST['add'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    
    $query = "INSERT INTO outlet (nama, alamat, telp) VALUES ('$nama', '$alamat', '$telp')";
    mysqli_query($conn, $query);
    header("Location: outlets.php");
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM outlet WHERE id = $id");
    header("Location: outlets.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Outlet - Laundry Tenka</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .flex-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    </style>
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
        <div class="flex-header">
            <h1>Kelola Outlet</h1>
        </div>

        <div class="grid" style="grid-template-columns: 1fr 2fr;">
            <!-- Form Add -->
            <div class="card">
                <h3>Tambah Outlet</h3>
                <form action="" method="POST" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label>Nama Outlet</label>
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
                    <button type="submit" name="add" class="btn btn-primary">Simpan</button>
                </form>
            </div>

            <!-- List Outlets -->
            <div class="card">
                <h3>Daftar Outlet</h3>
                <table>
                    <thead>
                        <tr>
                            <th>NAMA</th>
                            <th>ALAMAT</th>
                            <th>TELP</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $outlets = mysqli_query($conn, "SELECT * FROM outlet");
                        while($row = mysqli_fetch_assoc($outlets)):
                        ?>
                        <tr>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['telp']; ?></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Hapus outlet ini?')" style="color: var(--error);">Hapus</a>
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
