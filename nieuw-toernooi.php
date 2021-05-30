<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Toernooi toevoegen</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php 
        include 'menu.php';
        require_once 'database.php';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $db = new database();
            $sql = "INSERT INTO toernooi VALUES (:id, :toernooi);";
            $db->insert($sql, ['id'=>NULL, 'toernooi'=>$_POST['toernooi']], 'toernooi');
        }
        ?>
            
        <form action="nieuw-toernooi.php" method="post">
            <label for="toernooi">Toernooi naam</label><br>
            <input type="text" name="toernooi" required><br>
            <input type="submit" value="Toernooi toevoegen"><br>
        </form>

    </body>
</html>