<?php
	session_start();
	if(@$_SESSION['login']!='yes'){
	    echo "<h1 class='noanswer'>請先登入，三秒後移動至登入畫面</h1>";
	    header('Refresh:3;url=login.php');
	}else if(@$_SESSION['level']==1){
	    echo "<h1 class='noanswer'>權限不足，三秒後離開</h1>";
	    header('Refresh:3;url=index.php');
	}

	// 讀取輸入資料
	$Movie_id = $_POST["Movie_id"];
	$Upload_num = $_POST["Upload_num"];

	echo "Movie_id: " . $Movie_id . "<br>";
	echo "Upload_num: " . $Upload_num . "<br>";

	// 寫入資料庫
	$link = mysqli_connect('localhost', 'root', '', 'movieplatform');

	$SQLMovie = "SELECT `Movie_id` FROM `movie` WHERE `Movie_id` = '$Movie_id'";

	if ($result = mysqli_query($link, $SQLMovie)) {
	    $row = mysqli_fetch_assoc($result);
	    $Movie_id = $row['Movie_id'];
	    echo "Movie_id: " . $Movie_id . "<br>";
	}
	//找出目前資料庫中有幾部該電影DVD
	$SQLDVD = "SELECT count(DVD_id) as count FROM `dvd` GROUP BY Movie_id HAVING `Movie_id` = '$Movie_id'";
	$sum_result=mysqli_query($link, $SQLDVD);
	$row = mysqli_fetch_assoc($sum_result);
	$num=$row['count'];
	echo "NUM:$num<br/>";
	// for 迴圈寫入上傳幾部電影
	for ($i = 1; $i <= $Upload_num; $i++) {
	    echo "i = " . $i . "<br>";
	    $DVD_No = sprintf("%03d", $num+$i);
	    $DVD_id = "im" . sprintf("%03d", $Movie_id) . $DVD_No;
	    echo "DVD_id: " . $DVD_id . "<br>";
	    echo "Movie: " . $Movie_id . "<br>";

	    $SQL = "INSERT INTO `dvd` (`DVD_id`, `DVD_inhouse`, `Movie_id`) VALUES ('$DVD_id', 1, '$Movie_id')";
	    echo "SQL: " . $SQL . "<br>";

	    // 檢查執行结果
	    if (mysqli_query($link, $SQL)) {
	        echo "第 " . $i . " 筆資料, 成功插入紀錄<br>";
	    } else {
	        echo "插入失敗：<br>";
	    }
	}
	echo "上傳成功, 即將跳轉畫面...";	
	header("Location:add_sucess.php");
	echo "<a href='/期末/add_sucess.php'>link</a><br>";

	mysqli_close($link);
?>
