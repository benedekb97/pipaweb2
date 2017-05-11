<?php
if(isset($_SESSION['uuid'])){
    global $users;
    $current_user = $users->getUserByUuid($_SESSION['uuid']);
}