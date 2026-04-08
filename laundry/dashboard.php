<?php
require 'config.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];

// Simple stats count
$user_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM user"))[0];
$member_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM member"))[0];
$outlet_count = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM outlet"))[0];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Laundry Tenka</title>
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
        <header style="margin-bottom: 2rem;">
            <h1>Selamat Datang, <?php echo $nama; ?>!</h1>
            <p style="color: var(--text-muted);">Role Anda: <span style="text-transform: capitalize;"><?php echo $role; ?></span></p>
        </header>

        <div class="grid">
            <div class="stat-card">
                <span class="label">Total Outlet</span>
                <span class="value"><?php echo $outlet_count; ?></span>
            </div>
            <div class="stat-card">
                <span class="label">Total Member</span>
                <span class="value"><?php echo $member_count; ?></span>
            </div>
            <div class="stat-card">
                <span class="label">Total User</span>
                <span class="value"><?php echo $user_count; ?></span>
            </div>
        </div>

        <div class="card" style="margin-top: 2rem;">
            <h2>Data Member Terbaru</h2>
            <table>
                <thead>
                    <tr>
                        <th>NAMA</th>
                        <th>ALAMAT</th>
                        <th>TELP</th>
                        <th>JK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $members = mysqli_query($conn, "SELECT * FROM member ORDER BY id DESC LIMIT 5");
                    while($row = mysqli_fetch_assoc($members)):
                    ?>
                    <tr>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['telp']; ?></td>
                        <td><?php echo $row['jenis_kelamin']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
