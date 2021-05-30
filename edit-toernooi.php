<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wijzig toernooi</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
        include 'menu.php';
        require_once 'database.php';
        $db= new database();

        if(isset($_GET['id'])){
        $sql = "SELECT toernooi FROM toernooi WHERE id=:id";
        $toernooi = $db->select($sql, ['id'=>$_GET['id']])[0];
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $db= new database();
            $sql = "UPDATE toernooi SET toernooi=:naam WHERE id=:id";
            $placeholders = [
                'id'=>$_POST['id'],
                'naam'=>$_POST['naam']
            ];

            $db->update_or_delete($sql, $placeholders,'toernooi');
        }
        ?>
        <form action="edit-toernooi.php" method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET) ? $_GET['id'] : ''?>">
            <label for="naam">Naam</label><br>
            <input type="text" name="naam" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $toernooi['toernooi'] : ''?>"><br>
            <input type="submit" value="Wijzig">
        </form>
    </body>
</html>