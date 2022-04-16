<?php
    require_once('database.php');

    // 
    $api_password = "PASSWORD FOR API";
    $webhook = "YOUR DISCORD WEBHOOK";

    // For Authentification System (Require)
    $OAUTH2_CLIENT_ID = 'DISCORD OAUTH CLIENT ID';
    $OAUTH2_CLIENT_SECRET = 'OAUTH CLIENT SECRET';
    $RedirectUrl = 'http://yoursite.com/async/login';
    $WhitelistIds = array("WL FOR YOUR IDS","...", "..");

    function CheckLogin(){
        if(isset($_SESSION['access_token'])) { return true; }
        else { return false; }
    }

    function GetCount($table) {
        global $bdd;
        $req = $bdd->prepare('SELECT * FROM ' . htmlspecialchars($table));
        $req->execute();
        return $req->rowCount();
    }

    function GetFlagedCount() {
        global $bdd;
        $req = $bdd->prepare('SELECT * FROM tokens WHERE isflaged = 1');
        $req->execute();
        return $req->rowCount();
    }

    function SendToWebhook($webhook, $data) {
        $ch = curl_init($webhook);
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true
        ));

        curl_exec($ch);
        curl_close($ch);
    }
?>
