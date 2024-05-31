<?php
   session_start();
   //權限管理
   if($_SESSION['login']!='yes'){
    header("Location:login.php");
  }else{
    if($_SESSION['level']!=3){
      header("Location:index.php");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>資料分析頁</title>
  <meta chartset ="utf8">
  <link rel="stylesheet" href="report.css" type="text/css">
  <link rel="stylesheet" href="silder.css" type="text/css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

  <!-- 圓餅圖 -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['收藏次數', '比例']
          <?php
          $link=@mysqli_connect('localhost','root','','movieplatform');
          $SQL1="SELECT t.Type_name,count(Rent_id) as 'num' FROM rentrecord rt JOIN dvd ON dvd.DVD_id=rt.DVD_id JOIN movie m ON m.Movie_id=dvd.Movie_id JOIN movietype mt ON mt.Movie_id=m.Movie_id JOIN type t ON t.Type_id=mt.Type_id  GROUP BY mt.Type_id";
          @$result=mysqli_query($link,$SQL1);
          while($row=mysqli_fetch_assoc($result)){
              echo ",['".$row['Type_name']."',".$row['num']."]";
          }
          ?>
        ]);

        var options = {
          backgroundColor:'#242323',
          width:600,
          legend: {
              textStyle:{
                color: 'white',
                fontSize:15,
              },
              position: 'bottom'
            },
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
    <!-- BarChart -->
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);
      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ["", '次數']
          <?php
          $SQL2="SELECT Movie_name, count(collection.Movie_id) as 'num' FROM collection JOIN movie ON collection.Movie_id=movie.Movie_id GROUP BY collection.Movie_id ORDER BY count(collection.Movie_id) DESC LIMIT 5";
            @$result=mysqli_query($link,$SQL2);
            while($row=mysqli_fetch_assoc($result)){
                echo ",['".$row['Movie_name']."',".$row['num']."]";
            }
          ?>
        ]);

        var options = {
          backgroundColor:'#242323',
          width:600,
          legend: {
            
          },
          chartArea: {
            backgroundColor: '#242323'
          },
          hAxis: {
            textStyle: {
              color: 'white', // 修改 x 軸文字顏色為白
              fontSize: 10 // 修改 x 軸文字大小為 10px
            },
          },
          vAxis: {
            title: '收藏次數',
            textStyle: {
              color: 'white', 
              fontSize: 14 // 修改 y 軸文字大小為 14px
            },
            gridlines: {
            count: 5 // 設定 y 軸的間距為整數，此處設定為 50
            },
          },
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div_collection'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
    </script>
    <!-- 折線圖1-月份 -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['月份', '租借數']
          <?php
          // 建立包含 1~12 月的陣列
          $months = array(
            1 => "一月",
            2 => "二月",
            3 => "三月",
            4 => "四月",
            5 => "五月",
            6 => "六月",
            7 => "七月",
            8 => "八月",
            9 => "九月",
            10 => "十月",
            11 => "十一月",
            12 => "十二月"
          );
          // 初始化月份計數陣列
          $rentalsByMonth = array_fill(1, 12, 0);
          $SQL3="SELECT MONTH(Rent_time) AS Month, COUNT(Rent_id) AS 'num' FROM rentrecord GROUP BY MONTH(Rent_time) ORDER BY Month";
          @$result=mysqli_query($link,$SQL3);
          //填入有資料的月份
          while($row=mysqli_fetch_assoc($result)){
              $rentalsByMonth[$row['Month']]=$row['num'];
          }
          foreach($rentalsByMonth as $month=>$value){
              echo ",['".$months[$month]."',".$value."]";
          }
          ?>
        ]);

        var options = {
          backgroundColor:'#242323',
          lineWidth: 4,
          width:600,
          legend: {
              textStyle:{
                color: 'white',
                fontSize:15,
              },
          },
          chartArea: {
            backgroundColor: '#242323' 
          },
          legend: { position: 'bottom' },
          hAxis: {
            textStyle: {
              color: 'white', // 修改 x 軸文字顏色為白
              fontSize: 14 // 修改 x 軸文字大小為 14px
            },
          },
          vAxis: {
            title: '收藏次數',
            textStyle: {
              color: 'white', 
              fontSize: 14 // 修改 y 軸文字大小為 14px
            },
            gridlines: {
              count: 5
            }
          },
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart_month'));

        chart.draw(data, options);
      }
    </script>
    <!-- 折線圖2-星期 -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['星期', '租借數']
          <?php
          // 建立包含星期的陣列
          $days = array(
            "Sunday" => 0,
            "Monday" => 0,
            "Tuesday" => 0,
            "Wednesday" => 0,
            "Thursday" => 0,
            "Friday" => 0,
            "Saturday" => 0
          );
          $now =date('Y-m-d H:i:s',time());
          $SQL4="SELECT DAYNAME(Rent_time) as 'day',count(Rent_id) as 'num' FROM rentrecord GROUP BY DAYNAME(Rent_time) HAVING EXISTS(SELECT Rent_id FROM rentrecord WHERE DATEDIFF(now(),Rent_time)<90)";
          @$result=mysqli_query($link,$SQL4);
          //填入有資料的月份
          while($row=mysqli_fetch_assoc($result)){
              $days[$row['day']]=$row['num'];
          }
          foreach($days as $day=>$value){
              echo ",['".$day."',".$value."]";
          }
          ?>
        ]);

        var options = {
          backgroundColor:'#242323',
          lineWidth: 4,
          width:600,
          legend: {
              textStyle:{
                color: 'white',
                fontSize:15,
              },
          },
          chartArea: {
            backgroundColor: '#242323' 
          },
          legend: { position: 'bottom' },
          hAxis: {
            textStyle: {
              color: 'white', // 修改 x 軸文字顏色為白
              fontSize: 14 // 修改 x 軸文字大小為 14px
            },
          },
          vAxis: {
            title: '收藏次數',
            textStyle: {
              color: 'white', 
              fontSize: 14 // 修改 y 軸文字大小為 14px
            },
            gridlines: {
              count: 5
            }
          },
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart_week'));

        chart.draw(data, options);
      }
    </script> 
