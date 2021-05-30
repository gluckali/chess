<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Spelers</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <?php
        include 'menu.php';
        require_once 'database.php';
        require_once 'table-generator.php';

        $geenDataBeschikbaar = true;

        $db = new database();
        $sql = 'SELECT 
                    s.id, 
                    CONCAT(s.voornaam, " ", s.tussenvoegsel, " ", s.achternaam) as naam, 
                    v.naam as schaakvereniging 
                FROM speler s
                INNER JOIN schaakvereniging v
                ON v.id = s.verenigingID';

        $spelers = $db->select($sql);

        if(is_array($spelers) && !empty($spelers)){
            $geenDataBeschikbaar = false;
            create_table($spelers, 'speler');
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen speler data beschikbaar</p>
        <?php } ?>  

        <button>
            <a href="nieuw-speler.php">Nieuwe speler toevoegen</a>
        </button>
    </body>
</html>