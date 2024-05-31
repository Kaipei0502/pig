<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title>佩佩租電影</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    include("header.php");
    // 資料庫開啟
    $link = mysqli_connect('localhost','root','','movieplatform');
    if(!mysqli_select_db($link,'movieplatform')){
        die("無法開啟資料庫<br/>");
    }
    // 搜尋
    if(isset($_GET['search'])){
        $search=$_GET['search'];
        echo "<h3 class='search-hint'><i class=' fa fa-search'></i>「".$search."」的搜尋結果</h3>";
        @session_start();
        if(isset($_SESSION['login'])){//有登入
            echo "<div class='movie-list'>";
            $userid=$_SESSION['id'];//User_id
            $sql="SELECT movie.Movie_id,Movie_name,Movie_long,Movie_level,Movie_director,Movie_actor,Movie_description,Movie_photo,User_id FROM movie LEFT JOIN collection on movie.Movie_id=collection.Movie_id && collection.User_id=".$userid." WHERE Movie_name LIKE"."'%".$search."%' && Movie_remove IS NULL";
            if(@$result = mysqli_query($link, $sql)){
                if($result->num_rows==0){
                    echo "<h1 class='noanswer'>查無資料</h1>";
                }else{
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='movie-item'>";
                        echo "<a href='browser.php?id=".$row['Movie_id']."'><img class='movie-img' src='".$row['Movie_photo']."'alt=''></a>";
                        echo "<div class='movie-title'>";
                        echo "<h3><a href = 'browser.php?id=".$row['Movie_id']."'>".$row['Movie_name']."</a>&nbsp;";
                        if($row['User_id'] != null){
                            echo "<i id='".$row['Movie_id']."'class='fas fa-heart collection-heart-icon'></i>";
                        }else{
                            echo "<i id='".$row['Movie_id']."'class='fas fa-heart heart-icon'></i>";
                        }
                        echo "</h3>";
                        echo "</div>"; 
                        $inhousesql="SELECT count(DVD_id) as 'num' FROM dvd WHERE dvd.Movie_id =".$row['Movie_id']." && dvd.DVD_inhouse=1&& DVD_remove IS NULL";
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
        }else{//沒登入
            $sql="SELECT * FROM movie WHERE Movie_name LIKE"."'%".$search."%'";
            echo "<div class='movie-list'>";
            if(@$result = mysqli_query($link, $sql)){
                if($result->num_rows==0){
                    echo "<h1 class='noanswer'>查無資料</h1>";
                }else{
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<div class='movie-item'>";
                        echo "<a href='browser.php?id=".$row['Movie_id']."'><img class='movie-img' src='".$row['Movie_photo']."'alt=''></a>";
                        echo "<div class='movie-title'>";
                        echo "<h3><a href = 'browser.php?id=".$row['Movie_id']."'>".$row['Movie_name']."</a>&nbsp;";
                        echo "<i class='fas fa-heart heart-icon' id=".$row['Movie_id']."></i></h3>";
                        echo "</div>"; 
                        $inhousesql="SELECT count(DVD_id) as 'num' FROM dvd WHERE Movie_id =$row[Movie_id] && DVD_inhouse=1&& DVD_remove IS NULL";
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
            echo "</div>";

        }
    }else{ 
        echo "<h3 class='search-hint'>請先於搜尋欄輸入關鍵字</h3>";
    }
    include ("collectionFunction.php");
    ?>
    <!-- heart轉換js -->
    <script type="text/javascript" language="javascript" src="changeheart.js"></script>
</body>
</html>
