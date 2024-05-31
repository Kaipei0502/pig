<?php
	session_start();
	if(@$_SESSION['login']!='yes'){
        echo "<h1 class='noanswer'>請先登入，三秒後移動至登入畫面</h1>";
        header('Refresh:3;url=login.php');
    }else if(@$_SESSION['level']==1){
        echo "<h1 class='noanswer'>權限不足，三秒後離開</h1>";
        header('Refresh:3;url=index.php');
    }

	// 圖片
	$target_dir = "./reportImg/"; // 檔案儲存目錄
	$target_file = $target_dir.basename($_FILES["file"]["name"]); // 儲存的檔案路徑
	$uploadOk = 1; // 上傳是否成功的標誌, 1=成功, 0=失敗

	// 檢查檔案是否已存在
	if (file_exists($target_file)) {
	    echo "檔案已存在。<br>";
	    $uploadOk = 0;
	}

	// 檢查檔案大小是否符合要求
	if ($_FILES["file"]["size"] > 10000000) {
	    echo "檔案太大，請選擇小於10MB的圖片。<br>";
	    $uploadOk = 0;
	}

	// 允許特定的檔案格式
	$allowed_types = array("jpg", "jpeg", "png", "gif");
	$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if(!in_array($file_type, $allowed_types)){
	    echo "只允許上傳JPG、JPEG、PNG、GIF格式的圖片。<br>";
	    $uploadOk = 0;
	}

	// 檢查是否有錯誤
	if ($uploadOk == 0) {
	    echo "很抱歉，您的檔案未能上傳。<br><br>";

	// 上傳圖片沒有錯誤，儲存檔案
	} else {
	    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
	        echo "圖片: ".htmlspecialchars( basename( $_FILES["file"]["name"])). "上傳成功!";
	        // 執行儲存到資料庫的程式碼
	    } else {
	        echo "很抱歉，上傳檔案時發生錯誤。<br><br>";
	    }
	}

	// 讀取輸入資料
	$File_name="reportImg/".$_FILES["file"]["name"];
	$Movie_name=$_POST["Movie_name"];
	$Movie_long=$_POST["Movie_long"];
	$Movie_director=$_POST["Movie_director"];
	$Movie_actor=$_POST["Movie_actor"];
	$Movie_description=$_POST["Movie_description"];
	$Upload_num=$_POST["Upload_num"];
	$Movie_level=$_POST["Movie_level"];
	$Movie_price=$_POST["Movie_price"];

	echo "<br>";

	echo "Movie_name: " . $Movie_name . "<br>";
	echo "Movie_long: " . $Movie_long . "<br>";
	echo "Movie_level: " . $Movie_level . "<br>";
	echo "Movie_director: " . $Movie_director . "<br>";
	echo "Movie_actor: " . $Movie_actor . "<br>";
	echo "Movie_description: " . $Movie_description . "<br>";
	echo "File_name: " . $File_name . "<br>";
	echo "Movie_price: " . $Movie_price . "<br>";
	echo "Upload_num:". $Upload_num."<br>";

	// 連結資料庫
	$link=mysqli_connect('localhost', 'root', '', 'movieplatform');

	// 測試是否連線成功
	if(!$link) {
		die("連線失敗".mysqli_connect_error()."<br>");
	}else {
		echo "連線成功<br><br>";
	}

	// 上傳新電影, movie table, SQL1
	$SQL1 = "INSERT INTO `movie` (`Movie_name`, `Movie_long`, `Movie_level`, `Movie_director`, `Movie_actor`, `Movie_description`, `Movie_photo`, `Movie_price`) VALUES ('$Movie_name', '$Movie_long', '$Movie_level', '$Movie_director', '$Movie_actor', '$Movie_description', '$File_name', '$Movie_price')";

	echo "SQL1:  ".$SQL1."<br><br>";

	$con1= mysqli_query($link, $SQL1);

	if($con1){
	    echo "SQL1上傳成功";
	} else {
	    echo "SQL1上傳失敗，請重新輸入...";
	}

	// 找已上傳新電影的movie_id
	$SQLMovie="SELECT Movie_id FROM movie WHERE Movie_name ="."'$Movie_name'";
	if ($result= mysqli_query($link,$SQLMovie)) {
	    $row = mysqli_fetch_assoc($result);
	    $Movie_id = $row['Movie_id'];
		echo $Movie_id."<br>";
	}
	
	// 將Movie_id 改為三位數
	$Movie_id_formatted = sprintf("%03d", $Movie_id);

	// 上傳新電影之數量, 並編寫DVD_id(格式為im + Movie_id 3位數 + DVD_id 3位數), dvd table, SQL2
	
	echo "SQL2開始<br>";
	for ($i = 0; $i < $Upload_num; $i++) {
		echo "i=" . $i . "<br>";
	    $DVD_No = sprintf("%03d", $i);
		$DVD_id = "im" . $Movie_id_formatted . $DVD_No;
		echo "DVD_id: ".$DVD_id."<br>";
		echo "Movie:".$Movie_id."<br>";
	    
	    $SQL2 = "INSERT INTO `dvd` (`DVD_id`, `DVD_inhouse`, `Movie_id`) VALUES ('$DVD_id', 1, '$Movie_id')";
	    echo "SQL2: " . $SQL2 . "<br>";

	    // 檢查執行结果
	    if (mysqli_query($link, $SQL2)) {
	        echo "第" . $i . "筆資料, 成功插入紀錄<br>";
	    } else {
	        echo "插入失敗：<br>";
	    }
	}
	echo "SQL2结束<br><br>";

	// 將上傳電影的movietype 新增至 movietype table中, SQL3

	// Type_id為複選

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["Type_id"])) {
		    $selected_Type_id = $_POST["Type_id"];
		    $num_Type_id = count($selected_Type_id);

		    if ($num_Type_id > 0) {
		    	echo "Selected Type_id:<br>";
		    	foreach ($selected_Type_id as $Type_id) {
		        	echo $Type_id . "<br>";
		        	// 將上傳電影的movietype 新增至 movietype table中
					$SQL3 = "INSERT INTO `movietype` (`Type_id`, `Movie_id`) VALUES ('$Type_id', '$Movie_id')";
					echo "SQL3:  ".$SQL3."<br><br>";

					if (mysqli_query($link, $SQL3)) {
				        echo "成功上傳SQL3<br>";
				    } else {
				        echo "上傳SQL3失败：" . mysqli_error($link) . "<br>";
				    }
		    	}
		    } else {
		    	echo "No Type_id selected.";
		    }
		} else {
			echo "No Type_id selected.";
		}
	}

	echo "已上傳完畢, 網頁即將跳轉...<br>";
	header("Location:add_sucess.php");
	echo "<a href='/期末/add_sucess.php'>link</a><br>";

?>
