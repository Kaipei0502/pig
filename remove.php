<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>下架區</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <?php  
    include("header.php");
    echo "<h3 class='search-hint'>下架區</h3>";
    @session_start();
    if(@$_SESSION['login']!='yes'){
        echo "<h1 class='noanswer'>請先登入，三秒後移動至登入畫面</h1>";
        header('Refresh:3;url=login.php');
    }else if(@$_SESSION['level']==1){
        echo "<h1 class='noanswer'>權限不足，三秒後離開</h1>";
        header('Refresh:3;url=index.php');
    }else{//老闆或員工才能進入
        $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
        /*DVD模式 */
        $sql = "SELECT DVD_id,Movie_name FROM dvd JOIN movie ON dvd.Movie_id=movie.Movie_id WHERE  DVD_remove IS NULL && DVD_inhouse = 1";
        $result = mysqli_query($link, $sql);
        echo "<div class= 'remove'>";
        echo "<div class='tab_css'>";
        echo "<input class='tab' id='tab1' type='radio' name='tab' checked='checked'/>";
        echo "<label for='tab1'>DVD</label>";
        echo "<div class='tab_content'>";
        echo "<form method='post' action='remove_check.php'><table border=0> ";
        echo "<tr><td class='topic'><h3>DVD編號: <h3></td><td class='content'>";
        echo "<select name = 'DVD' class = 'remove'>";
        echo '<option value="" selected>下拉選擇DVD</option>';
        while ($row = mysqli_fetch_assoc($result)) {
                                    
            echo "<option value = '".$row['DVD_id']."'>".$row['DVD_id']." <".$row['Movie_name']."></option>";
        }
        echo "</select></td></tr>";
        echo "<tr><td style='text-align:right; padding-top:30px;'colspan ='2'><input type='submit' value='下架'></td></tr>";
        echo "</table></form>";
        echo "</div>";

        /*電影模式 */
        $sql = "SELECT Movie_name,Movie_id FROM movie WHERE Movie_remove IS NULL && (Movie_id IN (SELECT Movie_id FROM `dvd` GROUP BY Movie_id HAVING sum(DVD_inhouse)=count(DVD_id)) || Movie_id IN (SELECT movie.Movie_id FROM movie LEFT JOIN dvd ON movie.Movie_id = dvd.Movie_id GROUP BY movie.Movie_id HAVING count(dvd.DVD_id)=0))";
        $result = mysqli_query($link, $sql);
        echo "<input class='tab' id='tab2' type='radio' name='tab'/>";
        echo "<label for='tab2'>電影</label>";
        echo "<div class='tab_content'>";
        echo "<form method='post' action='remove_check.php'><table border=0>";
        echo "<tr><td class='topic'><h3>電影名稱: <h3></td><td class='content'>";
        echo "<select name ='movie' class = 'remove'>";
        echo '<option value="movie" selected>下拉選擇電影</option>';
        while ($row = mysqli_fetch_assoc($result)) {
                                    
            echo "<option value = '".$row['Movie_id']."'> <".$row['Movie_name']."></option>";
        }
        echo "</select></td></tr>";
        echo "<tr><td style='text-align:right; padding-top:30px;'colspan ='2'><input type='submit' value='移除'></td></tr>";
        echo "</table></form>";
        echo "</div>"; 
        echo "</div>"; 
        mysqli_close($link);
    }
    
    ?>

</body>
</html>
