<?php

require_once("Locations.php");

class User
{
    private $id;
    private $username;
    private $admin;
    private $oauth_internal_id;
    private $super_admin;
    private $salt;
    private $password_hashed;
    private $last_login;
    private $name;

    public function __construct($id)
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM users WHERE id='$id'");
        $user_data = $query->fetch_assoc();

        $this->id = $id;
        $this->username = $user_data['username'];
        $this->admin = $user_data['admin'];
        $this->oauth_internal_id = $user_data['oauth_internal_id'];
        $this->super_admin = $user_data['super_admin'];
        $this->salt = $user_data['salt'];
        $this->password_hashed = $user_data['password'];
        $this->last_login = $user_data['last_login'];
        $this->name = $user_data['name'];
    }

    public function checkLogin($password)
    {
        $hashed_password = sha1(md5($password) . $this->salt);
        if ($hashed_password == $this->password_hashed) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword($password)
    {
        global $mysql;
        if($this->salt == ""){
            for ($i = 0; $i < rand(10, 30); $i++) {
                $this->salt .= chr(rand(65, 97));
            }
            $mysql->query("UPDATE users SET salt='$this->salt' WHERE id='$this->id'");
        }
        $hashed_password = sha1(md5($password) . $this->salt);
        $mysql->query("UPDATE users SET password='$hashed_password' WHERE id='$this->id'");
    }

    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function getPassword()
    {
        return $this->password_hashed;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getSuperAdmin()
    {
        return $this->super_admin;
    }

    public function getUuid()
    {
        return $this->oauth_internal_id;
    }

    public function setLastLogin()
    {
        global $mysql;
        $mysql->query("UPDATE users SET last_login=NOW() WHERE id='$this->id'");
    }

    public function setAdmin()
    {
        global $mysql;
        if($this->admin=="1"){
            $new_admin = 0;
        }else{
            $new_admin = 1;
        }

        $mysql->query("UPDATE users SET admin='$new_admin' WHERE id='$this->id'");
    }

    public function setSuperAdmin()
    {
        global $mysql;
        if($this->super_admin=="1"){
            $new_super_admin = 0;
        }else{
            $new_super_admin = 1;
        }

        $mysql->query("UPDATE users SET super_admin='$new_super_admin' WHERE id='$this->id'");
    }

    public function isAdminOf($location_id)
    {

    }
}