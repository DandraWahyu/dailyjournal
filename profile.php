<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");  // Redirect ke halaman login
    exit();
}

include "koneksi.php";

// Ambil data user berdasarkan username yang login
$username = $_SESSION['username'];
$query = "SELECT * FROM user WHERE username='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Proses ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['password'];
    $new_foto = $_FILES['foto'];

    // Update password jika diisi
    if (!empty($new_password)) {
        $new_password = md5($new_password); // Enkripsi password baru
        $query = "UPDATE user SET password='$new_password' WHERE username='$username'";
        mysqli_query($conn, $query);
    }

    // Update foto jika ada file yang diupload
    if (!empty($new_foto['name'])) {
        // Mengatur lokasi penyimpanan foto
        $foto_name = time() . '_' . $new_foto['name'];
        $target_dir = "img/";
        $target_file = $target_dir . basename($foto_name);

        if (move_uploaded_file($new_foto['tmp_name'], $target_file)) {
            // Update foto profil di database
            $query = "UPDATE user SET foto='$foto_name' WHERE username='$username'";
            mysqli_query($conn, $query);
        }
    }

    // Redirect ke halaman profil setelah update
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal | Admin</title>
    <link rel="icon" href="img/logo.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style> 
        #content {
            min-height: 460px;
        } 
    </style>
</head>
<body>
    <!-- Nav -->
    <nav class="navbar navbar-expand-sm bg-body-tertiary sticky-top bg-danger-subtle">
        <div class="container">
            <a class="navbar-brand" href="">My Daily Journal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
                    <li class="nav-item"><a class="nav-link" href="admin.php?page=dashboard">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php?page=article">Article</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php?page=gallery">Gallery</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['username']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li> 
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li> 
                        </ul>
                    </li> 
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <section id="content" class="p-5">
    <div class="container">
        <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle">Profil</h4>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="password" class="form-label">Ganti Password</label>
                <input type="password" name="password" class="form-control" placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Ganti Foto Profil</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <div class="mb-3">
                <label for="foto_saat_ini" class="form-label">Foto Profil Saat Ini:</label>
                <br>
                <?php if (!empty($user['foto'])): ?>
                    <img src="img/<?php echo $user['foto']; ?>" alt="Foto Profil" class="img-thumbnail" style="max-width: 150px;">
                <?php else: ?>
                    <p>Tidak ada foto.</p>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</section>


    <!-- Footer -->
    <footer class="text-center p-5 bg-danger-subtle">
        <div>
            <a href="https://www.instagram.com/udinusofficial"><i class="bi bi-instagram h2 p-2 text-dark"></i></a>
            <a href="https://twitter.com/udinusofficial"><i class="bi bi-twitter h2 p-2 text-dark"></i></a>
            <a href="https://wa.me/+62812685577"><i class="bi bi-whatsapp h2 p-2 text-dark"></i></a>
        </div>
        <div>Dandra &copy; 2023</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
