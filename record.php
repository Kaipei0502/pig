<meta charset='utf-8'>
<?php
session_start(); 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>全體顧客租借資料</title>
	    <link rel="stylesheet" href="report.css" type="text/css">
	    <link rel="stylesheet" href="silder.css" type="text/css">
	    <link rel="stylesheet" href="add.css" type="text/css">
	    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

	</head>
    <body>
		<?php   
	    	include("header.php");
	    ?>
        <div class="add_head">
	    	<h2 class="line1">全體顧客租借資料</h2>
	    </div>
        <hr>
        <?php
        echo "</br>";
        $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
        $SQL = "SELECT m.Movie_name,rt.DVD_id, u.User_name, date(rt.Rent_time) AS 'Rent_time', date(rt.Rent_limittime) AS 'Rent_limittime', date(rt.Rent_returntime) AS 'Rent_returntime', rt.Rent_isreturn, rt.User_id, u.user_name 
        FROM rentrecord rt 
        JOIN dvd ON dvd.DVD_id = rt.DVD_id 
        JOIN movie m ON m.Movie_id = dvd.Movie_id 
        JOIN user u ON u.User_id = rt.User_id";

                
                mysqli_set_charset($link, "utf8");
                if (@$result = mysqli_query($link, $SQL)) {
                    echo "<table class='TB_COLLAPSE'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>租借人姓名</th><th>電影名稱</th><th>DVD編號</th><th>租借時間</th><th>租借到期日</th><th>歸還時間</th><th>租借狀態</th>";
                    echo "</tr>";
                    echo "</thead>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        echo "<tr>";
                        echo "<td>" . $row['User_name'] . "</td><td>" . $row['Movie_name'] . "</td><td>" . $row['DVD_id'] . "</td><td>" . $row['Rent_time'] . "</td><td>" . $row['Rent_limittime'] . "</td><td>" . $row['Rent_returntime'] . "</td>";
                        if($row['Rent_isreturn']=='1'){
                            echo "<td>已歸還</td>";
                        }else{
                            echo "<td style='color:red'>尚未歸還</td>";
                        }
                        echo "</tr>";
                        
                    }
                    echo "</table>";
                mysqli_free_result($result);
                mysqli_close($link);
                }
            ?>
            
    </body>


</html>
