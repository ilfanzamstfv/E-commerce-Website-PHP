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
    <title>Beli barang</title>

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

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <h2><?php echo $produk['nama']; ?></h2>
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6">
                    <h3 class="mt-"> Apakah anda ingin membeli produk ini? </h3>
                    <div class="mt-3">
                        <button class="btn btn-dark" type="submit" id="beli-btn">Beli sekarang</button>
                        <a href="produk-detail1.php?p=<?php echo $produk['nama']; ?>"><button class="btn btn-danger ms-3">Kembali</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("beli-btn").addEventListener("click", function() {
            alert("Anda telah memesan produk ini!");
            window.location.href = 'index.php';
        });
    </script>
</body>
</html>