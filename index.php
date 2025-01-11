<?php
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Journal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .dark-theme {
            background-color: #121212;
            color: #ffffff;
        }
        .dark-theme .bg-light {
            background-color: #333 !important;
        }
        .dark-theme .bg-primary {
            background-color: #164a7a !important;
        }
        .dark-theme .bg-danger-subtle {
            background-color: #880b5a !important;
        }
        .dark-theme .navbar, .dark-theme .card, .dark-theme footer {
            background-color: #333;
        }
        .dark-theme .navbar-light .navbar-brand, 
        .dark-theme .navbar-light .nav-link {
            color: #ffffff !important; 
        }
        .dark-theme .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 30 30'%3E%3Cpath stroke='white' stroke-width='2' d='M5 7h20M5 15h20M5 23h20'/%3E%3C/svg%3E");
        }

        .dark-theme .card-text, .dark-theme .card-title, .dark-theme h1, .dark-theme h2, .dark-theme h4 {
            color: #ffffff;
        }

        .dark-theme .list-group-item {
        background-color: #333 !important;
        color: #ffffff !important;
        }

        .card-header-custom {
            background-color: crimson;
            color: white;
        }
    
    </style>
</head>
<body>

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">Daily Journal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-dark">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#article">Article</a></li>
                <li class="nav-item"><a class="nav-link d-flex align-items-center" href="#gallery">Gallery <i class="bi bi-images ms-1"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="#jadwal">Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="#profil">About Me</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php" target="_blank">Login</a></li>
            </ul>
            <!-- Theme Switcher Buttons -->
            <button onclick="setDarkTheme()" class="btn btn-dark ms-3"><i class="bi bi-moon"></i> Dark</button>
            <button onclick="setLightTheme()" class="btn btn-light ms-2"><i class="bi bi-sun"></i> Light</button>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<!-- Hero Section Start -->
<section class="bg-primary text-white text-center p-5">
    <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
            <img src="https://tse1.mm.bing.net/th?id=OIP.3LlNwB3HmPBrvRe1NkBFFgHaHa&pid=Api&P=0&h=180" class="img-fluid" width="300" alt="Hero Image">
            <div>
                <h1 class="fw-bold display-4">Selamat Datang Di Jurnal Saya</h1>
                <h4 class="lead display-6">Hohohoho</h4>
                <h6>
                    <span id="tanggal"></span>
                    <span id="jam"></span>
                </h6>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- article begin -->
<section id="article" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">article</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <?php
      $sql = "SELECT * FROM article ORDER BY tanggal DESC";
      $hasil = $conn->query($sql); 

      while($row = $hasil->fetch_assoc()){
      ?>
        <div class="col">
          <div class="card h-100">
            <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title"><?= $row["judul"]?></h5>
              <p class="card-text">
                <?= $row["isi"]?>
              </p>
            </div>
            <div class="card-footer">
              <small class="text-body-secondary">
                <?= $row["tanggal"]?>
              </small>
            </div>
          </div>
        </div>
        <?php
      }
      ?> 
    </div>
  </div>
</section>
<!-- article end -->

<!-- Gallery Section Start -->
<section id="gallery" class="p-5 bg-danger-subtle">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">Gallery</h1>
    <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
        $hasil = $conn->query($sql);
        $firstItem = true; // Menentukan item pertama sebagai active
        while ($row = $hasil->fetch_assoc()) {
        ?>
          <div class="carousel-item <?= $firstItem ? 'active' : '' ?>">
            <img src="img/<?= $row["gambar"] ?>" class="d-block w-100" alt="<?= $row["judul"] ?>">
          </div>
        <?php
          $firstItem = false; // Mengubah status active untuk item selanjutnya
        }
        ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>

<!-- Gallery Section End -->

<!-- Schedule Section Start -->
<section id="jadwal" class="p-5 text-center bg-light">
    <h1 class="text-center fw-bold">Schedule</h1>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-header card-header-custom">SENIN</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Etika Profesi <br> 16:20 - 18:00 | H.4.4</li>
                            <li class="list-group-item">Sistem Operasi <br> 18:30 - 21:00 | H.4.8</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100">
                        <div class="card-header card-header-custom">SELASA</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Pendidikan Kewarganegaraan <br> 12:30 - 13:10 | Kulino</li>
                            <li class="list-group-item">Probabilitas dan Statistik <br> 15:30 - 18:00 | H.4.9</li>
                            <li class="list-group-item">Kecerdasan Buatan <br> 18:30 - 21:00 | H.4.11</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100">
                        <div class="card-header card-header-custom">RABU</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Manajemen Proyek Teknologi Informasi <br> 15:30 - 18:00 | H.4.6</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100">
                        <div class="card-header card-header-custom">KAMIS</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Bahasa Indonesia <br> 12:30 - 14:10 | Kulino</li>
                            <li class="list-group-item">Pendidikan Agama Islam <br> 16:20 - 18:00 | Kulino</li>
                            <li class="list-group-item">Penambangan Data <br> 18:30 - 21:00 | H.4.9</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row justify-content-end">
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                        <div class="card-header card-header-custom">JUMAT</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Pemrograman Web Lanjut <br> 10:20 - 12:00 | D.2.K</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card h-100">
                        <div class="card-header card-header-custom">SABTU</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">FREE</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
</section>
<!-- Schedule Section End -->

<!-- Profile Section Start -->
<section id="profil" class="bg-danger-subtle text-white text-center p-5 vh-100">
    <div class="container d-flex justify-content-center align-items-center h-100">
        <!-- Bagian Foto -->
        <img src="https://tse3.mm.bing.net/th?id=OIP.5aKjcYnwZm-s-TDgQgeHZwHaGw&pid=Api&P=0&h=180" 
             class="img-fluid me-4" 
             width="500" 
             alt="Hero Image" 
             style="border-radius: 100%;">

        <!-- Bagian Teks -->
        <div class="text-start">
            <p style="color: black;">A11.2023.15231</p>
            <h3 style="color: black;" class="fw-bold">Dandra Wahyu Kusuma Admaja</h3>
            <p style="color: black;">Program Studi Teknik Informatika</p>
            <a href="https://dinus.ac.id/" class="text-decoration-none text-black">Universitas Dian Nuswantoro</a>
            <h6 class="mt-3">
                <span id="tanggal"></span>
                <span id="jam"></span>
            </h6>
        </div>
    </div>
</section>
<!-- Profile Section End -->

<!-- Footer Section Start -->
<footer class="bg-dark text-white text-center p-4">
    <div class="container">
        <div class="d-flex justify-content-center mb-3">
            <a href="#" class="text-white h2 p-2"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-white h2 p-2"><i class="bi bi-twitter"></i></a>
            <a href="#" class="text-white h2 p-2"><i class="bi bi-whatsapp"></i></a>
        </div>
        <p>Dandra &copy; 2024</p>
    </div>
</footer>
<!-- Footer Section End -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Dark Light Mode
    function setDarkTheme() {
        document.body.classList.add('dark-theme');
    }
    function setLightTheme() {
        document.body.classList.remove('dark-theme');
    }

    // Jam
    window.setTimeout("tampilWaktu()", 1000);

    function tampilWaktu() {
        var waktu = new Date();
        var bulan = waktu.getMonth() + 1;

        setTimeout("tampilWaktu()", 1000);
        document.getElementById("tanggal").innerHTML = 
            waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
        document.getElementById("jam").innerHTML = 
            waktu.getHours() + 
            ":" + 
            waktu.getMinutes() + 
            ":" + 
            waktu.getSeconds();
    }
</script>
</body>
</html>
