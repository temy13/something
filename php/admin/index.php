<?php
require '../db.php';
$query = 'select * from twitter_user';
$result = $mysqli->query($query);

?>

 <?php require '../header.php'; ?>
 <body>
   <div class="container">
     <ul class="list-group">
     <?php while ($row = $result->fetch_assoc()) { ?>
       <li class="list-group-item">
         <form action = "update.php" method = "get">
           <div class="d-inline"><?php echo $row["screen_name"] ?></div>
           <input type="hidden" name="id" value="<?php echo intval($row["id"]); ?>">
           <label class="radio-inline"><input type="radio" name="allowed" value="true" <?php echo $row["allowed"] ? "checked" : "" ?> >有効</label>
           <label class="radio-inline"><input type="radio" name="allowed" value="false" <?php echo !$row["allowed"] ? "checked" : "" ?> >無効</label>
           <button type="submit" class="btn btn-primary">送信</button>
         </form>

      </li>
     <? } ?>
    </ul>
   </div>
 </body>
 </html>
