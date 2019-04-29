<?php

$files = scandir(__DIR__);
$loads = array();
foreach ($files as $v){
    if(explode(".",$v)[1]==="php" && $v !== "autoload.php"){
        require "$v";
    }
}

?>