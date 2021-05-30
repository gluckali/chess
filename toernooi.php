<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toernooien</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<?php 
include 'menu.php';
require_once 'database.php';
require_once 'table-generator.php';

$geenDataBeschikbaar = true;

$db = new database();
$toernooien = $db->select("SELECT * FROM toernooi;");

if(is_array($toernooien) && !empty($toernooien)){
    $geenDataBeschikbaar = false;
    create_table($toernooien, 'toernooi');
}else if($geenDataBeschikbaar){ ?>
    <p class='no-data'>Geen toernooi data beschikbaar</p>
<?php } ?>  

<button>
<a href="nieuw-toernooi.php">Nieuw toernooi toevoegen</a>
</button>
    
</body>
</html>