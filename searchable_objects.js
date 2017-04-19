<?php
include_once "helper.php";
session_start();

global $db;
$query = "SELECT media_id, title, type, upload_date, description FROM media";
$result = mysqli_query($db, $query);
?>

var objects = [];

while ($row = mysqli_fetch_row($result))
{
?>
    objects.append({media_id : <?php echo $row[0] ?>,
                    title : <?php echo $row[1] ?>,
                    type : <?php echo $row[2] ?>,
                    upload_date : <?php echo date_format(date_create($row[3]), ' F Y') ?>,
                    description : <?php echo $row[4] ?>});
<?php
}
?>
