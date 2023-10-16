
# Install Lamp-Server

Install LAMP-SERVER Ubuntu 20.04

```
  sudo apt update && sudo apt upgrade -y
  sudo apt-get install lamp-server^
```
---

# Enable Mod_Rewrite

### Enable mod_rewrite Module

Depending on your operating system and Apache version, this might differ. On Ubuntu, for example, you can use the following command:

```
  sudo a2enmod rewrite
```

### Update Apache Configuration

Next, you’ll need to allow the use of .htaccess files to control URL rewriting. This is done by editing the Apache configuration file for your site, typically found in /etc/apache2/sites-available.

Open the file for your site:

```
  sudo nano /etc/apache2/sites-available/000-default.conf
```

Find the <Directory /var/www/html> block and change the AllowOverride directive from None to All. If the line doesn’t exist, you can add it:

```
  <Directory /var/www/html>
    AllowOverride All
  </Directory>
```
This change allows .htaccess files in the /var/www/html directory (or the appropriate directory for your site) to include mod_rewrite rules.

### Restart Apache
```
  sudo systemctl restart apache2
```

# Install phpMyAdmin

### Install phpMyAdmin
```
  sudo apt install phpmyadmin php-mbstring php-zip php-gd php-json php-curl
```
- For the server selection, choose `apache2`
- Selecht `Yes` when asked whether to use `dbconfig-common` to set up the database
- You will then be asked to choose and confirm a MySQL application password for phpMyAdmin

```
NOTE
If you get this error follow this guide
```
![App Screenshot](https://i.imgur.com/HD0Bw6X.png)

To resolve this, select the abort option to stop the installation process. Then, open up your MySQL prompt:
```
sudo mysql
```

Or, if you enabled password authentication for the root MySQL user, run this command and then enter your password when prompted:
```
mysql -u root -p
```

From the prompt, run the following command to disable the Validate Password component. Note that this won’t actually uninstall it, but just stop the component from being loaded on your MySQL server:
```
UNINSTALL COMPONENT "file://component_validate_password";
```

Following that, you can close the MySQL client:
```
mysql> exit
```

Then try installing the phpmyadmin package again and it will work as expected:
```
sudo apt install phpmyadmin
```

The installation process adds the phpMyAdmin Apache configuration file into the /etc/apache2/conf-enabled/ directory, where it is read automatically. To finish configuring Apache and PHP to work with phpMyAdmin, the only remaining task in this section of the tutorial is to is explicitly enable the mbstring PHP extension, which you can do by typing:

```
sudo phpenmod mbstring
```

Afterwards, restart Apache for your changes to be recognized:

```
sudo systemctl restart apache2
```

# Adjusting User Authentication and Privileges
When you installed phpMyAdmin onto your server, it automatically created a database user called phpmyadmin which performs certain underlying processes for the program. Rather than logging in as this user with the administrative password you set during installation, it’s recommended that you log in as either your root MySQL user or as a user dedicated to managing databases through the phpMyAdmin interface.

Configuring Password Access for the MySQL Root Account
In Ubuntu systems running MySQL 5.7 (and later versions), the root MySQL user is set to authenticate using the auth_socket plugin by default rather than with a password. This allows for some greater security and usability in many cases, but it can also complicate things when you need to allow an external program — like phpMyAdmin — to access the user.

In order to log in to phpMyAdmin as your root MySQL user, you will need to switch its authentication method from auth_socket to one that makes use of a password, if you haven’t already done so. To do this, open up the MySQL prompt from your terminal:

```
sudo mysql
```

Next, check which authentication method each of your MySQL user accounts use with the following command:

```
SELECT user,authentication_string,plugin,host FROM mysql.user;
```

```
Output
+------------------+-------------------------------------------+-----------------------+-----------+
| user             | authentication_string                     | plugin                | host      |
+------------------+-------------------------------------------+-----------------------+-----------+
| root             |                                           | auth_socket           | localhost |
| mysql.session    | *THISISNOTAVALIDPASSWORDTHATCANBEUSEDHERE | caching_sha2_password | localhost |
| mysql.sys        | *THISISNOTAVALIDPASSWORDTHATCANBEUSEDHERE | caching_sha2_password | localhost |
| debian-sys-maint | *8486437DE5F65ADC4A4B001CA591363B64746D4C | caching_sha2_password | localhost |
| phpmyadmin       | *5FD2B7524254B7F81B32873B1EA6D681503A5CA9 | caching_sha2_password | localhost |
+------------------+-------------------------------------------+-----------------------+-----------+
5 rows in set (0.00 sec)
```

In this example, you can see that the root user does in fact authenticate using the auth_socket plugin. To configure the root account to authenticate with a password, run the following ALTER USER command. Be sure to change password to a strong password of your choos

```
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'password';
```

# Install MEOS
Create a folder in `/var/www/html` named `meos` or something else. Drag all files from `meos.zip` into that folder.

Now we need to edit the database credentials, open `config.php` in `/var/www/html/meos`

You can edit now to your credentials. 

Mostly the MEOS database is installed localy so you can use localhost at `$db_host`.
```
// Meos database
$db_host = "host";
$db_user = "username";
$db_pass = "password";
$db_data = "database";

$con = new mysqli($db_host,$db_user,$db_pass,$db_data);

// Fivem ESX database
$dd = array(
"host" => "host",
"user" => "username",
"pass" => "password",
"data" => "database"
);
```

# Import MEOS database into phpMyAdmin
Open phpMyAdmin, and create a new database. Import the database, you can find it in `/var/www/html/meos/database/meos-database.sql`




