<?php
	session_start();
	if(@$_SESSION['login']!='yes'){
        echo "<h1 class='noanswer'>請先登入，三秒後移動至登入畫面</h1>";
        header('Refresh:3;url=login.php');
    }else if(@$_SESSION['level']==1){
        echo "<h1 class='noanswer'>權限不足，三秒後離開</h1>";
        header('Refresh:3;url=index.php');
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>新增電影庫存</title>
	    <link rel="stylesheet" href="report.css" type="text/css">
	    <link rel="stylesheet" href="silder.css" type="text/css">
	    <link rel="stylesheet" href="add.css" type="text/css">
	    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

	</head>

	<body>
		<?php   
	    	include("header.php");
	    ?>

	    <div class="add_head">
	    	<h2 class="line1">新增庫存</h2>
	    </div>

	    <hr>

	    <form action="add_inventory_check.php" enctype="multipart/form-data" method="post">
	    	
	    	<div class="add">
	    		
	    		<div class="line1">
	    			<h4 class="label1">選擇電影：</h4>
		    			<?php
							// 建立與資料庫的連接
							$link=mysqli_connect('localhost', 'root', '', 'movieplatform');

							// 檢查連接是否成功
							if (!$link) {
							    die("連接失敗: " . mysqli_connect_error());
							}

							// 執行查詢，獲取下拉式選單的數據
							$SQL = "SELECT DISTINCT Movie_name,Movie_id FROM movie WHERE Movie_remove IS NULL";
							$result = mysqli_query($link, $SQL);

							// 生成下拉式選單的 HTML
							echo '<select name="Movie_id">';
							echo '<option value="" selected>下拉選擇電影</option>';
							while ($row = mysqli_fetch_assoc($result)) {
							    
							    echo "<option value='" . $row['Movie_id'] . "'>" . $row['Movie_name'] . "</option>";
							}
							echo '</select>';

							// 釋放結果集和關閉資料庫連接
							mysqli_free_result($result);
							mysqli_close($link);
						?>
	    		</div>
	    		
				<!-- 上傳數量 -->
				<div class="line1">
					<h4 class="label1">上傳數量：</h4>				
					<input type="text" name="Upload_num" class="Input_frame1" placeholder="請輸入上傳數量(數字)">	
					<!-- 上傳數量要用另一網頁的後台計算 -->
				</div>

				<input type="submit" value="上傳">

			</div>
	    </form>
	</body>
</html>
