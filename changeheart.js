//若有人按愛心，javascript改變愛心顏色並回傳PHP 
let allhearts = document.querySelectorAll(".fa-heart");
allhearts.forEach((heart) => {
    heart.addEventListener('click',function(){
        var login = document.querySelector('.logined');//抓登入鍵是否是登入狀態
        if(login!=undefined){//登入狀態，從header的class找
            var movieid = event.target.id; // 傳入的電影ID
            var isselect=(heart.classList.contains("collection-heart-icon"))?true:false;
            $.ajax({
                url: "index.php", // 呼叫的PHP檔案名稱
                type: "POST", // 呼叫的HTTP方法
                data: {'movieid': movieid,'TF':isselect}, // movieid電影編號，TF是否有收藏(true該電影目前被收藏，反之沒有)
            });                
            heart.classList.toggle("collection-heart-icon");
            heart.classList.toggle("heart-icon"); 
        }else{
            alert('請先登入');
            location.href='login.php';
        }   
    });
}); 