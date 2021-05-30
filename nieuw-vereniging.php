<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nieuwe vereniging toevoegen</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
        include 'menu.php';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            require_once 'database.php';

            $db = new database();

            $sql = "INSERT INTO schaakvereniging VALUES (:id, :naam, :tel);";
            $placeholders = [
                'id'=> NULL,
                'naam'=>$_POST['naam'],
                'tel'=>$_POST['telefoon']

            ];

            $db->insert($sql, $placeholders, 'vereniging');
        }
        ?>

        <form action="nieuw-vereniging.php" method="post">
            <label for="naam">Naam</label><br>
            <input type="text" name="naam"><br>
            <label for="telefoon">Telefoon nummer</label><br>
            <input type="text" name="telefoon"><br>
            <input type="submit" value="Toevoegen">
        </form>
            
    </body>
</html>
