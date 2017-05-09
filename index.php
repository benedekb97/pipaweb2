<?php
session_start();
include("includes/init.php");
$query = $mysql->query("CREATE TABLE `pipaweb`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(256) NOT NULL , `name` VARCHAR(256) NULL , `oauth_internal_id` VARCHAR(256) NULL , `admin` INT NOT NULL DEFAULT '0' , `password` VARCHAR(256) NULL , `salt` VARCHAR(256) NULL , `super_admin` INT NOT NULL DEFAULT '0' , `email` INT NOT NULL , `easter_egg_id` INT NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
include("includes/Users.php");
$users = new Users();
$users->addUserOauth("benedekb97","asd","Benedek Burgess","benedekb97@gmail.com");
$users->addUserReg("anyad","anyad");