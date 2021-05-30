<?php
require_once 'delete.php';
delete("DELETE FROM toernooi WHERE id=:id", 'toernooi');
?>