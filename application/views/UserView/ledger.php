<script>function show_ledger(id){		$.post("<?=BASEURL;?>show-ledger",{ledger:id},function(data){		if(data)		{			$("#ledger").html(data);		}	});}
function delete_ledger(id)
{
	if(confirm("Are you sure to delete?")==true)
	{
		$.post("<?=BASEURL;?>ledger-delete",{ledger:id},function(data){
			if(data)
			{
				if(data=="1")
				{
					$("#led"+id).hide(100);
				}
				else if(data=="0")
				{
					alert("Ledger can't delete!");
				}
				else
				{
					alert(data);
				}
			}
			else
			{
				alert("Does not process! Try again!");
			}
		});
	}
}
</script>
<table border="0px" cellpadding="10px" align="center" width="100%"><tr><td valign="top" width="20%">
<a href="<?=BASEURL;?>ledger-entry"><small>Create New Ledger</small></a><br>
<?php	$query = "select * from ledger_master where UserID=" . $_SESSION['user_id'];	
	$ledger = $this->User_Model->exe_query($query);	
	if($ledger->num_rows() > 0)
	{
		echo '<ul style="margin-left:-27px;margin-top:10px;">';
		foreach($ledger->result() as $row)
		{			
			echo '<li id="led'. $row->ID .'"><big><a href="#" onclick="show_ledger(' . $row->ID . ')">' . $row->LedgerName . '</a></big><br><a style="font-size:12px;" href="'. BASEURL .'ledger-edit?lid='. $row->ID .'">Edit</a> | <a style="font-size:12px;" href="#" onclick="delete_ledger('. $row->ID .')">Delete</a></li>';		}
		echo '</ul>';
	}
?>
</td><td  width="80%" id="ledger" valign="top" align="center" ><h2 align="center">Click on Ledger to show here</h2></td></tr>