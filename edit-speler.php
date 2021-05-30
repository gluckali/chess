<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wijzig speler</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
        include 'menu.php';
        require_once 'database.php';
        $db= new database();
        $verenigingen = $db->select('SELECT * FROM schaakvereniging');

        if(isset($_GET['id'])){
        $sql = '
            SELECT 
                voornaam, 
                tussenvoegsel, 
                achternaam
            FROM 
                speler 
            WHERE 
                id=:id';
        $speler = $db->select($sql, ['id'=>$_GET['id']])[0];
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $sql = "
                UPDATE 
                    speler 
                SET 
                    voornaam=:naam, 
                    tussenvoegsel=:tvoegsel, 
                    achternaam=:anaam,
                    verenigingID=:verenigingID
                WHERE
                    id=:id
            ";

            $placeholders = [
                'id'=>$_POST['id'],
                'naam'=>$_POST['naam'],
                'tvoegsel'=>$_POST['tvoegsel'],
                'anaam'=>$_POST['anaam'],
                'verenigingID'=>$_POST['vereniging']
            ];
            $db->update_or_delete($sql, $placeholders,'speler');
        }
        ?>
        <form action="edit-speler.php" method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET) ? $_GET['id'] : ''?>">
            <label for="naam">Naam</label><br>
            <input type="text" name="naam" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $speler['voornaam'] : ''?>" required><br>
            <label for="tvoegsel">Tussenvoegsel</label><br>
            <input type="text" name="tvoegsel" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $speler['tussenvoegsel'] : ''?>"><br>
            <label for="naam">Achternaam</label><br>
            <input type="text" name="anaam" onfocus="this.value=''" value="<?= isset($_GET['id']) ? $speler['achternaam'] : ''?>" required><br>

            <?php if(is_array($verenigingen) && !empty($verenigingen)){?>
            <select name="vereniging" required>
                <?php foreach($verenigingen as $key=> $vereniging){?>
                    <option value="<?php echo $vereniging['id'];?>"><?php echo $vereniging['naam'];?></option>
                <?php } ?>
            </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Voeg eerst een schaakvereniging toe</p>
            <?php } ?>

            <input type="submit" value="Wijzig">
        </form>
    </body>
</html>