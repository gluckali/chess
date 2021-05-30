<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nieuwe speler toevoegen</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>

        <?php 

        include 'menu.php'; 
        require_once 'database.php';

        $db = new database();
        $verenigingen = $db->select('SELECT * FROM schaakvereniging');

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $sql = "
                INSERT INTO 
                    speler 
                VALUES (:id, :naam, :tvoegsel, :achternaam, :verenigingID, :deelname)";

            $named_placeholders = [
                'id'=> NULL,
                'naam'=>$_POST['voornaam'],
                'tvoegsel'=>$_POST['tussenvoegsel'],
                'achternaam'=>$_POST['achternaam'],
                'verenigingID'=>$_POST['vereniging'],
                'deelname'=> 0
            ];

            $db->insert($sql, $named_placeholders, 'speler');
        }

        ?>

        <form action="nieuw-speler.php" method="post">
            <label for="voornaam">Voornaam</label><br>
            <input type="text" name="voornaam" required><br>
            <label for="tussenvoegsel">Tussenvoegsel</label><br>
            <input type="text" name="tussenvoegsel"><br>
            <label for="achternaam">Achternaam</label><br>
            <input type="text" name="achternaam" required><br><br>
            <label for="vereniging">Schaakvereniging</label><br>

            <?php if(is_array($verenigingen) && !empty($verenigingen)){?>
            <select name="vereniging" required>
                <?php foreach($verenigingen as $key=> $vereniging){?>
                    <option value="<?php echo $vereniging['id'];?>"><?php echo $vereniging['naam'];?></option>
                <?php } ?>
            </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Voeg eerst een schaakvereniging toe</p>
            <?php } ?>
            <input type="submit" value="Speler toevoegen" <?php if(!is_array($verenigingen) && empty($verenigingen)){ ?> disabled="disabled" <?php } ?>>
        </form>
    </body>
</html>