</head>
<body>
    <?php
    //頁首    
    include("header.php");
    //statistic
    // user
    $link = mysqli_connect('localhost','root','','movieplatform');
    $sql1="SELECT count(User_id) as 'total' FROM user";
    $result = mysqli_query($link, $sql1);
    $row= mysqli_fetch_assoc($result);
    $totalUser= $row['total'];
    //  movie
    $sql2="SELECT count(Movie_id) as 'total' FROM movie WHERE Movie_remove IS NULL";
    $result = mysqli_query($link, $sql2);
    $row= mysqli_fetch_assoc($result);
    $totalMovie=$row['total'];
    //  rent
    $sql3="SELECT count(Rent_id) as 'total' FROM rentrecord";
    $result = mysqli_query($link, $sql3);
    $row= mysqli_fetch_assoc($result);
    $totalRent=$row['total'];
    //  dvd
    $sql4="SELECT count(DVD_id) as 'total' FROM dvd WHERE DVD_remove IS NULL";
    $result = mysqli_query($link, $sql4);
    $row= mysqli_fetch_assoc($result);
    $totalDVD=$row['total'];
     $nameArray=array("總使用者","架上電影數","總租借數","本館DVD總數量");
     $valueArray=array("總使用者"=>$totalUser,"架上電影數"=>$totalMovie,"總租借數"=>$totalRent,"本館DVD總數量"=>$totalDVD);
     echo "<h3 class='search-hint'>後台分析</h3>";
     echo "<div class='static'>";
     foreach($valueArray as $name=>$value){
      echo "<div class ='stItem'>";
      echo "<div class= 'content'>";
      echo" <div class='text'>".$name."</div>";
      echo "<div class='number'>$value</div>";
      echo "</div></div>";
     }
    echo "</div>";

    // chart
    ?>
    

    <div class='chartArea'>
      <div class='chartItem'>
        <h1 class="topic">收藏次數</h1>
        <p>以下為被收藏總次數排名前五的電影</p>
        <div class='chart' id="top_x_div_collection"></div>
      </div>
      <div class='chartItem'>
        <h1 class="topic">各類型電影被租借次數</h1>
        <p>以下為不同類型電影被租借總次數&比例<br/>註:一部電影可能有多個分類</p>
        <div class='chart' id="piechart"></div>
      </div>
      <div class='chartItem'>
        <h1 class="topic">各月份租借量折線圖</h1>
        <p>以下為過去一年各月份電影租借量</p>
        <div class='chart' id="curve_chart_month"></div>
      </div>
      <div class='chartItem'>
        <h1 class="topic">各星期之租借趨勢圖</h1>
        <p>以下為近90天各星期電影租借量</p>
        <div class='chart' id="curve_chart_week"></div>
      </div>
    </div>
</body>
</html>