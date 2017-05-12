<?php

require "User.php";

class Users
{
    private $users = array();
    private $num_users;

    public function getUserById($id)
    {
        for ($i = 0; $i < $this->num_users; $i++) {
            if ($this->users[$i]->getId() == $id) {
                return $this->users[$i];
            }
        }
        return null;
    }

    public function getUserByUsername($username)
    {
        for ($i = 0; $i < $this->num_users; $i++) {
            if ($this->users[$i]->getUsername() == $username) {
                return $this->users[$i];
            }
        }
        return null;
    }

    public function getUserByUuid($uuid){
        for ($i = 0; $i < $this->num_users; $i++) {
            if ($this->users[$i]->getUuid() == $uuid) {
                return $this->users[$i];
            }
        }
        return null;
    }

    public function __construct()
    {
        global $mysql;

        if (!$this->checkTable()) {

            $this->pushTable();

            if (!$this->checkTable()) {
                die("Table not created, check MySQL database and credentials");
            }
        }
        if ($this->checkTable()) {

            $query = $mysql->query("SELECT * FROM users");
            $this->num_users = 0;
            while ($row = $query->fetch_assoc()) {
                $this->users[] = new User($row['id']);
                $this->num_users++;
            }
        }
    }

    public function addUserReg($username, $password)
    {
        global $mysql;

        if ($this->getUserByUsername($username) == null) {
            $salt = "";
            for ($i = 0; $i < rand(10, 30); $i++) {
                $salt .= chr(rand(65, 97));
            }
            $hashed_password = sha1(md5($password) . $salt);

            $query = $mysql->query("INSERT INTO users (username, salt, password) VALUES ('$username','$salt','$hashed_password')");

            if ($query) {
                $query = $mysql->query("SELECT * FROM users WHERE username='$username'");

                $user_id = $query->fetch_assoc()['id'];

                $this->users[] = new User($user_id);
            }
        }
    }

    public function addUserOauth($username, $oauth_internal_id, $name, $email)
    {
        global $mysql;

        if ($this->getUserByUsername($username) == null) {
            $query = $mysql->query("INSERT INTO users (username, oauth_internal_id, name, email, last_login) VALUES ('$username','$oauth_internal_id','$name','$email',NOW())");

            if ($query) {
                $query = $mysql->query("SELECT * FROM users WHERE username='$username'");

                $user_id = $query->fetch_assoc()['id'];

                $this->users[] = new User($user_id);
                return $user_id;
            }
        }

    }

    public function checkTable()
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'users'");

        if ($query->num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function pushTable()
    {
        global $mysql;

        $mysql->query("CREATE TABLE `pipaweb`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(256) NOT NULL , `name` VARCHAR(256) NULL , `oauth_internal_id` VARCHAR(256) NULL , `admin` INT NOT NULL DEFAULT '0' , `password` VARCHAR(256) NULL , `salt` VARCHAR(256) NULL , `super_admin` INT NOT NULL DEFAULT '0' , `email` VARCHAR(256) NULL DEFAULT NULL , `easter_egg_id` INT NULL DEFAULT NULL , `last_login` DATETIME NULL DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    public function getUserNum()
    {
        return $this->num_users;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function removeUser($id)
    {
        global $mysql;

        $mysql->query("DELETE FROM users WHERE id='$id'");
    }
}