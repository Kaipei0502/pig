<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的收藏</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<body>
    <?php   
    include("header.php");
    $link = mysqli_connect('localhost','root','','movieplatform');
    @session_start();
    $userid = $_SESSION['id'];
    if($_SESSION['login']=='yes'){
        $sql="SELECT * FROM movie JOIN collection ON movie.Movie_id = collection.Movie_id WHERE User_id = $userid && Movie_remove IS NULL";
        echo "<h3 class='search-hint'>我的收藏</h3>";
        echo "<div class='movie-list'>";
        if(@$result = mysqli_query($link, $sql)){
            if($result->num_rows==0){
                echo "<h1 class='noanswer'>你目前沒有收藏的電影喔!</h1>";
            }else{
                while($row = mysqli_fetch_assoc($result)){ 
                    echo "<div class='movie-item'>";
                    echo "<a href='browser.php?id=".$row['Movie_id']."'><img class='movie-img' src='".$row['Movie_photo']."'alt=''></a>";
                    echo "<div class='movie-title'>";
                    echo "<h3><a href = 'browser.php?id=".$row['Movie_id']."'>".$row['Movie_name']."</a>&nbsp;  ";
                    if($row['User_id'] != null){//若有在庫存中則紅色愛心
                        echo "<i id='".$row['Movie_id']."'class='fas fa-heart collection-heart-icon'></i>";
                    }else{
                        echo "<i id='".$row['Movie_id']."'class='fas fa-heart heart-icon'></i>";
                    }
                    echo "</h3>";
                    echo "</div>"; 
                    $inhousesql="SELECT count(DVD_id) as 'inventory' FROM dvd WHERE Movie_id =$row[Movie_id] && DVD_inhouse=1 && DVD_remove IS NULL";
                    if(@$inhouseresult = mysqli_query($link, $inhousesql)){
                        $row=mysqli_fetch_assoc($inhouseresult);
                        echo "<div class='movie-stock'>剩餘庫存: ".$row['inventory']."</div>";
                    }else{
                        echo "<div class='movie-stock'>剩餘庫存: 錯誤</div>";
                    }
                    echo "</div>";
                }
            }
        }else{
            echo "資料庫查詢失敗";
        }
        echo "</div>";
    }else{
        header("Location:login.php");
        
    }
    ?>
    <!-- heart轉換js -->
    <script type="text/javascript" language="javascript" src="changeheart.js"></script>
    <!-- <i class='fas fa-heart collection-heart-icon'></i> -->
    <?php
    include ("collectionFunction.php");
    ?>
</body>
</html>
