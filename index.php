<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title>佩佩租電影</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <?php   
    include("header.php");
    $link = mysqli_connect('localhost','root','','movieplatform');
    if(!mysqli_select_db($link,'movieplatform')){
        die("無法開啟資料庫<br/>");
    }
    
    // mysqli_close($link);
    ?>

<div class="container">
    <div class="homepage-slider">
        <img class="slider-img" src="https://cms.cdn.91app.com/images/original/40200/cf81c25f-e20b-4bce-839e-1ffe717a6883-1673585964-hnuc08k4de_m_1200x825_800x550_400x275.jpg">
        <img class="slider-img" src="https://wowlavie-aws.hmgcdn.com/file/article_all/A20221109145824643.jpeg">
        <img class="slider-img" src="https://cvcc.tw/wp-content/uploads/20221129215320_37.jpg">
    </div>
    <div class="choose">
    <ul>
        <?php
        if(isset($_GET['type'])){
            $type=$_GET['type'];
        }else{
            $type="0";
        }
        $sql="SELECT * FROM type";
        if(@$result = mysqli_query($link, $sql)){
            if($type==0){
                echo " <li class='target'><a href='index.php'>"."全部"."</a></li>";
            }else{
                echo " <li><a href='index.php'>"."全部"."</a></li>";
            }
            while($row = mysqli_fetch_assoc($result)){
                if($type==$row['Type_id']){
                    echo " <li class='target'><a href='index.php?type=".$row['Type_id']."'>".$row['Type_name']."</a></li>";
                }else{
                    echo " <li><a href='index.php?type=".$row['Type_id']."'>".$row['Type_name']."</a></li>";
                }
            }
        }
        ?>
    </ul>
    </div>
    <div class="movie-list">
        <?php
        @session_start();
        if(isset($_SESSION['login'])){ //確認登入狀態  
            // 有登入
            $userid=$_SESSION['id'];//User_id
            if($type==0){
                // LEFT JOIN後[movie_id]重複導致庫存無法搜尋，因此select全部除了第二個Movie_id 
                $sql="SELECT movie.Movie_id,Movie_name,Movie_long,Movie_level,Movie_director,Movie_actor,Movie_description,Movie_photo,User_id FROM movie LEFT JOIN collection on movie.Movie_id=collection.Movie_id &&collection.User_id=".$userid." WHERE Movie_remove IS NULL";
            }else{
                // LEFT JOIN後[movie_id]重複導致庫存無法搜尋，因此select全部除了第二個Movie_id
                $sql="SELECT movie.Movie_id,Movie_name,Movie_long,Movie_level,Movie_director,Movie_actor,Movie_description,Movie_photo,User_id FROM movietype JOIN type ON type.Type_id=movietype.Type_id JOIN movie ON movie.Movie_id=movietype.Movie_id LEFT JOIN collection on movie.Movie_id=collection.Movie_id &&collection.User_id=".$userid." WHERE movietype.Type_id=$type &&  Movie_remove IS NULL;";
            }
            if(@$result = mysqli_query($link, $sql)){
                if($result->num_rows==0){
                    echo "<h1 class='noanswer'>查無資料</h1>";
                }else{
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='movie-item'>";
                        echo "<a href='browser.php?id=".$row['Movie_id']."'><img class='movie-img' src='".$row['Movie_photo']."'alt=''></a>";
                        echo "<div class='movie-title'>";
                        echo "<h3><a href = 'browser.php?id=".$row['Movie_id']."'>".$row['Movie_name']."</a>&nbsp;";
                        if($row['User_id'] != null){//若有在庫存中則紅色愛心
                            echo "<i id='".$row['Movie_id']."'class='fas fa-heart collection-heart-icon'></i>";
                        }else{
                            echo "<i id='".$row['Movie_id']."'class='fas fa-heart heart-icon'></i>";
                        }
                        echo "</h3>";
                        echo "</div>"; 
                        $inhousesql="SELECT count(DVD_id) as 'num' FROM dvd WHERE dvd.Movie_id =".$row['Movie_id']." && dvd.DVD_inhouse=1 && DVD_remove IS NULL";
                        if(@$inhouseresult = mysqli_query($link, $inhousesql)){
                            $row=mysqli_fetch_assoc($inhouseresult);
                            echo "<div class='movie-stock'>剩餘庫存: ".$row['num']."</div>";
                        }else{
                            echo "<div class='movie-stock'>剩餘庫存: 錯誤</div>";
                        }
                        echo "</div>";
                    }
                }
            }
        }else{ //沒有登入
            if($type==0){//選擇全部類別
                $sql="SELECT * FROM movie WHERE Movie_remove IS NULL";
            }else{//特定類別
                $sql="SELECT * FROM movietype,type,movie WHERE movietype.Type_id=$type && type.Type_id=movietype.Type_id && movie.Movie_id=movietype.Movie_id &&  Movie_remove IS NULL";
            }
            if(@$result = mysqli_query($link, $sql)){
                if($result->num_rows==0){
                    echo "<h1 class='noanswer'>查無資料</h1>";
                }else{
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='movie-item'>";
                        echo "<a href='browser.php?id=".$row['Movie_id']."'><img class='movie-img' src='".$row['Movie_photo']."'alt=''></a>";
                        echo "<div class='movie-title'>";
                        echo "<h3><a href = 'browser.php?id=".$row['Movie_id']."'>".$row['Movie_name']."</a>&nbsp;<i id='".$row['Movie_id']."'class='fas fa-heart heart-icon'></i></h3>";
                        echo "</div>"; 
                        $inhousesql="SELECT * FROM dvd WHERE Movie_id =$row[Movie_id] && DVD_inhouse=1 && DVD_remove IS NULL";
                        if(@$inhouseresult = mysqli_query($link, $inhousesql)){
                            echo "<div class='movie-stock'>剩餘庫存: ".$inhouseresult->num_rows."</div>";
                        }else{
                            echo "<div class='movie-stock'>剩餘庫存: 錯誤</div>";
                        }
                        echo "</div>";
                    }
                }
            }
        }
        
        ?>
    </div>

</div>
<!-- heart轉換js -->
<script type="text/javascript" language="javascript" src="changeheart.js"></script>
<?php
include ("collectionFunction.php");
?>
</body>
</html>
