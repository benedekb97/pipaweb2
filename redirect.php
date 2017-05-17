<?php
if(isset($_GET['location']) && $_GET['location']!=""){
    $location = $_GET['location'];
    header("Location: /?location=$location");
}else{
    header("Location: /");
}
sleep(1);
die();