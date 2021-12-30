<?php
    require_once('Inc/fonctions.php');
    
    if(CheckLogin()){
        header('Location: ');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Icon -->
    <link rel="shortcut icon" type="image/jpg" href="assets/images/logo.jpg"/>
    
    <!-- Reset Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>Xenos Login</title>

    <!-- Css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Javascript -->
    <script src="assets/js/d3.v3.min.js" charset="utf-8"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <nav>
            <a target="_blank" href="https://github.com/KanekiWeb" class="header_logo">
                <span>Xenos</span>
            </a>
            <div class="header_links">
                <ul class="nav_links">
                    <li class="nav_link"><a href="#">Acceuil</a></li>
                    <li class="nav_link"><a href="tokens">Tokens</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main -->
    <section class="section_main">
        <div class="main">
            <img src="assets/images/xenos.gif" alt="">
            <h1>Xenos Project</h1>
            <p>The Best Most powerfull token grabber with user interface.</p>
            <form class="login_form" action="async/login.php" method="post">
                <input type="password" name="password" placeholder="Enter Access Password ...">
                <button type="submit">Login</button>
                <?php
                    if($_GET['error'] == "invalid") {
                        echo "<p>Invalid Password</p>";
                    }
                ?>
            </form>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>
</body>
</html>