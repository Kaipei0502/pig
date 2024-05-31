<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <title>佩佩租電影-登入頁面</title>

</head>

<body>
    <?php include("header.php") ?>
    <?php 
        $checknum = 2;
    ?>

        <form method="post" action="">
            <div class="login-content">
            <table class="enroll">

                <tr>
                <th colspan="3">登入</th>
                </tr>

                <tr>
                <td>帳號（電子郵件）：</td>
                <td><input type="text" name="User_account" /></td>
                <td>
                <?php
                $error_message = ''; // 初始化為空字串
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
                                if($row['num']==0){
                                    $error_message .= "此帳號尚未註冊<br>";
                                    echo"<span class='error'>".$error_message."</span>";
                                }else{
                                    echo"正確！";
                                    $checknum--;                 
                                }
                            }else{
                                $error_message .= "請先註冊！<br>";
                                echo"<span class='error'>".$error_message."</span>";
                            }                
                        }
                    }
                ?>
                </td>
                </tr>


                <tr>
                <td>密碼：</td>
                <td><input type="text" name="User_password" /></td>
                <td>
                <?php
                $error_message = ''; // 初始化為空字串
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/", $_POST["User_password"])) {
                            $error_message .= "密碼格式不正確<br>";
                            echo"<span class='error'>".$error_message."</span>";
                        }else{
                            $link = mysqli_connect('localhost' , 'root' , '' , 'movieplatform');
                            mysqli_set_charset($link , "utf8");
                            $account=$_POST["User_account"];
                            $password=$_POST['User_password'];
                            $SQL = "SELECT User_id,Level_id FROM user WHERE User_account = "."'$account'"." && User_password = "."'$password'";

                            if(@$result=mysqli_query($link , $SQL)){
                                //header ("Location:index.php");
                                if($result -> num_rows > 0){
                                    session_start();
                                    $_SESSION['login']='yes';
                                    $row = mysqli_fetch_assoc($result);
                                    $_SESSION['id']=$row['User_id'];
                                    $_SESSION['level']=$row['Level_id'];
                                    header('Location:index.php');
                                }else{
                                    $error_message .= "密碼錯誤！<br>";
                                    echo"<span class='error'>".$error_message."</span>";    
                                }
                            }else{
                                $error_message .= "未連接資料庫！<br>";
                                echo"<span class='error'>".$error_message."</span>";
                            }                
                        }
                    }
                    ?>
                </td>
                </tr>

                <tr>
                <th colspan="3">
                    
                    <button type="submit" name="submit" value="提交"> 提交 </button></a>
                    <button type="reset" name="reset" value="重置"> 重置 </button>
                    <a href="enroll.php"> &nbsp; 註冊會員</a>
                </th>
                </tr>
                </table>

            </div>
        </form>    
    </body>
</html>
