<?php
    include '../koneksi.php';
    include 'session.php';

    $queryKategori = mysqli_query($conn, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>

    <link rel="stylesheet" href="../asset/style.css">

    <!-- === bootsrap5 === -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8585918b38.js" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Kategori</h3>
            <form action="" method="post">
                <div class="form-floating">
                    <input type="text" id="kategori" name="kategori" placeholder="Input kategori"
                    class="form-control mt-2" autocomplete="off" required>
                    <label for="kategori">Kategori</label>
                </div>
                <div class="mt-3">
                    <button class="btn btn-dark" type="submit" name="save_kategori">Add</button>
                </div>
            </form>

            <?php 
                if(isset($_POST['save_kategori'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    $queryExist = mysqli_query($conn, "SELECT nama FROM kategori WHERE 
                    nama='$kategori'");
                    $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

                    if($jumlahDataKategoriBaru > 0) {
            ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Kategori tersebut sudah ada!
                        </div>
            <?php
                    }
                    else {
                        $querySimpan = mysqli_query($conn, "INSERT INTO kategori (nama)
                         VALUES ('$kategori')");
                         if($querySimpan){
            ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Kategori berhasil ditambahkan!
                            </div>
                            
                            <!-- code untuk langsung memproses data ketika telah diinput  -->
                            <meta http-equiv="refresh" content="1; url=kategori.php"/>
            <?php
                         }
                         else {
                            echo mysqli_error($conn);
                         }
                    }
                }
            ?>
        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>

            <div class="table-responsive">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Detail kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($jumlahKategori == 0) {
                        ?>
                                <tr>
                                    <td colspan="3" class="text-center">Data kategori kosong</td>
                                </tr>
                        <?php
                            } else {
                                $jumlah = 1;
                                while($data = mysqli_fetch_array($queryKategori)){
                        ?>
                                    <tr>
                                        <td> <?php echo $jumlah; ?> </td>
                                        <td> <?php echo $data['nama']; ?> </td>
                                        <td>
                                            <a href="detail_kategori.php?q= <?php echo $data['id'];?>"
                                            class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></a>
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