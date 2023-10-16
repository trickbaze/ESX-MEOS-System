
# MEOS | Fivem ESX

Politie MEOS Systeem uitsluitend voor FiveM servers met het ESX Framework

# Installatie type
Momenteel werkt MEOS niet op een Apache of NGINX die draait op Ubuntu of een andere OS, het werkt momenteel alleen nog met XAMPP, cPanel Plesk, DirectAdmin, ISPConfig en Virtualmin.


## Server Requirements

**PHP** 7.4 or 8.0

**Apache** 2.4 or higher

**MariaDB** 10.4.27 or higher 


## Installatie

Installeer MEOS met git clone

```bash
  git clone https://github.com/trickbaze/ESX-MEOS-System.git
  cd ESX-MEOS-System
```
    
Upload de database naar je mysql server.
```bash
  Database/meos-database.sql
```

Pas in de config.php de database credentials aan. 
```bash
  // Meos database
  db_host = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_data = "meos";

  $con = new mysqli($db_host,$db_user,$db_pass,$db_data);

  // Fivem ESX database
  $dd = array(
  "host" => "localhost",
  "user" => "root",
  "pass" => "",
  "data" => "esxlegacy_22eb04"
);

  $ddcon = new mysqli($dd['host'],$dd['user'],$dd['pass'],$dd['data']);
```
## Features

- Persoon administratie
- Voertuig administratie
- WOK Melding maken
- Aangifte administratie
- Trainings centrum

## Admin login
**Username:** admin

**Password:** Welkom01!

Wij adviseren om gelijk een nieuwe admin account te maken en deze gebruiker te verwijderen.


## Screenshots

![App Screenshot](https://i.imgur.com/1EYOKKK.png)

![App Screenshot](https://i.imgur.com/4z0osfa.png)

![App Screenshot](https://i.imgur.com/8U6mFAy.png)

![App Screenshot](https://i.imgur.com/UK4Ihdu.png)

![App Screenshot](https://i.imgur.com/3jpB600.png)


## Authors

- [@trickbaze](https://www.github.com/trickbaze)

## Discord

Join ook de discord om op te hoogte te blijven van alle updates & bug-fixes

https://discord.gg/ku38tUhmPt
