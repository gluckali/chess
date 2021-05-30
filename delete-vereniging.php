<?php
require_once 'delete.php';
delete("DELETE FROM schaakvereniging WHERE id=:id", 'vereniging');
?>