<script>
function change_password()
{
	var valid=true;	

	if($("#old-password").val()=="")
	{
		$("#msg").html("Enter old password");
		$("#old-password").focus();
		valid = false;
		return false;
	}
	else
	{
		var old_password = $("#old-password").val();
	}
	
	if($("#new-password").val().length<6)
	{
		$("#msg").html("Password must be minimum 6 character long!");
		$("#new-password").focus();
		valid = false;
		return false;
	}
	else
	{
		if($("#new-password").val()!=$("#confirm-new-password").val())
		{
			$("#msg").html("Confirm password does not match!");
			$("#confirm-new-password").focus();
			valid = false;
			return false;
		}
		else
		{
			var new_password = $("#new-password").val();
		}
	}

	if(valid==true)
	{
		$("#msg").html('<img src="<?=IMAGES;?>loader.gif" />');
		$.post("<?=BASEURL;?>change-password",{old_password:old_password,new_password:old_password},function(data){
			if(data)
			{
				$("#msg").html(data);
				$("#old-password").val('');
				$("#new-password").val('');
				$("#confirm-new-password").val('');
			}
			else
			{
				$("#msg").html("Can't change password!");
			}
		});
	}
}
</script>
<div style="width:980px;margin:auto;">
	<h3 align="center">Welcome <?=$fullname;?></h3>
	<table width="100%" border="0px" cellpadding="5px">
		<tr>
			<td width="15%">Company:</td><td width="85%"><input class="txt" id="fullname" value="<?=$fullname;?>" maxlength="50" /></td>
		</tr>
		
		<tr>
			<td>Address:</td><td><input class="txt" id="address" value="<?=$address;?>" maxlength="200" /></td>
		</tr>
		
		<tr>
			<td>State:</td>
			<td>
				<select class="txt" id="state">
					<?php
						$state = $this->User_Model->exe_query("select * from state_master");
						if($state->num_rows() > 0)
						{
							foreach($state->result() as $row)
							{
								echo '<option value="'. $row->ID .'">'. $row->State .'</option>';
							}
						}
					?>
				</select>
				<script>
					$("#state").val(<?=$state;?>);
				</script>
			</td>
		</tr>
		
		<tr>
			<td>Country:</td>
			<td>
				<select class="txt" id="country">
					<?php
						$state = $this->User_Model->exe_query("select * from state_master");
						if($state->num_rows() > 0)
						{
							foreach($state->result() as $row)
							{
								echo '<option value="'. $row->ID .'">'. $row->State .'</option>';
							}
						}
					?>
				</select>
				<script>
					$("#country").val(<?=$country;?>);
				</script>
			</td>
		</tr>
		
		<tr>
			<td>Phone:</td><td><input class="txt" id="phone" value="<?=$phone;?>" maxlength="30" /></td>
		</tr>
		
		<tr>
			<td>Email:</td><td><input class="txt" id="email" value="<?=$email;?>" maxlength="50" readonly="readonly" /></td>
		</tr>
		
		<tr>
			<td>Last Login:</td><td><input class="txt" id="email" value="<?=$_SESSION['last_login'];?>" readonly="readonly" /></td>
		</tr>		
	</table>
	<h3 align="center">Change Password</h3>
	<table width="100%" border="0px" cellpadding="5px">
		<tr>
			<td width="20%">Old Password:</td><td width="80%"><input type="password" class="txt" id="old-password" maxlength="20" /></td>
		</tr>
		
		<tr>
			<td>New Password:</td><td><input class="txt" type="password" id="new-password" maxlength="20" /></td>
		</tr>
		
		<tr>
			<td>Confirm New Password:</td><td><input class="txt" type="password" id="confirm-new-password" maxlength="20" /></td>
		</tr>
		
		<tr>
			<td></td><td align="right"><input class="btn" type="button" id="btn-save" value="Change" onclick="change_password()" /></td>
		</tr>
		
		<tr>
			<td></td><td id="msg"></td>
		</tr>
		
	</table>
</div>
<script>
	effect_trading_account();
	effect_pl_account();
</script>