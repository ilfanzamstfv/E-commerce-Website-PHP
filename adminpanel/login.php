<?php
    session_start();
    include '../koneksi.php'; //karena diluar file harus seperti ini
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- === bootsrap5 === -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- === font google === -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <!-- === boxicons === -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Urbantopia | Login</title>
</head>

<style>
    * {
        font-family: 'Poppins', sans-serif;
    }
</style>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
        <div class="card shadow-lg col-12 col-md-6" style="width: 400px; height: 500px; border: #40A2E3 solid 1px">
            <div class="card-body" style="background: #222831"> <!-- #113946 -->
                <h3 class="mt-3 card-title text-center" style="font-weight: bold; color:white"><img src="..\image\logoimg.png" alt="" width="33" height="33">Urbantopia</h3>
                <form action="" method="post" class="mt-5">
                    <div class="mb-3 mt-3">
                        <label for="username" class="form-label" style="color: white">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: white">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                    </div>
                    <div class="mt-5 d-flex justify-content-center">
                        <button type="submit" name="loginbtn" class="btn btn-primary btn-lg mx-3" style="font-weight: 400; width: 150px; height: 50px">Log in</button>
                        <button type="submit" name="signupbtn" class="btn btn-outline-primary btn-lg mx-3" style="font-weight: 400; width: 150px; height: 50px">Sign up</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-3">
            <?php
                if (isset($_POST['loginbtn'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    $query = mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
                    $data = mysqli_fetch_array($query);
                    $countdata = mysqli_num_rows($query);
                    
                    if ($countdata > 0) {
                        if (password_verify($password, $data["password"])) {
                            $_SESSION['username'] = $data['username'];
                            $_SESSION['login'] = true;
                            $_SESSION['role'] = $data['role'];

                            if($_SESSION['role'] == 'admin'){
                                header('location: ../adminpanel');
                            } else {
                                header('location: ./index.php');
                            }
                        }
                        else {
                            ?>
                            <div class="alert alert-warning" role="alert">
                                Password yang anda masukkan salah
                            </div>
                            <?php
                        }
                    } 
                    else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                            Username atau password yang anda masukkan salah
                        </div>
                        <?php
                    }

                } elseif(isset($_POST['signupbtn'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    $queryTambah = mysqli_query($conn,"INSERT INTO user (username, password) VALUES ('$username', '$password')");

                    if($queryTambah){
                ?>
                        <div class="alert alert-success" role="alert">
                            username dan password berhasil didaftarkan!
                        </div>
                <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>