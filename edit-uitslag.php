<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Wijzig uitslag</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php 
    include 'menu.php';
    require_once 'database.php';

    $db = new database();

    if(isset($_GET['id'])){
        $sql = '
            SELECT 
                w.id, 
                w.toernooiID,
                t.toernooi,
                w.speler1ID,
                CONCAT(s.voornaam, " ", s.tussenvoegsel, " ", s.achternaam) as speler1,
                w.speler2ID,
                CONCAT(s1.voornaam, " ", s1.tussenvoegsel, " ", s1.achternaam) as speler2,
                w.ronde
            FROM 
                wedstrijd w
            INNER JOIN toernooi t
            ON t.id = w.toernooiID
            INNER JOIN speler s
            ON s.id = w.speler1ID
            INNER JOIN speler s1
            ON s1.id = w.speler2ID
            WHERE w.id=:id';
        $wedstrijdData = $db->select($sql, ['id'=>$_GET['id']])[0];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){  
        // winnaarID
        $wid = NULL;

        // bereken winnaarID op basis van ingevoerde punten
        // gelijkspel
        if($_POST['punten1'] == $_POST['punten2']){
            $wid = NULL;
        }

        if($_POST['punten1'] > $_POST['punten2']){
            // winnaarid
            $wid = $_POST['speler1'];
        }else{
            // speler 2 heeft hoogst aantal punten
            $wid = $_POST['speler2'];
        }

        $sql = "UPDATE wedstrijd SET punten1=:p1, punten2=:p2, winnaarID=:wid WHERE id=:id";
        $placeholders = [
            'p1'=>$_POST['punten1'], 
            'p2'=>$_POST['punten2'],
            'wid'=>$wid,
            'id'=>$_POST['id']
        ];
        
        $db->update_or_delete($sql, $placeholders, 'uitslag');
    }
    ?>
    <form action="edit-uitslag.php" method="post">
        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : ''; ?>">
        <label for="toernooiID">Toernooi</label><br><br>
        <select name="toernooiID" disabled="disabled">
            <option value="<?= $wedstrijdData['toernooiID'] ?>"><?= $wedstrijdData['toernooi'] ?></option>
        </select>
        <label for="speler1">Speler 1</label><br><br>
        <select name="speler1">
            <option value="<?= $wedstrijdData['speler1ID'] ?>"><?= $wedstrijdData['speler1'] ?></option>
        </select>
        <label for="speler2">Speler 2</label><br><br>
        <select name="speler2">
        <option value="<?= $wedstrijdData['speler2ID'] ?>"><?= $wedstrijdData['speler2'] ?></option>
        </select>
        <label for="ronde">Ronde</label><br><br>
        <select name="ronde" disabled="true">
            <option value="<?= $wedstrijdData['ronde'] ?>"><?= 'Ronde ' . $wedstrijdData['ronde'] ?></option>
        </select>
        <label for="punten1">Punten speler 1</label><br><br>
        <input type="text" name="punten1">
        <label for="punten2">Punten speler 2</label><br><br>
        <input type="text" name="punten2">
        <input type="submit" value="Uitslag toevoegen">
    </form>
        
    </body>
</html>