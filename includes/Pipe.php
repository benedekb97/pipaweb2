<?php

require_once('Settings.php');

class Pipe
{
    private $id;
    private $type;
    private $created;
    private $ready;
    private $dying;
    private $preparing;
    private $created_by;
    private $location_id;

    public function getStatus()
    {
        $settings = new Settings();
        $created_time = strtotime($this->created);

        /*echo $created_time + $settings->getReadyTime();echo "ready<br>";
        echo time();echo "<br>";
        echo $created_time + $settings->getDyingTime();echo "dying<br>";
        echo time();echo "<br>";
        echo $created_time + $settings->getEndTime();echo "dead<br>";
        echo time();echo "<br>";
*/

        if($created_time + $settings->getReadyTime() > time()){
            return "starting";
        }elseif($created_time + $settings->getReadyTime() < time() && $created_time + $settings->getDyingTime() > time()){
            return "ok";
        }elseif($created_time + $settings->getDyingTime() < time() && $created_time + $settings->getEndTime() > time()){
            return "dying";
        }else{
            return "dead";
        }
    }

    public function __construct($id)
    {
        global $mysql;

        $query = $mysql->query("SELECT * FROM pipes WHERE id='$id'");
        $pipe_data = $query->fetch_assoc();

        $this->id =$id;
        $this->type = $pipe_data['type'];
        $this->created = $pipe_data['created'];
        $this->ready = $pipe_data['ready'];
        $this->dying = $pipe_data['dying'];
        $this->preparing = $pipe_data['preparing'];
        $this->created_by = $pipe_data['created_by'];
        $this->location_id = $pipe_data['location_id'];

    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCreatedBy()
    {
        return $this->created_by;
    }

    public function setType($new_type)
    {
        global $mysql;

        $mysql->query("UPDATE pipes SET type='$new_type' WHERE id='$this->id'");
    }

    public function setCreatedAt($new_time)
    {
        global $mysql;
        $settings = new Settings();

        if($new_time=="ok"){
            $new_time = time() - $settings->getReadyTime();
        }elseif($new_time=="starting"){
            $new_time = time();
        }elseif($new_time=="dying"){
            $new_time = time() - $settings->getDyingTime();
        }elseif($new_time=="dead"){
            $new_time = time() - $settings->getEndTime();
        }else{
            return null;
        }
        $new_time = date("Y-m-d H:i:s",$new_time);
        $mysql->query("UPDATE pipes SET created='$new_time' WHERE id='$this->id'");
        return true;
    }
}