<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>顧客租借歸還頁</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>

<body>
    <?php   
    include("header.php");
    ?> 
    <div class =  "rentrecord">
    <?php
        $link=@mysqli_connect('localhost','root','','movieplatform');

        $SQL='SELECT*FROM rentrecord';
        if(@$result=mysqli_query($link,$SQL)){
        echo "<table border='1'>";
        while($row=mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['User_id']."</td><td>".$row['Rent_id']."</td><td>".$row['DVD_id']."</td><td>".$row['Rent_time']."</td><td>".$row['Rent_limittime']."</td>
              <td>".$row['Rent_isreturn']."</td><td>".$row['Rent_returntime']."</td>";
        echo "</tr>";
        }
        echo "</table>";
        } 
    ?>
    </div>
</body>

</html>