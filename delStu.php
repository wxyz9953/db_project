<?php
/**
 * Created by PhpStorm.
 * User: wxy
 * Date: 2019/5/1
 * Time: 0:35
 */
require "DB.php";
$id = intval($_GET['id']);
$res = DB::q("DELETE FROM " . DB::t("student") . " WHERE number = $id");
?>

