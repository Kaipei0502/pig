<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>租借歸還區</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <?php   
    include("header.php");
    echo "<h3 class='search-hint'>租借歸還區</h3>";
    $link=mysqli_connect('localhost', 'root', '', 'movieplatform');

    if($_SESSION['login'] =='yes'){
        if($_SESSION["level"]== '1'){
            echo "<h1 class='noanswer'>權限不足</h1>";
        }
    }else{
        header("Location:login.php");
    }

    /*租借模式 */
    $sql = "SELECT DVD_id,Movie_name FROM dvd JOIN movie ON dvd.Movie_id=movie.Movie_id WHERE DVD_inhouse = 1 AND DVD_remove is NULL" ;
    $result = mysqli_query($link, $sql);
    echo "<div class= 'rentreturn'>";
    echo "<div class='tab_css'>";
    echo "<input class='tab' id='tab1' type='radio' name='tab' checked='checked'/>";
    echo "<label for='tab1'>租借</label>";
    echo "<div class='tab_content'>";
    echo "<form method='post' action='rentreturn_check.php'><table border=0> ";
    echo "<tr><td class='topic'><h3>租借者帳號:<h3></td><td class='content'><input type ='text' name ='account' class =''></td></tr>";
    echo "<tr><td class='topic'><h3>電影條碼: <h3></td><td class='content'>";
    echo "<select name = 'choosemovie' class = 'rent'>";
    echo '<option value="movie" selected>下拉選擇電影</option>';
    while ($row = mysqli_fetch_assoc($result)) {
							    
        echo "<option value = '".$row['DVD_id']."'>".$row['DVD_id']." <".$row['Movie_name']."></option>";
    }
    echo "</select></td></tr>";
    echo "<tr><td style='text-align:right; padding-top:30px;'colspan ='2'><input type='submit' value='租借'></td></tr>";
    echo "</table></form>";
    echo "</div>";

    /*歸還模式 */
    $sql = "SELECT DVD_id,Movie_name FROM dvd JOIN movie ON dvd.Movie_id=movie.Movie_id WHERE DVD_inhouse = 0";
    $result = mysqli_query($link, $sql);
    echo "<input class='tab' id='tab2' type='radio' name='tab'/>";
    echo "<label for='tab2'>歸還</label>";
    echo "<div class='tab_content'>";
    echo "<form method='post' action='rentreturn_check.php'><table border=0>";
    echo "<tr><td class='topic'><h3>電影條碼: <h3></td><td class='content'>";
    echo "<select name ='returnmovie' class = 'rent'>";
    echo '<option value="" selected>下拉選擇電影</option>';
    while ($row = mysqli_fetch_assoc($result)) {
							    
        echo "<option value = '".$row['DVD_id']."'>".$row['DVD_id']." <".$row['Movie_name']."></option>";
    }
    echo "</select></td></tr>";
    echo "<tr><td style='text-align:right; padding-top:30px;'colspan ='2'><input type='submit' value='歸還'></td></tr>";
    echo "</table></form>";
    echo "</div>"; 
    echo "</div>"; 
    mysqli_close($link);
    ?>

</body>
</html>