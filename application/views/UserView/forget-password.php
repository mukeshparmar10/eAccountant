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
function recover_password()
{
	
	var valid=true;
	if($("#email").val()=="")
	{
		$("#signin_msg").html("Enter email");
		$("#email").focus();
		valid = false;
		return false;
	}
	else
	{
		var email=$("#email").val();
	}

	if(valid==true)
	{
		$("#signin_msg").html('<img src="<?=IMAGES;?>loader.gif" />');
		$.post("<?=BASEURL;?>forget-password-process",{email:email},function(data){
			if(data)
			{
				$("#signin_msg").html(data);				
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
		<td><span style="font-size:18px">Forget Password</sapn></td>
	</tr>
	<tr>
		<td>Enter your register Email:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="text" id="email" onKeyUp="submitForm(event)" /></td>
    </tr>    
    <tr>
    	<td align="center">
			<input class="btn" type="button" value="Submit" onClick="recover_password()" />
		</td>
	</tr>
	<tr>
		<td align="center">
			<a href="<?=BASEURL?>">Sign In</a> | <a href="<?=BASEURL?>sign-up">Sign Up</a>
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