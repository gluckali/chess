<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Schaakverenigingen</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <?php 
        include 'menu.php';
        require_once 'database.php';
        require_once 'table-generator.php';

        $geenDataBeschikbaar = true;


        $db = new database();
        $vereniging = $db->select("SELECT * FROM schaakvereniging");

        if(is_array($vereniging) && !empty($vereniging)){
            $geenDataBeschikbaar = false;
            create_table($vereniging, 'vereniging');
        }else if($geenDataBeschikbaar){ ?>
            <p class='no-data'>Geen data beschikbaar</p>
        <?php } ?>  

        <button>
            <a href="nieuw-vereniging.php">Nieuwe schaakvereniging toevoegen</a>
        </button>

        
    </body>
</html>