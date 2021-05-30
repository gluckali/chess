<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Uitslag</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>

    <?php
        include 'menu.php';
        require_once 'database.php';
        require_once 'table-generator.php';

        $geenDataBeschikbaar = true;

        $db = new database();

        $sql = '
            SELECT 
            wedstrijd.id,
            wedstrijd.ronde, 
            CONCAT(speler.voornaam, " ", speler.tussenvoegsel, " ", speler.achternaam) as speler1,
            CONCAT(speler1.voornaam, " ", speler1.tussenvoegsel, " ", speler1.achternaam) as speler2,
            wedstrijd.punten1, 
            wedstrijd.punten2,
            wedstrijd.winnaarID
        FROM wedstrijd
        INNER JOIN speler
        ON speler.id = wedstrijd.speler1ID
        INNER JOIN speler speler1
        ON speler1.id = wedstrijd.speler2ID';

        $wedstrijden = $db->select($sql);

        if(is_array($wedstrijden) && !empty($wedstrijden)){
            $geenDataBeschikbaar = false;
            create_table($wedstrijden, 'uitslag', $enableAction=TRUE, $enableEdit=TRUE, $enableDelete=FALSE);
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen wedstrijd data beschikbaar</p>
        <?php } 
        
        ?>  

        
    </body>
</html>