<?php
    require_once('Inc/fonctions.php');
    
    if(CheckLogin()){
        header('Location: index');
    }

    $title = "Login";
    require('Inc/Dash.php');
?>

    <!-- Main -->
    <section class="section_main">
        <div class="main">
            <img src="assets/images/xenos.gif" alt="">
            <h1>Xenos Project</h1>
            <p>The Best Most powerfull token grabber with user interface.</p>
            <form class="login_form" action="async/login.php" method="post">
                <button type="submit">Login Using Discord</button>
            </form>
        </div>
    </section>

    <footer>
        Copyright ©️ Made By <a target="_blank" href="https://github.com/KanekiWeb">Kaneki Web</a>
    </footer>
</body>
</html>