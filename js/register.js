
//检查注册信息
function Inputcheck(regform){
	if(regform.pass.value!=regform.pass0.value){
		alert("两次密码不一致！");
		regform.repass.focus();
		return false;
	}
}