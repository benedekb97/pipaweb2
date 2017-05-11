<?php
if(isset($_SESSION['uuid'])){
    global $users;
    $current_user = $users->getUserById($_SESSION['uuid']);
}