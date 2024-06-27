<?php
    //apabila user masuk ke homepage namun belum login akan diarahkan ke login
    session_start();
    if($_SESSION['login']==false){
        header('location: login.php');
    }

?>