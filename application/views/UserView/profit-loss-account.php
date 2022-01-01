<?php	
	$debit = 0;
	$credit = 0;
	
	unset($_SESSION['net_profit']);
	unset($_SESSION['net_loss']);
	
	if(isset($_SESSION['gross_profit']))
	{
		$gross_profit = $_SESSION['gross_profit'];
	}
	else
	{
		$gross_profit = 0;
	}
	
	if(isset($_SESSION['gross_loss']))
	{
		$gross_loss = $_SESSION['gross_loss'];
	}
	else
	{
		$gross_loss = 0;
	}	
	
	$result = $this->User_Model->exe_query("select * from ledger_master where GroupID=8 and UserID=" . $_SESSION['user_id']);
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
		
		if((float)$gross_loss > 0)
		{
			$debit_side[$i]=array();
			$debit_side[$i][0] = "Gross Loss";
			$debit_side[$i][1] = $gross_loss;
			$debit_side[$i][2] = $gross_loss;
			$debit += (float)$gross_loss;
		}		
	}	
	
	$result = $this->User_Model->exe_query("select * from ledger_master where GroupID=10 and UserID=" . $_SESSION['user_id'] );
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
		
		if((float)$gross_profit > 0)
		{
			$credit_side[$i]=array();
			$credit_side[$i][0] = "Gross Profit";
			$credit_side[$i][1] = $gross_profit;
			$credit_side[$i][2] = $gross_profit;
			$credit += (float)$gross_profit;
		}
	}
	
	$net_profit = 0;
	$net_loss = 0;
	
	if($debit < $credit)
	{
		$net_profit = $credit - $debit;
		$debit = $credit;
		$_SESSION['net_profit'] = $net_profit;
	}
	
	if($debit > $credit)
	{
		$net_loss = $debit - $credit;
		$credit = $debit;
		$_SESSION['net_loss'] = $net_loss;
	}
?>
<center><b>Profit and Loss account on <?=date('Y-m-d')?></b></center>
<table border="1px" cellspacing="0px" cellpadding="10px" align="center">
<tr><th>Particular</th><th>Amount</th><th>Particular</th><th>Amount</th></tr>
	<tr>
		<td valign="top">
			<?php
				foreach($debit_side as $ds)
				{
					echo $ds[0] . '<br>';
				}
				
				if($net_profit > 0)
				{
					echo 'Net Profit<br>';
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
				
				if($net_profit > 0)
				{
					echo $net_profit;
				}
			?>
			
		</td>
		
		<td valign="top">
			<?php
				foreach($credit_side as $cs)
				{
					echo $cs[0] . '<br>';
				}
				
				if($net_loss > 0)
				{
					echo 'Net Loss<br>';
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
				
				if($net_loss > 0)
				{
					echo $net_loss;
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