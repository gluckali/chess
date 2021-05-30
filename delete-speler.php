<?php
require_once 'delete.php';
delete("DELETE FROM speler WHERE id=:id", 'speler');
?>