<?php	
	$result = $this->User_Model->exe_query("select * from ledger_master where UserID=" . $_SESSION['user_id'] . " and GroupID in (2,3,4,5,7,8,12,13,15)");
	if($result->num_rows() > 0)
	{
		$i = 0;
		$ledger_dr = array();
		foreach($result->result() as $row)
		{
			$ledger_dr[$i] = array();
			$ledger_dr[$i][0] = $row->ID;
			$ledger_dr[$i][1] = $row->LedgerName;
			$i++;
		}
	}
	
	$result = $this->User_Model->exe_query("select * from ledger_master where UserID=" . $_SESSION['user_id'] . " and GroupID in (1,2,3,4,6,9,10,11,13,14)");
	if($result->num_rows() > 0)
	{
		$i = 0;
		$ledger_cr = array();
		foreach($result->result() as $row)
		{
			$ledger_cr[$i] = array();
			$ledger_cr[$i][0] = $row->ID;
			$ledger_cr[$i][1] = $row->LedgerName;
			$i++;
		}
	}
?>
<script>
function noTab()
{
	$("#date").css("color","#000000");
	$("#month").css("color","#000000");
	$("#year").css("color","#000000");
	$("#debit-ledger").css("color","#000000");
	$("#debit-amount").css("color","#000000");
	$("#credit-ledger").css("color","#000000");
	$("#credit-amount").css("color","#000000");
	$("#narration").css("color","#000000");	
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
				$("#month").focus();
				noTab();
				$("#month").css("color","#ff0000");
				break;
			case 2:				
				$("#year").focus();
				noTab();
				$("#year").css("color","#ff0000");
				break;
			case 3:
				$("#debit-ledger").focus();
				noTab();
				$("#debit-ledger").css("color","#ff0000");
				break;
			case 4:
				$("#debit-amount").focus();
				noTab();
				$("#debit-amount").css("color","#ff0000");
				break;
			case 5:
				$("#credit-ledger").focus();
				noTab();
				$("#credit-ledger").css("color","#ff0000");
				break;
			case 6:
				$("#credit-amount").focus();
				noTab();
				$("#credit-amount").css("color","#ff0000");
				break;
			case 7:
				$("#narration").focus();
				noTab();
				$("#narration").css("color","#ff0000");
				break;
			case 8:
				$("#save-btn").focus();
				noTab();
				break;
		}
	}	
}
</script>
<center><b>Journal Entry</b></center>
<table border="0px" width="800px" align="center" cellspacing="0px" cellpadding="8px">
	<tr>
		<td></td>
		<td colspan="3" align="right"><small>Select Date:</small>
			<select id="date" onkeydown="tab(event,1)">
				<?php
					for($i=1;$i<=31;$i++)
					{
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
				?>
			</select>
			<select id="month" onkeydown="tab(event,2)">
				<?php
					for($i=1;$i<=12;$i++)
					{
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
				?>
			</select>
			<select id="year" onkeydown="tab(event,3)">
				<?php
					for($i=2018;$i<=2025;$i++)
					{
						echo '<option value="' . $i . '">' . $i . '</option>';
					}
				?>
			</select>
			<script>
				$("#date").val(<?=date('d')?>);
				$("#month").val(<?=date('m')?>);
				$("#year").val(<?=date('Y')?>);
			</script>
		</td>
		
	</tr>
	<tr>
		<th width="20px"></th>
		<th width="500px" align="left">Account/Ledger <a href="ledger-entry.php"><small> [ Create Ledger ]</small></a></th>
		<th>Dr (Account)</th>
		<th>Cr (Account)</th>
	</tr>
	<tr>
		<td align="center">Dr</td>
		<td>
			<select class="txt" id="debit-ledger" onkeydown="tab(event,4)">
				<option value="0">Select Debit Ledger</option>
				<?php
					if(isset($ledger_dr))
					{
						foreach($ledger_dr as $l)
						{
							echo '<option value="' . $l[0] . '">'. $l[1] .'</option>';
						}
					}
				?>
			</select>
		</td>
		<td><input class="txt txt-amt" id="debit-amount" type="text" placeholder="Debit Amount" onkeydown="tab(event,5)" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="center">Cr</td>
		<td>
			<select class="txt" id="credit-ledger" onkeydown="tab(event,6)">
				<option value="0">Select Credit Ledger</option>
				<?php
					if(isset($ledger_cr))
					{
						foreach($ledger_cr as $l)
						{
							echo '<option value="' . $l[0] . '">'. $l[1] .'</option>';
						}
					}
				?>
			</select>
		</td>
		<td>&nbsp;</td>
		<td><input class="txt txt-amt" id="credit-amount" type="text" placeholder="Credit Amount" onkeydown="tab(event,7)" /></td>		
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">
			<small>Narration:</small><br>
			<input class="txt" id="narration" type="text" maxlength="200" placeholder="Short Narration" onkeydown="tab(event,8)" />
		</td>		
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="2" id="save-msg" style="color:#ff0000;font-size:14px"></td>		
		<td align="right"><input id="save-btn" class="btn" type="button" value="OK" onclick="save_journal_entry()" /></td>
	</tr>
</table>
<script>
function save_journal_entry()
{
	var valid=true;
	$("#save-msg").html();
	var date = $("#year").val() + "-" + $("#month").val() + "-" + $("#date").val();;
	
	if($("#debit-ledger").val()=="0")
	{
		$("#debit-ledger").focus();
		valid = false;
		return false;
	}
	else
	{
		var debit_acc = $("#debit-ledger").val();
	}
	
	if($("#credit-ledger").val()=="0")
	{
		$("#credit-ledger").focus();
		valid = false;
		return false;
	}
	else
	{
		var credit_acc = $("#credit-ledger").val();
	}	
	
	if(debit_acc==credit_acc)
	{		
		$("#save-msg").html("Please select valid ledger");
		valid = false;
		return false;
	}		
	
	if($("#debit-amount").val()=="")
	{
		$("#debit-amount").focus();
		valid = false;
		return false;
	}
	else
	{
		var debit_amount = $("#debit-amount").val();
	}
	
	if($("#credit-amount").val()=="")
	{
		$("#credit-amount").focus();
		valid = false;
		return false;
	}
	else
	{
		var credit_amount = $("#credit-amount").val();
	}
	
	if($("#narration").val()=="")
	{
		$("#narration").focus();
		valid = false;
		return false;
	}
	else
	{
		var narration = $("#narration").val();
	}
	
	if(valid == true)
	{
		$.post("<?=BASEURL;?>journal-save",{date:date,debit_acc:debit_acc,debit_amount:debit_amount,credit_acc:credit_acc,credit_amount:credit_amount,narration:narration},function(data){
			if(data)
			{
				effect_ledger(debit_acc);
				effect_ledger(credit_acc);
				effect_trading_account();
				effect_pl_account();
				
				$("#save-msg").html(data);
				$("#debit-ledger").val('0');
				$("#debit-amount").val('');
				$("#credit-ledger").val('0');
				$("#credit-amount").val('');
				$("#narration").val('');				
			}
		});
	}
}

function effect_ledger(id)
{	
	$.post("<?=BASEURL;?>show-ledger",{ledger:id},function(data){		
	});
}
</script>