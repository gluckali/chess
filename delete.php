<?php
require_once 'database.php';

function delete($sql, $from){
    
    if(isset($_GET['id'])){
        $db = new database();    
        $db->update_or_delete($sql, ['id'=>$_GET['id']], $from);
    }else{
        header("location: $from.php");
    }
}

?>