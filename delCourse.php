<?php
require "DB.php";
$id = intval($_GET['id']);
DB::q("DELETE FROM " . DB::t("course") . " WHERE number = :n", [':n' => $id]);
?>