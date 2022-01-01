<?php	
	$debit = 0;
	$credit = 0;
	$result = $this->User_Model->exe_query("select * from ledger_master where GroupID=5 and UserID=" . $_SESSION['user_id']);
	if($result->num_rows() > 0)
	{
		$i=0;
		$debit_side = array();
		foreach($result->result() as $row)
		{
			$debit_side[$i]=array();			
			$debit_side[$i][0] = $row->LedgerName;
			$debit_side[$i][1] = $row->DebitAmount;
			$debit_side[$i][2] = $row->CreditAmount;
			$debit += (float)$row->DebitAmount;
			$debit += (float)$row->CreditAmount;
			$i++;
		}
	}
	
	$result = $this->User_Model->exe_query("select * from ledger_master where GroupID=7 and UserID=" . $_SESSION['user_id']);
	if($result->num_rows() > 0)
	{	
		foreach($result->result() as $row)
		{
			$debit_side[$i]=array();			
			$debit_side[$i][0] = $row->LedgerName;
			$debit_side[$i][1] = $row->DebitAmount;
			$debit_side[$i][2] = $row->CreditAmount;
			$debit += (float)$row->DebitAmount;
			$debit += (float)$row->CreditAmount;
			$i++;
		}
	}
	
	$result = $this->User_Model->exe_query("select * from ledger_master where GroupID=6 and UserID=" . $_SESSION['user_id']);
	if($result->num_rows() > 0)
	{
		$i=0;
		$credit_side = array();
		foreach($result->result() as $row)
		{
			$credit_side[$i]=array();	
			$credit_side[$i][0] = $row->LedgerName;
			$credit_side[$i][1] = $row->DebitAmount;
			$credit_side[$i][2] = $row->CreditAmount;
			$credit += (float)$row->DebitAmount;
			$credit += (float)$row->CreditAmount;
			$i++;
		}
	}
	
	$gross_profit = 0;
	$gross_loss = 0;
	
	if($debit < $credit)
	{
		$gross_profit = $credit - $debit;
		$debit = $credit;
		$_SESSION['gross_profit'] = $gross_profit;
	}
	
	if($debit > $credit)
	{
		$gross_loss = $debit - $credit;
		$credit = $debit;
		$_SESSION['gross_loss'] = $gross_loss;
	}
	
	
?>
<center><b>Trading account on <?=date('Y-m-d')?></b></center>
<table border="1px" cellspacing="0px" cellpadding="10px" align="center">
<tr><th>Particular</th><th>Amount</th><th>Particular</th><th>Amount</th></tr>
	<tr>
		<td valign="top">
			<?php
				foreach($debit_side as $ds)
				{
					echo $ds[0] . '<br>';
				}
				
				if($gross_profit > 0)
				{
					echo 'Gross Profit<br>';
				}
			?>
		</td>
		<td align="center" valign="top">
			<?php
				foreach($debit_side as $ds)
				{
					if((float)$ds[1] > (float)$ds[2])
					{
						echo $ds[1] . '<br>';
					}
					else
					{
						echo $ds[2] . '<br>';
					}
				}
				
				if($gross_profit > 0)
				{
					echo $gross_profit;
				}
			?>
			
		</td>
		
		<td valign="top">
			<?php
				foreach($credit_side as $cs)
				{
					echo $cs[0] . '<br>';
				}
				
				if($gross_loss > 0)
				{
					echo 'Gross Loss<br>';
				}
			?>
		</td>
		<td align="center" valign="top">
			<?php
				foreach($credit_side as $cs)
				{
					if((float)$cs[1] > (float)$cs[2])
					{
						echo $cs[1] . '<br>';
					}
					else
					{
						echo $cs[2] . '<br>';
					}
				}
				
				if($gross_loss > 0)
				{
					echo $gross_loss;
				}
			?>
		</td>
	</tr>
	<tr>
		<th></th>		
		<th><?=$debit;?></th>
		<th></th>
		<th><?=$credit;?></th>
	</tr>
</table>