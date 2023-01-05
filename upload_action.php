<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>投稿</title>
</head>

<body>
	<?php
	var_dump($_FILES['pic']);//接受用户传入的图片内容
	
	//1、判断文件是否上传成功
		if($_FILES['pic']['error']>0){
			switch($_FILES['pic']['error']){
				case 1:
					die("上传文件超过了php.ini配置文件中的upload_max_filesize设置的值");
				case 2:
					die("上传文件超过了HTML表单中设置的MAX_FILS_SIZE设置的值");
				case 3:
					die("只有部分文件被上传");
				case 4:
					die("没有文件上传");
				case 6:
					die("找不到临时文件夹");
				case 7:
					die("文件写入失败");
										
			}
		}
	
	//2、判断上传文件的类型是否符合要求,定义文件类型并比较
	$type=array("jpeg","png","jpg","gif");
	if(in_array($_FILES['pic']['type'],$type)){
		die("上传文件类型不合法");
	}
	
	//3、判断上传文件的大小是否符合要求,定义文件大小并比较
	$size=10000000;
	if($_FILES['pic']['size']>$size){
		die("您上传的文件太大了，请重新上传！");
	}
	
	//4、创建上传成功后保存的目录，定义目录并判断文件是否存在,不存在则创建
	$path='C:\AppServ\www\onload_pic';
	if(file_exists($path)){
		mkdir($path);
	}
	
	//5、给上传上来的文件重新命名 uniqid():生成一个字符串形式的唯一的id
	$suffix=strrchr($_FILES['pic']['name'],'.');//获取后缀名
	do{
		$name=md5(time().mt_rand(1,1000).uniqid()).$suffix;
	}while(file_exists($path.'/'.$name));
	
	//6.移动文件 move_uploaded_fille:将上传的文件移动到新的位置
	if(move_uploaded_file($_FILES['pic']['tmp_name'],$path.'/'.$name)){
            $host="localhost";
            $user = "root";
            $password = "11111";
            $dbname = "test";
             $id = mysqli_connect($host,$user,$password,$dbname);
             mysqli_query($id,"set names utf-8");
             mysqli_select_db($id,$dbname);
             $uname = $_POST["uname"];
             $phone = $_POST["phone"];
             $email = $_POST["email"];
             $describ = $_POST["describ"];
			 $original = $_POST["original"];
             $sql = "insert into contribution(uname,phone,email,describ,original,pic) values('$uname','$phone','$email','$describ','$original','$name')";
             mysqli_query($id,$sql);
 
             if($result = mysqli_query($id,"select * from contribution;")){//查询数据库中users中所有内容，并将结果存在$result中
                 
                 if($row = mysqli_fetch_array($result)){//获取内容存在数组中
                    echo "<script language='javascript'>";
					echo "alert('投稿成功，我们会尽快回复~感谢您的投稿！即将返回主页！');";
					echo "window.location.href='main.html';";
					echo "</script>"; 
                }
			 }
        
	}else{
		echo('未知错误，文件上传失败！');
	}
	

	?>
</body>
</html>