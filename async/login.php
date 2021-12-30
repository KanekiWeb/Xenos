<?php

    require_once('../Inc/fonctions.php');

    if(isset($_POST['password']) && !empty($_POST['password'])) {
        if($_POST['password'] == "YOUR_SECRET_PASSWORD") {
            $_SESSION['token'] = "n4wh0bhflr5z0v5s5l5q5lk1u1u3jm6eg3162atmey";
            header('Location: ../'); die();
        } else {
            header('Location: ../login.php?error=invalid'); die();
        }
    } else {
        header('Location: ../login.php?error=invalid'); die();
    }

?>