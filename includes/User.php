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
    private $admin_of;
    private $easter_egg_id;

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
        $this->admin_of = $user_data['admin_of'];
        $this->easter_egg_id = $user_data['easter_egg_id'];


        if($id==0){
            $this->id=0;
            $this->username = "undefined";
            $this->admin = 0;
            $this->oauth_internal_id = null;
            $this->super_admin = 0;
            $this->salt = null;
            $this->password_hashed = null;
            $this->last_login = null;
            $this->name = "Unknown";
            $this->admin_of = null;
            $this->easter_egg_id = null;
        }
    }

    public function setEasterEgg($easter_egg)
    {
        global $mysql;

        $mysql->query("UPDATE users SET easter_egg_id='$easter_egg' WHERE id='$this->id'");
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
        $admin_ar = explode(",",$this->admin_of);

        foreach($admin_ar as $item){
            if($item!=""){
                return true;
            }
        }

        return false;
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
        $admin_ar = explode(",",$this->admin_of);
        $asd = "".$location_id;
        if(in_array($asd,$admin_ar)){
            return true;
        }else{
            return false;
        }
    }

    public function addAdmin($location_id)
    {
        global $mysql;

        $admin_ar = explode(",",$this->admin_of);
        if(!in_array($location_id,$admin_ar)){
            $this->admin_of .= ",".$location_id;
            $mysql->query("UPDATE users SET admin_of='$this->admin_of' WHERE id='$this->id'");
        }
    }

    public function removeAdmin($location_id)
    {
        global $mysql;

        $admin_ar = explode(",",$this->admin_of);
        $location_id = "".$location_id;
        if(in_array($location_id,$admin_ar)){
            $this->admin_of = "";
            foreach($admin_ar as $ids){
                if($ids!=$location_id){
                    $this->admin_of .= ",".$ids;
                }
            }
            $mysql->query("UPDATE users SET admin_of='$this->admin_of' WHERE id='$this->id'");
        }
    }

    public function setName($new_name)
    {
        global $mysql;

        $mysql->query("UPDATE users SET name='$new_name' WHERE id='$this->id'");
    }

    public function getEasterEgg()
    {
        return $this->easter_egg_id;
    }
}