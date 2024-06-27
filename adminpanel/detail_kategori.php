<?php
    include '../koneksi.php';
    include 'session.php';

    $id = $_GET['q'];

    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE id='$id'");
    $data = mysqli_fetch_array($query);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>

    <!-- bootstrap beserta kawan-kawannya -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/8585918b38.js" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include "navbar.php"; ?>

    <div class="container mt-5">
        <h2> Detail kategori</h2>
        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="form-control mt-2" value="<?php 
                    echo $data['nama']; ?>">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-dark me-2" name="editbtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deletebtn">Delete</button>
                </div>
            </form>

            <?php 
                if(isset($_POST['editbtn'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    if($data['nama']==$kategori){
            ?>
                        <meta http-equiv="refresh" content="0; url=kategori.php"/>
            <?php
                    }
                    else {
                        $query = mysqli_query($conn, "SELECT * FROM kategori WHERE nama='$kategori'");
                        $jumlahData = mysqli_num_rows($query);
                        if($jumlahData > 0){
            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Kategori sudah ada!
                            </div>
            <?php
                        }
                        else {
                            $querySimpan = mysqli_query($conn, "UPDATE kategori SET nama='$kategori'
                            WHERE id='$id'");

                            if($querySimpan){
            ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    Kategori berhasil diupdate!
                                </div>

                                <meta http-equiv="refresh" content="2; url=kategori.php"/> 
            <?php  
                            }
                            else {
                                echo mysqli_error($conn);
                            }
                        }
                    }
                }

                if(isset($_POST['deletebtn'])){
                    $queryCheck = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='$id'");
                    $dataCount = mysqli_num_rows($queryCheck);
                    
                    if($dataCount>0){
            ?>
                       <div class="alert alert-danger mt-3" role="alert">
                            Kategori tidak dapat dihapus karena sudah digunakan di produk!
                        </div>
            <?php
                    }
                    
                    $queryDelete = mysqli_query($conn, "DELETE FROM kategori WHERE id='$id'");
                    
                    if($queryDelete){
                        ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Kategori berhasil dihapus!
                            </div>

                            <meta http-equiv="refresh" content="1; url=kategori.php"/>
                        <?php
                    }
                    else {
                        echo mysqli_error($conn);
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>