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
<title>AccApp</title>
<script src="<?=JS;?>jquery-3.4.1.js"></script>
<script>
function signUp()
{
	
	var valid=true;
	if($("#email").val()=="")
	{
		$("#signup_msg").html("Enter email");
		$("#email").focus();
		valid = false;
		return false;
	}
	else
	{
		var email=$("#email").val();
	}	
	
	if($("#name").val()=="")
	{
		$("#signup_msg").html("Enter name");
		$("#name").focus();
		valid = false;
		return false;
	}
	else
	{
		var name=$("#name").val();
	}

	if($("#address").val()=="")
	{
		$("#signup_msg").html("Enter address");
		$("#address").focus();
		valid = false;
		return false;
	}
	else
	{
		var address=$("#address").val();
	}
	
	if($("#phone").val()=="")
	{
		$("#signup_msg").html("Enter contact number");
		$("#phone").focus();
		valid = false;
		return false;
	}
	else
	{
		var phone=$("#phone").val();
	}
	
	var state = $("#state").val();
	var country = $("#country").val();

	if(valid==true)
	{		
		$("#signup_msg").html('<img src="<?=IMAGES;?>loader.gif" />');
		$.post("<?=BASEURL;?>sign-up-process",{email:email,name:name,address:address,state:state,country:country,phone:phone},function(data){
			if(data)
			{
				$("#signup_msg").html(data);
				$("#email").val('');
				$("#name").val('');
				$("#address").val('');
				$("#phone").val('');
			}
			else
			{
				$("#signup_msg").html("Can't sign up...");
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
		<td><span style="font-size:18px">Sign Up</sapn></td>
	</tr>
	<tr>
		<td>Email: <small>[Password will be send to this emial]</small></td>
	</tr>
	<tr>
    	<td><input class="txt" type="text" id="email" maxlength="50" onKeyUp="submitForm(event)" /></td>
    </tr>
    
	<!--
	<tr>
		<td>Password:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="password" id="password" maxlength="20" onKeyUp="submitForm(event)" /></td>
    </tr>
	<tr>
		<td>Confirm Password:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="password" id="confirm-password" maxlength="20" onKeyUp="submitForm(event)" /></td>
    </tr>
	-->
	
	<tr>
		<td>Your Name:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="text" id="name" maxlength="50" onKeyUp="submitForm(event)" /></td>
    </tr>
	
	<tr>
		<td>Address:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="text" id="address" maxlength="200" onKeyUp="submitForm(event)" /></td>
    </tr>
	
	<tr>
		<td>State:</td>
	</tr>
	<tr>
    	<td>
			<select class="txt" id="state">
				<?php
					$state = $this->User_Model->exe_query("select * from state_master");
					
					if($state->num_rows()>0)
					{
						foreach($state->result() as $row)
						{
							echo '<option value="'. $row->ID .'">'. $row->State .'</option>';
						}
					}					
				?>
			</select>			
		</td>
    </tr>
	
	<tr>
		<td>Country:</td>
	</tr>
	<tr>
    	<td>
			<select class="txt" id="country">
				<?php
					$state = $this->User_Model->exe_query("select * from country_master");
					
					if($state->num_rows()>0)
					{
						foreach($state->result() as $row)
						{
							echo '<option value="'. $row->ID .'">'. $row->Country .'</option>';
						}
					}					
				?>
			</select>			
		</td>
    </tr>
	
	<tr>
		<td>Contact Number:</td>
	</tr>
	<tr>
    	<td><input class="txt" type="text" id="phone" maxlength="30" onKeyUp="submitForm(event)" /></td>
    </tr>
	
    <tr>
    	<td align="center">			
			<input class="btn" type="button" value="Sign Up" onClick="signUp()" />
		</td>
	</tr>
	<tr>
		<td align="center">
			<a href="<?=BASEURL?>">Sing In</a>
		</td>
    </tr>
    <tr>
    	<td align="center" id="signup_msg"></td>
    </tr>
</table>
<p align="center">
	&copy; <?=date('Y');?> All rights reserved
</p>
</div>
</body>
</html>