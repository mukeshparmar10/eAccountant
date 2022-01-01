<?php
	$result = $this->User_Model->exe_query("select * from ledger_group_master");
	if($result->num_rows() > 0)
	{
		$i = 0;
		$ledger = array();
		foreach($result->result() as $row)
		{
			$ledger[$i] = array();
			$ledger[$i][0] = $row->GroupCode;
			$ledger[$i][1] = $row->GroupName;
			$i++;
		}
	}
?>
<center><b>Create New Ledger</b></center>
<table border="0px" width="600px" align="center" cellspacing="0px" cellpadding="10px">
	<tr>
		<td align="right" width="70px">Ledger</td>
		<td>
			<input class="txt" id="ledger" type="text" maxlength="100" placeholder="Enter Ledger Name" onkeydown="tab(event,1)" />
		</td>		
	</tr>
	<tr>
		<td align="right">Group</td>
		<td>
			<select class="txt" id="group" onkeydown="tab(event,2)">
				<?php
					if(isset($ledger))
					{
						foreach($ledger as $l)
						{
							echo '<option value="' . $l[0] . '">'. $l[1] .'</option>';
						}
					}
				?>
			</select>
		</td>		
	</tr>	
	<tr>		
		<td></td>		
		<td align="right"><input class="btn" id="btn-save" type="button" value="OK" onclick="save_ledger()" />&nbsp;<input class="btn" id="btn-cancel" type="button" value="CANCEL" onclick="history.back()" /></td>
	</tr>
	<tr>
		<td></td>		
		<td colspan="2" id="save-msg" style="color:#ff0000;font-size:14px">&nbsp;</td>		
	</tr>
</table>
<script>
function save_ledger()
{
	var valid=true;
	$("#save-msg").html();	
	var group = $("#group").val();	
	
	if($("#ledger").val()=="")
	{
		$("#ledger").focus();
		valid = false;
		return false;
	}
	else
	{
		var ledger = $("#ledger").val();
	}
	
	if(valid == true)
	{
		$.post("<?=BASEURL;?>ledger-save",{ledger:ledger,group:group},function(data){
			if(data)
			{
				$("#save-msg").html(data);
			}
		});
	}
}
function tab(event,id)
{
	if(event.keyCode==13)
	{		
		switch(id)
		{
			case 0:
				break;
			case 1:				
				$("#group").focus();
				noTab();
				$("#group").css("color","#ff0000");
				break;
			case 2:				
				$("#btn-save").focus();
				noTab();				
				break;
		}
	}
}
function noTab()
{
	$("#ledger").css("color","#000000");
	$("#group").css("color","#000000");		
}
</script>