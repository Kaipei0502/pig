<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
    <title></title>
</head>
<body>
    <?php
    $link=@mysqli_connect('localhost','root','','movieplatform');
    if(isset($_GET["id"])){
        include("header.php");
        $id=$_GET["id"];
        $sql="SELECT * FROM movie WHERE Movie_id= $id";
        if(@$result=mysqli_query($link,$sql)){
                $row = mysqli_fetch_assoc($result);
                echo "<ul class='breadcrumb'>";
                echo "<li class='breadcrumb-item'><bold><a href='index.php'>首頁 ></a></bold></li>";
                echo "<li class='breadcrumb-item'><bold>".$row['Movie_name']."</bold></li></ul>";
                echo "<div class='frame'>";
                echo "<img src=".$row['Movie_photo']." alt=''>";
                echo "<table border=0>";
                echo"<tr><td class='topic'><h3>電影名稱:</td><td class='content'><h3>".$row["Movie_name"]."</td></tr>";
                echo"<tr><td class='topic'><h3>片長:</td><td class='content'><h3>".$row["Movie_long"]."分鐘</td></tr>";
                echo"<tr><td class='topic'><h3>分級:</td><td class='content'><h3>".$row["Movie_level"]."</td></tr>";
                echo"<tr><td class='topic'><h3>導演:</td><td class='content'><h3>".$row["Movie_director"]."</td></tr>";
                echo"<tr><td class='topic'><h3>演員:</td><td class='content'><h3>".$row["Movie_actor"]."</td></tr>";
                echo"<tr><td class='topic'><h3>電影介紹:</td><td class='content'><h3>".$row["Movie_description"]."</td></tr>";
                $sql="SELECT * FROM dvd,movie WHERE dvd.Movie_id=movie.Movie_id && dvd.DVD_inhouse=1 && dvd.Movie_id=$id && DVD_remove IS NULL";
                if(@$result=mysqli_query($link,$sql)){
                    echo"<tr><td class='topic'><h4>庫存:</td><td class='content'><h4>".$result->num_rows."</td></tr>";   
                }
                echo "</table></div>";
        }

    }else{
        echo "<div class='browser'>error</div>";
    }
    
    mysqli_close($link);

    ?>
</body>
</html>
