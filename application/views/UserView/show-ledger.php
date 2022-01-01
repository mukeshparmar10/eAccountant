<?php	
	if(isset($_SESSION['user_id']) && isset($_POST['ledger']))
	{		
		$show_ledger = $this->User_Model->exe_query("select * from ledger_master where UserID=" . $_SESSION['user_id']);
		if($show_ledger->num_rows() > 0)
		{
			$ledger = array();
			foreach($show_ledger->result() as $row)
			{
				$ledger[$row->ID] = $row->LedgerName;
			}
		}	
		$ledger_id = $_POST['ledger'];
	
		$query = "select * from journal_master where DebitLedgerID=" . $ledger_id;
		$result = $this->User_Model->exe_query($query);
		$credit_amount=0;
		$debit_amount=0;
		if($result->num_rows() > 0)
		{
			$i=0;
			$credit_side = array();
			foreach($result->result() as $row)
			{
				$credit_side[$i] = array();
				$credit_side[$i][0] = $row->TransactionDate;
				$credit_side[$i][1] = $ledger[$row->CreditLadgerID];
				$credit_side[$i][2] = $row->CreditAmount;
				$credit_amount += (float)$row->CreditAmount;
				$i++;
			}
		}
	
		$query = "select * from journal_master where CreditLadgerID=" . $ledger_id;
		$result = $this->User_Model->exe_query($query);
		if($result->num_rows() > 0)
		{
			$i=0;
			$debit_side = array();
			foreach($result->result() as $row)
			{
				$debit_side[$i] = array();
				$debit_side[$i][0] = $row->TransactionDate;
				$debit_side[$i][1] = $ledger[$row->DebitLedgerID];
				$debit_side[$i][2] = $row->DebitAmount;
				$debit_amount += (float)$row->DebitAmount;
				$i++;
			}
		}
	
		$credit_side_balance = 0;
		$debit_side_balance = 0;
		if($credit_amount > $debit_amount)
		{
			$debit_side_balance = $credit_amount - $debit_amount;
			$credit_side_balance = 0;
		}
	
		if($debit_amount > $credit_amount)
		{
			$credit_side_balance = $debit_amount - $credit_amount;
			$debit_side_balance = 0;
		}
	}
	else
	{
		echo "Invalid access";
		exit;
	}	
?>
<big><?=$ledger[$ledger_id]?></big>
<table border="1px" cellspacing="0px" cellpadding="10px">
	<tr>
		<th>Date</th>
		<th>Particulars</th>
		<th>Amount</th>
		<th>Date</th>
		<th>Particulars</th>
		<th>Amount</th>
	</tr>
	<tr>		
		<td valign="top" align="center">
			<?php
				if(isset($credit_side))
				{
					foreach($credit_side as $cs)
					{
						echo $cs[0] . '<br>';
					}
				}
				if($credit_side_balance > 0)
				{
					echo date('Y-m-d');
				}
			?>
		</td>
		<td valign="top">
			<?php
				if(isset($credit_side))
				{
					foreach($credit_side as $cs)
					{
						echo $cs[1] . '<br>';
					}
				}
				if($credit_side_balance > 0)
				{
					echo "To Balance C/d";
				}
			?>
		</td>
		<td valign="top" align="center">
			<?php
				if(isset($credit_side))
				{
					foreach($credit_side as $cs)
					{
						echo $cs[2] . '<br>';
					}
				}
				if($credit_side_balance > 0)
				{
					echo $credit_side_balance;
				}
			?>
		</td>
		
		<td valign="top" align="center">
			<?php
				if(isset($debit_side))
				{
					foreach($debit_side as $ds)
					{
						echo $ds[0] . '<br>';
					}
				}
				if($debit_side_balance > 0)
				{
					echo date('Y-m-d');
				}
			?>
		</td>
		<td valign="top">
			<?php
				if(isset($debit_side))
				{
					foreach($debit_side as $ds)
					{
						echo $ds[1] . '<br>';
					}
				}
				
				if($debit_side_balance > 0)
				{
					echo "By Balance C/d";
				}
			?>
		</td>
		<td valign="top" align="center">
			<?php
				if(isset($debit_side))
				{
					foreach($debit_side as $ds)
					{
						echo $ds[2] . '<br>';
					}
				}
				
				if($debit_side_balance > 0)
				{
					echo $debit_side_balance;
				}
			?>			
		</td>		
	</tr>
	<tr>
		<th></th>
		<th></th>
		<th><?=$credit_amount+$credit_side_balance;?></th>
		<th></th>
		<th></th>
		<th><?=$debit_amount+$debit_side_balance;?></th>
	</tr>
</table>
<?php
	$query = "update ledger_master set DebitAmount=". $debit_side_balance . ",CreditAmount = " . $credit_side_balance . " where ID = " . $ledger_id . " and UserID=" . $_SESSION['user_id'];
	$this->User_Model->exe_query($query);
?>