<?php
    require_once('database.php');

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

?>