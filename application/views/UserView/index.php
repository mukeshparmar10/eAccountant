<?php
	session_start();
	if(isset($_SESSION['user_id']))
	{		
		redirect(BASEURL . 'home');
	}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=CSS;?>style.css" />
<link rel="shortcut icon" href="<?=IMAGES;?>favicon.ico" type="image/x-icon"/>
<title>AccApp</title>
<script src="<?=JS;?>jquery-3.4.1.js"></script>
<script>
function signIn()
{
	
	var valid=true;
	if($("#user_email").val()=="")
	{
		$("#signin_msg").html("Enter email");
		$("#user_email").focus();
		valid = false;
		return false;
	}
	else
	{
		var user_email=$("#user_email").val();
	}

	if($("#user_password").val()=="")
	{
		$("#signin_msg").html("Enter password");
		$("#user_password").focus();
		valid = false;
		return false;
	}
	else
	{
		var user_password=$("#user_password").val();
	}

	if(valid==true)
	{
		$("#signin_msg").html('<img src="<?=IMAGES;?>loader.gif" />');
		$.post("<?=BASEURL;?>login",{user_email:user_email,user_password:user_password},function(data){
			if(data)
			{
				$("#signin_msg").html("");
				var response = JSON.parse(data);

				if(response.status=="1")
				{					
					window.location.href = "<?=BASEURL;?>home";					
				}

				if(response.status=="0")
				{
					$("#signin_msg").html(response.msg);
				}

				if(response.status!="0" && response.status!="1")
				{
					$("#signin_msg").html(data);
				}
				$("#user_email").val("");
				$("#user_password").val("");
			}
			else
			{
				$("#signin_msg").html("Can't load...");
			}
		});
	}
}

function submitForm(event)
{
	if(event.keyCode==13)
	{
		signIn();
	}
}
</script>
</head>
<body style="background:#ffffff">
<center><img src="<?=IMAGES;?>logo.png" style="width:100%;max-width:200px" /></center>
<div class="login" id="login">
<table id="step-1" width="98%" border="0px" cellspacing="0px" cellpadding="5px">	
	<tr>
		<td><span style="font-size:18px">Sign In</sapn></td>
	</tr>
	<tr>
		<td>Email:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="text" id="user_email" onKeyUp="submitForm(event)" /></td>
    </tr>
    <tr>
		<td>Password:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="password" id="user_password" onKeyUp="submitForm(event)" /></td>
    </tr>
    <tr>
    	<td align="center">
			<input class="btn" type="button" value="Sign In" onClick="signIn()" />
		</td>
	</tr>
	<tr>
		<td align="center">
			<a href="<?=BASEURL?>forget-password">Forget Password</a> | <a href="<?=BASEURL?>sign-up">Sign Up</a>
		</td>
    </tr>
    <tr>
    	<td align="center" id="signin_msg"></td>
    </tr>
</table>
<p align="center">
	&copy; <?=date('Y');?> All rights reserved
</p>
</div>
</body>
</html>