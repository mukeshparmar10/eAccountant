<script>
function removeTransaction(id)
{	
	if(confirm("Are you sure to delete?")==true)
	{
		$.post("<?=BASEURL?>journal-delete",{transaction_id:id},function(data){
			if(data)
			{
				if(data=="1")
				{
					$("#j"+id).hide(100);
				}
				else
				{
					alert("Doest not delete!");
				}			
			}
			else
			{
				alert("Please try again!");
			}
		});
	}
}
</script>
<center><b>Journal Entries</b> | <a href="<?=BASEURL;?>journal-entry"><small>New Journal Entry</small></a></center>
<?php	
	$result = $this->User_Model->exe_query("select * from ledger_master where UserID=" . $_SESSION['user_id']);
	if($result->num_rows() > 0)
	{
		$ledger = array();
		foreach($result->result() as $row)
		{
			$ledger[$row->ID] = $row->LedgerName;
		}
	}
	
	$query = "select * from journal_master where UserID=". $_SESSION['user_id'] ." order by ID asc";
	$result = $this->User_Model->exe_query($query);	
	if($result->num_rows() > 0)
	{		
		echo '<table border="1px" cellspacing="0px" cellpadding="5px" align="center">';
		echo '<tr><th>Date</th><th>Particular</th><th>Dr.</th><th>Cr.</th></tr>';
		foreach($result->result() as $row	)
		{
			echo '<tr id="j'.$row->ID.'">';
			echo '<td valign="top" align="center">' . $row->TransactionDate . '<br><input type="button" value="X" onclick="removeTransaction('. $row->ID .')" /></td>';
			echo '<td>' . $ledger[$row->DebitLedgerID] . '&nbsp;&nbsp;&nbsp;Dr<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To&nbsp;' . $ledger[$row->CreditLadgerID] . '<br><small>' . $row->Description . '</small></td>';
			echo '<td valign="top" align="center">' . $row->DebitAmount . '<br>&nbsp;</td>';
			echo '<td valign="top" align="center">&nbsp;<br>' . $row->CreditAmount . '</td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	else
	{
		echo '<h4 align="center">No Journal Entry Available</h4>';
	}	
?>