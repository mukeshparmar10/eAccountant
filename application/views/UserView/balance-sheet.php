<?php
	$debit = 0;
	$credit = 0;
	
	if(isset($_SESSION['net_profit']))
	{
		$net_profit = $_SESSION['net_profit'];
	}
	else
	{
		$net_profit = 0;
	}
	
	if(isset($_SESSION['net_loss']))
	{
		$net_loss = $_SESSION['net_loss'];
	}
	else
	{
		$net_loss = 0;
	}	

	$result = $this->User_Model->exe_query("select * from ledger_master where GroupID in (1,11) and UserID=" . $_SESSION['user_id']);
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
		
		if((float)$net_profit > 0)
		{
			$debit_side[$i]=array();
			$debit_side[$i][0] = "Net Profit";
			$debit_side[$i][1] = $net_profit;
			$debit_side[$i][2] = $net_profit;
			$debit += (float)$net_profit;
		}
		
		if((float)$net_loss > 0)
		{
			$debit_side[$i]=array();
			$debit_side[$i][0] = "(-) Net Loss";
			$debit_side[$i][1] = $net_loss;
			$debit_side[$i][2] = $net_loss;
			$debit -= (float)$net_loss;
		}
		
	}	
	
	$result = $this->User_Model->exe_query("select * from ledger_master where GroupID in (2,3,4,12,13) and UserID=" . $_SESSION['user_id']);
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
?>
<center><b>Balance Sheet on <?=date('Y-m-d')?></b></center>
<table border="1px" cellspacing="0px" cellpadding="10px" align="center">
<tr><th>Liabilities</th><th>Amount</th><th>Assets</th><th>Amount</th></tr>
	<tr>
		<td valign="top">
			<?php
				foreach($debit_side as $ds)
				{
					echo $ds[0] . '<br>';
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
			?>			
		</td>
		
		<td valign="top">
			<?php
				foreach($credit_side as $cs)
				{
					echo $cs[0] . '<br>';
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