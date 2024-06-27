<?php
    include 'koneksi.php';

    $nama = htmlspecialchars($_GET['p']); 
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Detail</title>

    <!-- === bootsrap5 & fontawesome === -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8585918b38.js" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet"  href="asset/style.css">
</head>
<body>
    <!-- navbar -->
    <?php include 'navbar.php'; ?>

    <!-- detail produk -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama']; ?></h1>
                    <p class="fs-5"> <?php echo $produk['detail']; ?> </p>
                    <p class="fs-3"> Rp. <?php echo $produk['harga']; ?>,00 </p>
                    <p class="fs-5"> Stok: <strong> <?php echo $produk['stok']; ?> </strong></p>
                    <a href="beli.php?p=<?php echo $produk['nama']; ?>"><button class="btn btn-dark">Beli</button></a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>