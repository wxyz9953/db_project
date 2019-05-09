<?php
require "DB.php";
$id = intval($_GET['id']);
DB::q("DELETE FROM " . DB::t("enroll") . " WHERE id = :i", [':i' => $id]);
?>