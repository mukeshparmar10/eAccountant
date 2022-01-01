<?php	
	$result = $this->User_Model->exe_query("select * from ledger_master where UserID=" . $_SESSION['user_id']);
	$debit = 0;
	$credit = 0;
	if($result->num_rows() > 0)
	{
		$i=0;
		$trial_balance = array();
		foreach($result->result() as $row)
		{
			$trial_balance[$i]=array();
			$trial_balance[$i][0] = $i+1;
			$trial_balance[$i][1] = $row->LedgerName;
			$trial_balance[$i][2] = $row->DebitAmount;
			$trial_balance[$i][3] = $row->CreditAmount;
			$debit += (float)$row->DebitAmount;
			$credit += (float)$row->CreditAmount;
			$i++;
		}		
	}
?>
<center><b>Trial Balance on <?=date('Y-m-d')?></b></center>
<table border="1px" cellspacing="0px" cellpadding="10px" align="center">
<tr><th>Sr. No.</th><th>Name of Account</th><th>Dr. Amount</th><th>Cr. Amount</th></tr>
	<tr>
		<td align="center">
			<?php
				foreach($trial_balance as $tb)
				{
					echo $tb[0] . '<br>';
				}
			?>
		</td>
		<td>
			<?php
				foreach($trial_balance as $tb)
				{
					echo $tb[1] . '<br>';
				}
			?>
		</td>
		<td align="center">
			<?php
				foreach($trial_balance as $tb)
				{
					if((float)$tb[2] > 0)
					{
						echo $tb[2] . '<br>';
					}
					else
					{
						echo '<br>';
					}	
					
				}
			?>
		</td>
		<td align="center">
			<?php
				foreach($trial_balance as $tb)
				{
					if((float)$tb[3]>0)
					{
						echo $tb[3] . '<br>';
					}
					else
					{
						echo '<br>';
					}
				}
			?>
		</td>
	</tr>
	<tr>
		<th></th>
		<th></th>
		<th><?=$debit;?></th>
		<th><?=$credit;?></th>
	</tr>
</table>