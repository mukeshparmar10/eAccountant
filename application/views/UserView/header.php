<?php
	session_start();
	if(!isset($_SESSION['user_id']))
	{
		redirect(BASEURL);
	}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="shortcut icon" href="<?=IMAGES;?>favicon.ico" type="image/x-icon"/>
<title>AccApp</title>
<script src="<?=JS;?>jquery-3.4.1.js"></script>
<script>
function effect_trading_account()
{
	$.post("<?=BASEURL;?>trading-account",{},function(data){		
	});
}
function effect_pl_account()
{
	$.post("<?=BASEURL;?>profit-loss-account",{},function(data){		
	});
}
</script>
<style>
body {
	margin:50px 0px 20px 0px;
	background-color:#f9f9f9;
	font-family: 'Open Sans', Arial, Helvetica, Sans-serif, Verdana, Tahoma;
}
a{
	text-decoration:none;
	color:#000000;
	font-size:16px;
}
.container{
	width:100%;
	max-width:980px;
	margin:auto;
}
table{
	background-color:#ffffff;
	margin-top:10px;
	border:solid 1px #48adea;
	box-shadow:1px 1px 3px #cccccc;
}
.navigation a:hover{
	color:#ffffff;
}
.navigation{
	position:fixed;
	background-color:#48adea;
	left:0px;
	top:0px;
	right:0px;
	height:27px;
	padding : 7px;
	text-align:center;
	font-size:18px;
}
.txt{
	width:99%;
	height:25px;
	border:none;
	outline:none;
	border-bottom:solid 1px #cccccc;
}

.txt-amt{
	text-align:center;
}

.btn{
	width:80px;
	border:none;
	background-color:#ccc;
	padding:5px 10px 5px 10px;
	border:solid 1px #333;
}
.copy-info{
	position:fixed;
	bottom:10px;
	right:10px;
	background-color:#48adea;
	padding:8px;
	color:#ffffff;
	box-shadow:0px 0px 5px #000000;
}
</style>
</head>
<body>
<div class="navigation">
	<a href="<?=BASEURL;?>home">Home</a> | <a href="<?=BASEURL;?>ledger">Ledger</a> | <a href="<?=BASEURL;?>journal">Journal</a> | <a href="<?=BASEURL;?>trial-balance">Trial Balance</a> | <a href="<?=BASEURL;?>trading-account">Trading Account</a> | <a href="<?=BASEURL;?>profit-loss-account">Profit and Loss Account</a> | <a href="<?=BASEURL;?>balance-sheet">Balance Sheet</a> | <a href="<?=BASEURL;?>logoff">Log off</a>
</div>
<div class="container">