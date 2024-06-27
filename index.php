<?php
    include "koneksi.php";
    
    $queryProduk = mysqli_query($conn, "SELECT id, nama, foto, detail, harga FROM produk LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urbantopia | Home</title>

    <!-- === bootsrap5 & fontawesome === -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8585918b38.js" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet"  href="asset/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>    

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Selamat Datang di UrbanTopia</h1>
            <h4>Ingin cari apa hari ini?</h4>
            <div class="col-8 offset-2">
                <form action="produk1.php" method="get">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Pakaian Fashion Terkini" 
                        aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword" autocomplete="off">
                        <button class="btn colorbtn" type="submit"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlighted kategori -->
    <div class="container-fluid py-5 bg2">
        <div class="container text-center">
            <h3 style="font-weight: bold">Kategori Terlaris</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="tampilan-kategori kategori-baju-pria d-flex justify-content-center
                    align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk1.php?kategori=Baju pria">Pakaian Pria</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="tampilan-kategori kategori-sepatu d-flex justify-content-center
                    align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk1.php?kategori=Sepatu">Sepatu</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="tampilan-kategori kategori-baju-wanita d-flex justify-content-center
                    align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk1.php?kategori=Baju wanita">Pakaian Wanita</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang kami -->
    <div class="container-fluid py-5 text-dark" style="background-color: #FFB1B1">
        <div class="container text-center">
            <h3 style="font-weight: bold">About Us</h3>
            <p class="fs-5">
                Ini adalah proyek ujian akhir semester mata kuliah rekayasa perangkat lunak,
                kami menjadikan rancangan website e-commerce ini hanya sebagai proyek ujian semata.
            </p>
        </div>
    </div>
    <!-- produk -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3 style="font-weight: bold">Produk</h3>

            <div class="row mt-5">
                <?php while($produk=mysqli_fetch_array($queryProduk)){ ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                            <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                            <p class="card-text text-harga">Rp <?php echo $produk['harga']; ?>,00</p>
                            <a href="produk-detail1.php?p=<?php echo $produk['nama']; ?>" class="btn btn-dark">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-dark mt-3" href="produk1.php">See more</a>
        </div>
    </div>
    <?php include 'footer.php' ?>
</body>
</html>