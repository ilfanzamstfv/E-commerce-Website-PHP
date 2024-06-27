<?php
    include '../koneksi.php';
    include 'session.php';

    $id = $_GET['q'];

    $query = mysqli_query($conn, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.
    kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query);

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

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
    <title>Edit Produk</title>

    <link rel="stylesheet" href="../asset/style.css">

    <!-- === bootsrap5 === -->
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
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 mb-5">
        <h2>Edit produk</h2>
        <div class="col-12 col-md-6 mt-3">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Nama produk -->
                <div class="form-floating">
                    <input type="text" id="nama" name="nama" value="<?php echo $data['nama'] ?>" class="form-control" 
                    placeholder="Masukkan nama produk" autocomplete="off" required>
                    <label for="nama">Nama produk</label>
                </div>
                <!-- Kategori produk -->
                <div class="form-floating">
                    <select name="kategori" id="kategori" class="form-select" aria-label="Floating label select example">
                        <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
                    <?php
                        while($dataKategori=mysqli_fetch_array($queryKategori)){
                    ?>
                            <option value="<?php echo $dataKategori['id'] ?>"><?php echo $dataKategori['nama'] ?></option>
                    <?php
                        }
                    ?>
                    </select>
                    <label for="kategori">Kategori produk</label>
                </div>
                <!-- Harga -->
                <div class="form-floating">
                    <input type="number" id="harga" name="harga" value="<?php echo $data['harga']; ?>" class="form-control" 
                    placeholder="Masukkan harga" autocomplete="off" required>
                    <label for="harga">Harga produk</label>
                </div>
                <!-- Current photo -->
                <div>
                    <label for="currentFoto">Current Photo</label>
                    <img class="ms-2" src="../image/<?php echo $data['foto']; ?>" alt="" width="200px" style="border: 1px solid">
                </div>
                <!-- Foto produk -->
                <div class="form-floating">
                    <input type="file" name="foto" id="foto" class="form-control">
                    <label for="foto">Foto produk</label>
                </div>
                <!-- Detail -->
                <div class="form-floating">
                    <textarea name="detail" id="detail" class="form-control" placeholder="isi detail produk">
                        <?php echo $data['detail']; ?>
                    </textarea>
                    <label for="detail">Detail produk</label>
                </div>
                <!-- Stok barang -->
                <div class="form-floating">
                    <select name="stok" id="stok" class="form-select" aria-label="Floating label select example">
                        <option value="<?php echo $data['stok']; ?>"><?php echo $data['stok']; ?></option>
                        <?php
                            if($data['stok']=='Tersedia'){
                        ?>
                                <option value="Habis">Habis</option>
                        <?php
                            }
                            else {
                        ?>
                                <option value="Tersedia">Tersedia</option>
                        <?php
                            }
                        ?>
                    </select>
                    <label for="stok">Status produk</label>
                </div>
                <div>
                    <button type="submit" class="btn btn-dark me-2" name="save">Save</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </div>
            </form>
            <?php
                if(isset($_POST['save'])){
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

                    if($nama=='' || $kategori=='' || $harga==''){
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Nama, kategori, dan harga harus diisi!
                        </div>
            <?php
                    }
                    else{
                        $queryUpdate = mysqli_query($conn, "UPDATE produk SET kategori_id='$kategori', 
                        nama='$nama', foto='$newName', detail='$detail', stok='$stok', harga='$harga' WHERE id=$id");

                        if($filename !=''){
                            if($imageSize > 5000000){
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
                                    move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $newName);

                                    $queryUpdate = mysqli_query($conn, "UPDATE produk SET foto='$newName' 
                                    WHERE id='$id'");

                                    if($queryUpdate) {
            ?>
                                        <div class="alert alert-success mt-3" role="alert">
                                            Produk berhasil diupdate!
                                        </div>

                                        <meta http-equiv="refresh" content="2; url=produk.php">
            <?php
                                    }
                                }
                            }
                        }
                    }
                }

                if(isset($_POST['delete'])){
                    $queryDelete = mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

                    if($queryDelete){
            ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Produk berhasil dihapus!
                        </div>

                        <meta http-equiv="refresh" content="2; url=produk.php">
            <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>