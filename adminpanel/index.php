<?php
    include '../koneksi.php';
    include 'session.php';

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
    $jumlahKategori =mysqli_num_rows($queryKategori);

    $queryProduct = mysqli_query($conn, "SELECT * FROM produk");
    $jumlahProduct =mysqli_num_rows($queryProduct);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="../asset/style.css">

    <!-- === bootsrap5 & fontawesome === -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8585918b38.js" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<style>
    .kotak {
        /* border: solid, 2px;*/
    }

    .summary-kategori{
        background-color: #76ABAE;
        border-radius: 10px;
    }

    .summary-produk{
        background-color: #31363F;
        border-radius: 10px;
    }

    .link:hover{
        /*color: #31363F;*/
    }
</style>

<body>
    <?php
    include 'navbar.php';
    ?>
    <div class="container mt-5">
        <h2>Welcome <?php echo $_SESSION['username']; ?></h2>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="kotak summary-kategori p-2">
                        <div class="row">
                            <div class="col-5">
                                <i class="fa-solid fa-5x fa-list"></i>
                            </div>
                            <div class="col-5 text-white">
                                <h3 class="fs-3">Kategori</h3>
                                <p class="fs-6"> <?php echo $jumlahKategori; ?> Kategori</p>
                                <p> <a href="kategori.php" class="text-white" style="text-decoration: none;">Lihat detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="kotak summary-produk p-2">
                        <div class="row">
                            <div class="col-5">
                                <i class="fa-solid fa-5x fa-shirt" style="color: #ffff;"></i>
                            </div>
                            <div class="col-5 text-white">
                                <h3 class="fs-3">Produk</h3>
                                <p class="fs-6"><?php echo $jumlahProduct; ?> Produk</p>
                                <p> <a href="produk.php" class="text-white" style="text-decoration: none;">Lihat detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>