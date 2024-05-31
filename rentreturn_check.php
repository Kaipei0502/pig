<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
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
    if($_SESSION['login'] =='yes'){//查看是否有登入
        if($_SESSION["level"]== '1'){//是否為使用者
            echo "<h1 class='noanswer'>權限不足</h1>";
        }
    }else{
        header("Location:login.php");
    }
    if (isset($_POST["account"]) && isset($_POST["choosemovie"])){
        @session_start();
        $account = $_POST["account"];
        $choosemovie = $_POST["choosemovie"];   
        $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
        $sql = "SELECT User_account,User_id FROM user WHERE User_account = '$account'";
        if($result = mysqli_query($link, $sql)){
            if($result->num_rows>0){//是會員則加入
                $sql = "UPDATE dvd SET DVD_inhouse = '0' WHERE DVD_id = '$choosemovie'";
                if(mysqli_query($link, $sql)){
                    $now =date('Y-m-d H:i:s',time());
                    $limit = date('Y-m-d H:i:s',strtotime('+7 days'));
                    $row = mysqli_fetch_assoc($result);
                    $userid = $row['User_id'];
                    $sql = "INSERT INTO `rentrecord`(`Rent_time`, `Rent_limittime`, `Rent_isreturn`, `Rent_returntime`, `User_id`, `DVD_id`)  VALUES('$now' ,'$limit', '0', NULL, $userid,'$choosemovie')";
                    mysqli_query($link, $sql);
                    echo "<h1 class='noanswer'>已成功租借</h1>";
                    header("refresh:3;url=rentreturn.php");
                }       
            }else{//非會員則離開
                echo "<h1 class='noanswer'>此帳號非會員</h1>";
                header("refresh:3;url=rentreturn.php");
            }
        }
    }

    //歸還
    if (isset($_POST["returnmovie"])){
        $returnmovie = $_POST["returnmovie"];
        $now =date('Y-m-d H:i:s',time());
        $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
        $sql = "UPDATE rentrecord SET Rent_isreturn = '1',Rent_returntime = '$now' WHERE DVD_id = '$returnmovie'";
        mysqli_query($link, $sql);
        $sql = "UPDATE dvd SET DVD_inhouse = '1' WHERE DVD_id = '$returnmovie'";
        mysqli_query($link, $sql);
        echo "<h1 class='noanswer'>已成功歸還</h1>";
        header("refresh:3;url=rentreturn.php");

    }
    mysqli_close($link);
    ?>
</body>
</html>

