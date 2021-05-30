<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wedstrijden</title>        
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php 
        include 'menu.php';
        require_once 'database.php';
        //	ronde	punten1	punten2	winnaarID

        $db = new database();
        $toernooien = $db->select("SELECT * FROM toernooi;");

        // haal alle spelers zonder deelname op, anderen spelen namelijk al
        $sql = '
            SELECT 
                id, 
                CONCAT(voornaam, " ", tussenvoegsel, " ", achternaam) as naam
            FROM 
                speler 
            WHERE neemtDeel=0';

        $spelers = $db->select($sql);
        
        // we moeten twee spelers selecteren, maar de mogelijkheid om 2x zelfde te selecteren uitsluiten.
        // zorg dat alle spelers op een even index naar lijst 2 gaan, alle andere naar lijst 1.
        $spelersLijst1 = [];
        $spelersLijst2 = [];

        foreach($spelers as $key=>$speler){
            // met de modulo kun je restanten berekenen. 
            // Wanneer de restand van een deling met 2 in een 0 resulteert, spreken we van een even getal.
            if($key % 2 == 0){
                array_push($spelersLijst2, $speler);
            }else{
                array_push($spelersLijst1, $speler);
            }
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            // zorg ervoor dat de deelname status van de speler updated wordt
            $sql = "UPDATE speler SET neemtDeel=1 WHERE id IN (:id, :id2)";
            $placeholders = [
                'id'=>$_POST['speler1'], 
                'id2'=>$_POST['speler2']
            ];
            $db->update_or_delete($sql, $placeholders);

            // zorg er vervolgens voor dat de data uit het form wordt opgeslagen.
            $sql1 = "INSERT INTO wedstrijd VALUES (:id, :toernooiID, :speler1ID, :speler2ID, :ronde, :punten1, :punten2, :winID)";
            
            $placeholders1 = [
                'id'=>NULL,
                'toernooiID'=>$_POST['toernooi'],
                'speler1ID'=>(int)$_POST['speler1'],
                'speler2ID'=>(int)$_POST['speler2'],
                'ronde'=>$_POST['ronde'],
                'punten1'=>NULL,
                'punten2'=>NULL,
                'winID'=>NULL
            ];

            $db->insert($sql1, $placeholders1, 'wedstrijd');
        }
        
        ?>
        <form action="nieuw-wedstrijd.php" method="post">
            <?php if(is_array($toernooien) && !empty($toernooien)){?>
                <label for="toernooi">Toernooien</label>
                <select name="toernooi" required>
                    <?php foreach($toernooien as $key=> $toernooi){?>
                        <option value="<?php echo $toernooi['id'];?>"><?php echo $toernooi['toernooi'];?></option>
                    <?php } ?>
                </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Voeg eerst een toernooi toe</p>
            <?php } ?>

            <!-- Speler 1 -->
            <?php if(is_array($spelersLijst1) && !empty($spelersLijst1)){?>
                <label for="speler1">Speler 1</label>
                <select name="speler1" required>
                    <?php foreach($spelersLijst1 as $key=> $speler){?>
                        <option value="<?php echo $speler['id'];?>"><?php echo $speler['naam'];?></option>
                    <?php } ?>
                </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Wacht op een beschikbare speler</p>
            <?php } ?>
            
            <!-- Speler 2 -->
            <?php if(is_array($spelersLijst2) && !empty($spelersLijst2)){?>
                <label for="speler2">Speler 2</label>
                <select name="speler2" required>
                    <?php foreach($spelersLijst2 as $key=> $speler){?>
                        <option value="<?php echo $speler['id'];?>"><?php echo $speler['naam'];?></option>
                    <?php } ?>
                </select><br><br>
            <?php }else{ ?>
                    <p class='no-data'>Wacht op een beschikbare speler</p>
            <?php } ?>

            <!-- rondes zijn fixed (max 3) -->
            <label for="ronde">Rondes</label>
            <select name="ronde">
                <option value="1">Ronde 1</option>
                <option value="2">Ronde 2</option>
                <option value="3">Ronde 3</option>
            </select><br><br>

            <input type="submit" value="Voeg wedstrijd toe">
        </form>
        
    </body>
</html>