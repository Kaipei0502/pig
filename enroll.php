<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <title>佩佩租電影-註冊頁面</title>

</head>

<body>
    <?php include("header.php") ?>
    <?php 
        $checknum = 5;
        $error_message = ''; // 初始化為空字串
    ?>
        <form method="post" action="">
            <div class="enroll-content">
            <table class="enroll">

                <tr>
                <th colspan="3">註冊</th>
                </tr>
                <tr>
                <td> 使用者名稱： </td>
                <td><input type="text" name="User_name" /></td>
                <td>
                    <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if (!preg_match("/^[\d a-zA-Z\x{4e00}-\x{9fa5}]+$/u", $_POST["User_name"])) {
                            $error_message .= "使用者名稱格式不正確<br>";
                            echo"<span class='error'>".$error_message."</span>";
                        }else{
                            echo"格式正確！";
                            $checknum--;
                        }
                    }else{
                        echo"請輸入中文或英文大小寫";
                    }
                    ?>
                </td>
                </tr>
                <tr>
                <td> 帳號（電子信箱）： </td>
                <td><input type="text" name="User_account" /></td>
                <td>
                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if (!filter_var($_POST["User_account"], FILTER_VALIDATE_EMAIL)) {
                            $error_message .= "帳號格式不正確<br>";
                            echo"<span class='error'>".$error_message."</span>";
                        }else{
                            $link = mysqli_connect('localhost' , 'root' , '' , 'movieplatform');
                            mysqli_set_charset($link , "utf8");
                            $user=$_POST["User_account"];
                            $SQL = "SELECT count(User_id) as 'num' FROM user WHERE User_account = '$user'";
                            if(@$result=mysqli_query($link , $SQL)){
                                $row=mysqli_fetch_assoc($result);
                                if($row['num']!=0){
                                    $error_message .= "此帳號已存在<br>";
                                    echo"<span class='error'>".$error_message."</span>";
                                }else{
                                    echo"格式正確！";
                                    $checknum--;                 
                                }
                            }else{
                                $error_message .= "error<br>";
                                echo"<span class='error'>".$error_message."</span>";
                            }                
                        }
                    }else{
                        echo "請輸入有效信箱";
                    }
                    ?>
                </td>
                </tr>


                <tr>
                <td> 密碼： </td>
                <td><input type="text" name="User_password" /></td>
                <td>
                <?php
                $error_message = ''; // 初始化為空字串
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/", $_POST["User_password"])) {
                            $error_message .= "密碼格式不正確<br>";
                            echo"<span class='error'>".$error_message."</span>";
                        }else{
                            echo"格式正確！";
                            $checknum--;
                        }
                    }else{
                        echo "至少包含一個英文大寫、小寫、數字，且長度至少為8";
                    }
                    ?>
                </td>
                </tr>

                <tr>
                <td> 確認密碼： </td>
                <td><input type="text" name="User_checkpassword" /></td>
                <td>
                <?php
                $error_message = ''; // 初始化為空字串
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if ($_POST["User_password"] !== $_POST["User_checkpassword"]) {
                            $error_message .= "密碼不一致<br>";
                            echo"<span class='error'>".$error_message."</span>";
                        }else{
                            echo"格式正確、密碼符合！";
                            $checknum--;
                        }
                    }else{
                        echo "請重新輸入上方的密碼";
                    }
                    ?>
                </td>
                </td>
                </tr>

                <tr>
                <td> 電話： </td>
                <td><input type="text" name="User_phone" /></td>
                <td>
                <?php
                $error_message = ''; // 初始化為空字串
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if (!preg_match("/^\d{10}$/", $_POST["User_phone"])) {
                            $error_message .= "電話格式不正確<br>";
                            echo"<span class='error'>".$error_message."</span>";
                        }else{
                            echo"電話格式正確！";
                            $checknum--; 
                        }
                    }else{
                        echo "請輸入電話";
                    }
                    ?>
                </td>
                </tr>

                <tr>
                <th colspan="3">
                    <a href=""> 
                    <button type="submit" name="submit" value="提交"> 提交 </button></a>
                    <button type="reset" name="reset" value="重置"> 重置 </button>
                </th>
                </tr>
                
                </table>
            </div>
        </form>
    </body>
</html>


<?php
    if( $checknum == 0){
        $User_name = $_POST['User_name'];
        $User_account = $_POST['User_account'];
        $User_password = $_POST['User_password'];
        $User_phone = $_POST['User_phone'];
        $Level_id = 1 ;

        $link = mysqli_connect('localhost' , 'root' , '' , 'movieplatform');
        mysqli_set_charset($link , "utf8");

        $SQL = "INSERT INTO user (User_name,User_account,User_password,User_phone,Level_id) VALUES ('$User_name','$User_account','$User_password','$User_phone','$Level_id')";

        if(mysqli_query($link , $SQL)){
            //header ("Location:index.php");
            header ("Location:login.php");
        }    
    }
?>	



