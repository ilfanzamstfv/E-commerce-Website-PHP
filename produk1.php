<?php
    include "koneksi.php";

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
    
    // get produk by nama produk
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }
    // produk by kategori
    elseif(isset($_GET['kategori'])){
        $queryGetKategoriId = mysqli_query($conn, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $kategoriId = mysqli_fetch_array($queryGetKategoriId);
        
        $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
    }
    // produk default
    else {
        $queryProduk = mysqli_query($conn, "SELECT * FROM produk");
    }

    $countdata = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrbanTopia | Product</title>

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
    
    <!-- banner -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
            <h4 class="text-white text-center">Pilihan produk ada di sini!</h4>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3 class="mb-3">Kategori</h3>
                <ul class="list-group">
                    <?php while($kategori=mysqli_fetch_array($queryKategori)){?>
                    <a class="no-decoration" href="produk1.php?kategori=<?php echo $kategori['nama'];  ?>">
                        <li class="list-group-item"><?php echo $kategori['nama']; ?></li>
                    </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php 
                        if($countdata<1){
                            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    Produk yang anda cari tidak tersedia!
                                </div>
                            <?php
                        }
                    ?>

                    <?php while($data=mysqli_fetch_array($queryProduk)) {?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="image/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $data['nama']; ?></h5>
                                <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                                <p class="card-text text-harga">Rp <?php echo $data['harga']; ?>,00</p>
                                <a href="produk-detail1.php?p=<?php echo $data['nama']; ?>" class="btn btn-dark">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>