<?php
    header ( "Content-type:text/html;charset=utf-8" );
    $conn = mysqli_connect('localhost','root','11111','test') or die('数据库连接失败');
    $conn->set_charset('utf8');

    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $connect = $_POST['connect'];
 	
	//$up=mysqli_num_rows(mysqli_query($con,$s));
	$sql="SELECT * FROM users where user='{$user}'"; 
    $result=mysqli_query($conn,$sql);
    $row = mysqli_num_rows($result);//若表中存在输入的用户名和密码，row=1；若表中用户名不存在或密码错误，则row=0
    if($row != 0){
		echo "<script language='javascript'>";
		echo "alert('用户已存在！请换一个用户名进行注册！');";
		echo "window.location.href='register.html';";
		echo "</script>";
	}
	else{
    $sql = "INSERT INTO users(user,pass,connect) VALUES ('{$user}' ,'{$pass}','{$connect}')";
    mysqli_query($conn,$sql) or die(mysqli_error($conn));
		echo "<script language='javascript'>";
		echo "alert('注册成功！即将跳转进入登录页面！');";
		echo "window.location.href='login.html';";
		echo "</script>"; 
	}
?>
