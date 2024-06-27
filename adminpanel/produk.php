<?php
    include '../koneksi.php';
    include 'session.php';

    // koneksi data input ke dalam table produk di database
    $queryProduk = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.
    kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($queryProduk);

    // koneksi data input ke dalam table kategori di database
    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>

    <!-- bootstrap beserta kawan-kawannya -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8585918b38.js" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<style>
    form div{
        margin-bottom: 10px;
    }
</style>

<body>

    <?php include "navbar.php"; ?>
    
    <!-- Tambah Produk -->
    <div class="container mt-5">
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah produk</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Nama produk -->
                <div class="form-floating">
                    <input type="text" id="nama" name="nama" class="form-control" 
                    placeholder="Masukkan nama produk" autocomplete="off" required>
                    <label for="nama">Nama produk</label>
                </div>
                <!-- Kategori produk -->
                <div class="form-floating">
                    <select name="kategori" id="kategori" class="form-select" aria-label="Floating label select example">
                        <option selected>Pilih kategori</option>
                    <?php
                        while($data=mysqli_fetch_array($queryKategori)){
                    ?>
                            <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <label for="kategori">Kategori produk</label>
                </div>
                <!-- Harga produk -->
                <div class="form-floating">
                    <input type="number" id="harga" name="harga" class="form-control" 
                    placeholder="Masukkan harga" autocomplete="off" required>
                    <label for="harga">Harga produk</label>
                </div>
                <!-- Foto produk -->
                <div class="form-floating">
                    <input type="file" name="foto" id="foto" class="form-control">
                    <label for="foto">Foto produk</label>
                </div>
                <!-- Detail produk -->
                <div class="form-floating">
                    <textarea name="detail" id="detail" class="form-control" placeholder="isi detail produk"></textarea>
                    <label for="detail">Detail produk</label>
                </div>
                <!-- Stok produk -->
                <div class="form-floating">
                    <select name="stok" id="stok" class="form-select" aria-label="Floating label select example">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                    <label for="stok">Status produk</label>
                </div>
                <!-- Button Tambah -->
                <div class="mt-3">
                    <button class="btn btn-dark" type="submit" name="save_produk">Add</button>
                </div>
            </form>
            <?php
                if(isset($_POST['save_produk'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $stok = htmlspecialchars($_POST['stok']);
                    
                    // komponen untuk image
                    $target_dir = "../image/";
                    $filename = basename($_FILES["foto"]['name']);
                    $target_file = $target_dir . $filename;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $imageSize = $_FILES["foto"]['size'];
                    $random_name = generateRandomString(20);
                    $newName = $random_name . "." . $imageFileType;

                    // cek apakah work atau tidak
                    // echo $target_dir. '<br>';
                    // echo $filename. '<br>';
                    // echo $target_file. '<br>';
                    // echo $imageFileType. '<br>';
                    // echo $imageSize. '<br>';


                    if($nama=='' || $kategori=='' || $harga==''){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Nama, kategori, dan harga harus diisi!
                        </div>
                    
                        <!-- <meta http-equiv="refresh" content="1; url=produk.php"> -->
            <?php
                    }
                    else{
                        if($filename !=''){
                            if($imageSize > 5000000) {
            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    Ukuran file tidak boleh lebih dari 5 Mb!
                                </div>
            <?php
                            }
                            else {
                                if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'){
            ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file tidak sesuai!
                                    </div>
            <?php
                                }
                                else {
                                    move_uploaded_file($_FILES["foto"]['tmp_name'], $target_dir . $newName);
                                }
                            }
                        }

                        // query insert to table produk
                        $queryTambah = mysqli_query($conn, "INSERT INTO produk (kategori_id, nama,
                        foto, detail, stok, harga) VALUES ('$kategori', '$nama', '$newName', '$detail', '$stok',
                        '$harga')");

                        if($queryTambah) {
            ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Produk berhasil ditambahkan!
                            </div>

                            <meta http-equiv="refresh" content="1; url=produk.php">
            <?php
                        }
                        else {
                            echo mysqli_error($conn);
                        }
                    }
                }
            ?>
        </div>
        
        <div class="mt-3 mb-5">
            <h2>List produk</h2>
            <div class="table-responsive">
                <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            if($jumlahProduk==0){
                        ?>
                                <tr>
                                    <td colspan="6" class="text-center">Data produk kosong</td>
                                </tr>
                        <?php       
                            }else{
                                $jumlah =1;
                                while($data = mysqli_fetch_array($queryProduk)){
                        ?>
                                    <tr>
                                        <td> <?php echo $jumlah; ?> </td>
                                        <td> <?php echo $data['nama']; ?> </td>
                                        <td> <?php echo $data['nama_kategori']; ?> </td>
                                        <td> <?php echo $data['harga']; ?> </td>
                                        <td> <?php echo $data['stok']; ?> </td>
                                        <td>
                                            <a href="detail_produk.php?q= <?php echo $data['id'];?>"
                                            class="btn btn-primary"><i class="fa-solid fa-pencil" style="color: #ffffff;"></i></a>
                                        </td>
                                    </tr>
                        <?php
                                $jumlah++;
                                }
                            }
                        ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>