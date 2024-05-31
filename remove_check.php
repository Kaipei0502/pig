<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>移除結果</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
<?php
include("header.php");
echo "<h3 class='search-hint'>結果</h3>";
//租借
date_default_timezone_set('Asia/Taipei');
@session_start();
if($_SESSION['login'] =='yes'){
    if($_SESSION["level"]== '1'){
        echo "<h1 class='noanswer'>權限不足</h1>";
    }
}else{
    header("Location:login.php");
}
@session_start();
if(isset($_POST['DVD'])){//移除DVD
    $DVD_id=$_POST['DVD'];
    echo $DVD_id;
    $SQL="UPDATE dvd SET DVD_remove=1 WHERE DVD_id="."'$DVD_id'";
    $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
    $result=mysqli_query($link,$SQL);
    echo "<h1 class='noanswer'>已成功移除DVD</h1>";
    header("refresh:3;url=remove.php");
    
}
if(isset($_POST['movie'])){//移除Movie
    $movie=$_POST['movie'];
    $SQL1="UPDATE dvd SET DVD_remove = 1 WHERE Movie_id="."'$movie'";
    $SQL2='UPDATE movie SET Movie_remove=1 WHERE Movie_id='."'$movie'";
    $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
    $result1=mysqli_query($link,$SQL1);
    $result2=mysqli_query($link,$SQL2);
    echo "<h1 class='noanswer'>已成功移除電影</h1>";
    header("refresh:3;url=remove.php");
}
?>
</body>
</html>