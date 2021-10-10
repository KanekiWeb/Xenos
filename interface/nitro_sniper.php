<?php

    if (isset($_GET['code']) && !empty($_GET['code']) && isset($_GET['channel']) && !empty($_GET['channel'])) {
        $token = "YOUR DISCORD TOKEN";
        $URL = "https://discord.com/api/v8/entitlements/gift-codes/" . htmlspecialchars($_GET['code']) . "/redeem";

        $headr = array();
        $headr[] = "Authorization: " . $token;
        $headr[] = "Content-Type: application/json";

        $payload = array(
            "channel_id" => htmlspecialchars($_GET['channel'])
        );

        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crl, CURLOPT_URL, $URL);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($crl);
        curl_close($crl);
    }
?>