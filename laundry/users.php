<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['add'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $id_outlet = $_POST['id_outlet'];
    
    $query = "INSERT INTO user (nama, username, password, role, id_outlet) VALUES ('$nama', '$username', '$password', '$role', '$id_outlet')";
    mysqli_query($conn, $query);
    header("Location: users.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM user WHERE id = $id");
    header("Location: users.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Laundry Tenka</title>
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
        <h1>Kelola User</h1>

        <div class="grid" style="grid-template-columns: 1fr 2fr; margin-top: 2rem;">
            <div class="card">
                <h3>Tambah User</h3>
                <form action="" method="POST" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" style="width: 100%; padding: 0.75rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.6); color: white; border: 1px solid var(--border);">
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Outlet</label>
                        <select name="id_outlet" style="width: 100%; padding: 0.75rem; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.6); color: white; border: 1px solid var(--border);">
                            <?php
                            $outlets = mysqli_query($conn, "SELECT * FROM outlet");
                            while($o = mysqli_fetch_assoc($outlets)):
                            ?>
                            <option value="<?php echo $o['id']; ?>"><?php echo $o['nama']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Simpan</button>
                </form>
            </div>

            <div class="card">
                <h3>Daftar User</h3>
                <table>
                    <thead>
                        <tr>
                            <th>NAMA</th>
                            <th>USERNAME</th>
                            <th>ROLE</th>
                            <th>OUTLET</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $users = mysqli_query($conn, "SELECT user.*, outlet.nama as nama_outlet FROM user LEFT JOIN outlet ON user.id_outlet = outlet.id");
                        while($row = mysqli_fetch_assoc($users)):
                        ?>
                        <tr>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td style="text-transform: capitalize;"><?php echo $row['role']; ?></td>
                            <td><?php echo $row['nama_outlet'] ?? 'Non-Outlet'; ?></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Hapus user ini?')" style="color: var(--error);">Hapus</a>
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
