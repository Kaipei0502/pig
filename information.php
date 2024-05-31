<?php
session_start();
?>

<?php

$_information = "";
$_rentrecord = "";
$_backstage = "";
$_logout = "";

?>
<?php
if (isset($_SESSION['login']) == 'yes') {
    if ($_SESSION['level'] == 3) {

        $_information = "老闆資料";
        $_rentrecord = "顧客租借紀錄";
        $_backstage = "後端修改系統";
        $_logout = "登出";
    } else if ($_SESSION['level'] == 2) {

        $_information = "員工資料";
        $_rentrecord = "租借/歸還";
        $_backstage = "後端修改系統";
        $_logout = "登出";
    } else if ($_SESSION['level'] == 1) {

        $_information = "會員資料";
        $_rentrecord = "租借紀錄";
        $_logout = "登出";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <title>個人資訊頁</title>
    <link rel="stylesheet" href="report.css" type="text/css">
    <link rel="stylesheet" href="silder.css" type="text/css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <?php   
    include("header.php");
    
            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";
            
            
            echo "<div class='informationcentered'>";  // 使用 CSS 樣式設定區塊置中
            echo "<img src='peppapig.png' width='100' height='200' alt=''>";
            echo "</div>";

            echo "</br>";
            echo "</br>";
    ?>
    
    <!-- 第一個tab開始 -->
    <?php
    if($_SESSION['level'] == 1){
        echo "<div class='toyotas clearfix'>";
        echo "<div class='toyota'>";
            echo "<input type='radio' name='toyotas' id='tab1' hidden checked>";
            echo "<label for='tab1' class='toyota-hd'>";
                echo "<h1>$_information</h1>";
                    
            echo "</label>";
            echo "<div class='toyota-bd'>";
            $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
            $user_id=$_SESSION['id'];
            $SQL = "SELECT * FROM user WHERE User_id = $user_id";
    
            mysqli_set_charset($link, "utf8");
            if (@$result = mysqli_query($link, $SQL)) {
                while ($row = mysqli_fetch_assoc($result)) {
                echo "<h2>姓名: ". $row['User_name'];
                echo "</br>";
                echo "<h2>帳號: " . $row['User_account'];
                echo "</br>";
                echo "<h2>密碼: " . $row['User_password'];
                echo "</br>";
                echo "<h2>手機: " . $row['User_phone'];
                echo "</br>";
                }
                mysqli_free_result($result);
                mysqli_close($link);
            }
            echo "</div>";
            echo "</div>";
        }

    if($_SESSION['level'] == 2){
    echo "<div class='toyotas clearfix'>";
      echo "<div class='toyota'>";
          echo "<input type='radio' name='toyotas' id='tab1' hidden checked>";
          echo "<label for='tab1' class='toyota-hd'>";
                echo "<h1>$_information</h1>";
                
          echo "</label>";
          echo "<div class='toyota-bd'>";
            $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
            $user_id=$_SESSION['id'];
            $SQL = "SELECT * FROM user WHERE User_id = $user_id";

            mysqli_set_charset($link, "utf8");
            if (@$result = mysqli_query($link, $SQL)) {
                while ($row = mysqli_fetch_assoc($result)) {
                echo "<h2>姓名: ". $row['User_name'];
                echo "</br>";
                echo "<h2>帳號: " . $row['User_account'];
                echo "</br>";
                echo "<h2>密碼: " . $row['User_password'];
                echo "</br>";
                echo "<h2>手機: " . $row['User_phone'];
                echo "</h2></br>";
                }
                mysqli_free_result($result);
                mysqli_close($link);
            }
            echo "</div>";
            echo "</div>";
        }
        
        if($_SESSION['level'] == 3){
        echo "<div class='toyotas clearfix'>";
        echo "<div class='toyota'>";
            echo "<input type='radio' name='toyotas' id='tab1' hidden checked>";
            echo "<label for='tab1' class='toyota-hd'>";
                echo "<h1>$_information</h1>";
                        
                echo "</label>";
                echo "<div class='toyota-bd'>";
                $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
                $user_id=$_SESSION['id'];
                $SQL = "SELECT * FROM user WHERE User_id = $user_id";
        
                mysqli_set_charset($link, "utf8");
                if (@$result = mysqli_query($link, $SQL)) {
                    while ($row = mysqli_fetch_assoc($result)) {
                    echo "<h2>姓名: ". $row['User_name'];
                    echo "</br>";
                    echo "<h2>帳號: " . $row['User_account'];
                    echo "</br>";
                    echo "<h2>密碼: " . $row['User_password'];
                    echo "</br>";
                    echo "<h2>手機: " . $row['User_phone'];
                    echo "</br>";
                    }
                    mysqli_free_result($result);
                     mysqli_close($link);
                }
                echo "</div>";
                echo "</div>";
        }
    ?>
<!-- 第一個tab結束 -->
  <div class="toyota">
      <input type="radio" name="toyotas" id="tab2" hidden>
      <label for="tab2" class="toyota-hd">
        <h1><?php echo $_rentrecord; ?></h1>
        
      </label>
    <div class="toyota-bd">
        <?php
            if ($_SESSION['level'] == 1) {
                
                $link=mysqli_connect('localhost', 'root', '', 'movieplatform');
                $user_id=$_SESSION['id'];
                $SQL = "SELECT m.Movie_name,rt.DVD_id,date(Rent_time) as 'Rent_time', date(Rent_limittime) as 'Rent_limittime', date(Rent_returntime) as 'Rent_returntime', Rent_isreturn FROM rentrecord rt JOIN dvd ON dvd.DVD_id=rt.DVD_id JOIN movie m ON m.Movie_id=dvd.Movie_id WHERE rt.User_id =$user_id";
                
                mysqli_set_charset($link, "utf8");
                if (@$result = mysqli_query($link, $SQL)) {
                    echo "<table class='TB_COLLAPSE'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>電影名稱</th><th>DVD編號</th><th>租借時間</th><th>租借到期日</th><th>歸還時間</th><th>租借狀態</th>";
                    echo "</tr>";
                    echo "</thead>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        
                        echo "<tr>";
                        echo "<td>" . $row['Movie_name'] . "</td><td>" . $row['DVD_id'] . "</td><td>" . $row['Rent_time'] . "</td><td>" . $row['Rent_limittime'] . "</td><td>" . $row['Rent_returntime'] . "</td>";
                        if($row['Rent_isreturn']=='1'){
                            echo "<td>已歸還</td>";
                        }else{
                            echo "<td style='color:red'>尚未歸還</td>";
                        }
                        echo "</tr>";
                        
                    }
                    echo "</table>";
                mysqli_free_result($result);
                mysqli_close($link);
                }
                
            }
            
            if($_SESSION['level'] == 2){
                echo '<a href=rentreturn.php><h3>租借/歸還</h3></a></span>';
                echo "</br>";
            }
            if($_SESSION['level'] == 3){
                echo '<a href=record.php><h3>全體顧客租借資料</h3></a></span>';
                echo "</br>";
            }
        ?>
        
    </div>
  </div>
  <!-- 第二個tab結束 -->
  <?php
  if($_SESSION['level'] == 3){
    echo "<div class='toyota'>";
    echo "<input type='radio' name='toyotas' id='tab3' hidden>";
    echo "<label for='tab3' class='toyota-hd'>";
          echo "<h1>";
          echo $_backstage;
          echo "</h1>";
    echo "</label>";
    echo "<div class='toyota-bd'>";
    echo "<a href=backstage.php><h3>資料分析</h3></a>";
    echo "<a href=remove.php><h3>下架DVD/刪除電影</h3></a>";
    echo "<a href=add_movie.php><h3>上傳新電影</h3></a>";
    echo "<a href=add_movie_inventory.php><h3>上傳新電影DVD</h3></a>";
  }
  if($_SESSION['level'] == 2){
    echo "<div class='toyota'>";
    echo "<input type='radio' name='toyotas' id='tab3' hidden>";
    echo "<label for='tab3' class='toyota-hd'>";
          echo "<h1>";
          echo $_backstage;
          echo "</h1>";
    echo "</label>";
    echo "<div class='toyota-bd'>";
    echo "<a href=remove.php><h3>下架DVD/刪除電影</h3></a>";  
    echo "<a href=add_movie.php><h3>上傳新電影</h3></a>";       
    echo "<a href=add_movie_inventory.php><h3>上傳新電影DVD</h3></a>"; 
  }
  if($_SESSION['level'] == 1){
    echo "<div class='toyota'>";
    echo "<input type='radio' name='toyotas' id='tab4' hidden>";
    echo "<label for='tab4' class='toyota-hd'>";
        echo "<h1>";
        echo $_logout;
        echo "</h1>";
    echo "</label>";
    echo "<div class='toyota-bd'>";
    echo "<div class='informationcentered'>";
    echo "<a href='logout.php'><h3>~ 請點選下方按鈕登出 ~</h3>";
    echo "</br>";
    echo "<img src='elephant.png' height='300' width='300'>";
    echo "</br>";
    echo "</div>";
  }

  echo "</div></div>";
  ?>
  <!-- 第三個tab結束 -->
  <?php
    if($_SESSION['level'] == 2 || $_SESSION['level'] == 3){
        echo "<div class='toyota'>";
        echo "<input type='radio' name='toyotas' id='tab4' hidden>";
        echo "<label for='tab4' class='toyota-hd'>";
            echo "<h1>";
            echo $_logout;
            echo "</h1>";
        echo "</label>";
        echo "<div class='toyota-bd'>";
        echo "<div class='informationcentered'>";
        echo "<a href='logout.php'><h3> &nbsp &nbsp ~ 請點選下方按鈕登出 ~</h3>";
        echo "</br>";
        echo "<img src='elephant.png' height='300' width='300'>";
        echo "</br>";
        echo "</div></div></div>";

    }
    echo "</div>";
  ?>

</body>

</html>
