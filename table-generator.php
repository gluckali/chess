<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Results table</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        
            
        <?php

        function create_table($dataset, $from, $enableAction = TRUE, $enableEdit=TRUE, $enableDelete=TRUE){
        
        // check of de dataset een array is en data bevat
        if(is_array($dataset) && !empty($dataset)){ ?>

            <table>
            
            <?php 
            // haal de keys van de array op; dit zijn de kolomnamen
            $columns = array_keys($dataset[0]);
            ?>
            
            <tr>
                <?php foreach($columns as $column){ ?>
                    <th>
                        <strong>
                            <?php echo $column?>
                        </strong>
                    </th>
                <?php } 
                if($enableAction){
                ?>
                <th colspan="2">action</th>
                <?php } ?>
            </tr>
                <?php 
                
                    foreach($dataset as $rows=>$row){ 
                    $row_id = $row['id']; ?>
                    <tr>
                    <?php foreach($row as $rowdata){ ?>
                        
                        <td><?php echo $rowdata; ?></td>
                    <?php } 
                    
                    if($enableAction){
                        if($enableEdit){
                    ?>

                    <td>
                        <a href="edit-<?php echo $from?>.php?id=<?php echo $row_id; ?>" class="edit_btn" >Edit</a>
                    </td>
                    <?php } ?>

                    <?php if($enableDelete){ ?>
                    <td>
                        <a href="delete-<?php echo $from?>.php?id=<?php echo $row_id; ?>" class="delete_btn" >Delete</a>
                    </td>
                    <?php }} ?>
                    </tr>
            <?php }
         }
    }?>
    </table>

    <br>
    
    </body>
    
</html>