<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Utana Project</title>

	 <!-- Load stylesheets for login_template-->
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/all.css'; ?>">
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/login_form.css'; ?>">
	 
    <!-- Load stylesheets for general_template-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/screen.css'; ?>">
	<!-- // Load stylesheets -->

    <!--[if lt IE 9]>
	    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
    	#buttonContainer{
    		padding-top:10%;
    		padding-left:10%;
    		padding-right:10%;
    		padding-bottom:20%;
    		border:12px 12px 12px 12px;
    	}
    	#buttonContainer .receiveAmount{
    		float:left;
    		padding-top:10%;
    		border:2px 2px 2px 2px;
		}
		#buttonContainer .paybackAmount{
			float:right;
			padding-top:10%;
			padding-right:30px;
			border:2px 2px 2px 2px;
		}
		#element{
			padding-top:3%;	
		 	padding-left:40%;	
		}
    </style>

</head>

<body>

<!-- wrap starts here -->
<div id="wrap">

	<!--header -->
	<div id="header">			
				
		<h1 id="logo-text"><a href="" title="">Utana Project</a></h1>		
		<p id="slogan">Utana Project</p>			
				
	<!--header ends-->					
	</div>
		
	<!-- navigation starts-->	
	<div  id="nav">
		<ul>
			<li ><a href="../auth/index">Home</a></li>
			<li id="current"><a href="#">User Management</a></li>
			<li><a href="../rm/index">Raw Material Management</a></li>
			<li><a href="../bm/index">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="buttonContainer">
	<form 
		name="receiveAmountButtonForm"
		method="post"
		action="receiveAmount/<?php echo $userid;?>"
		style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
		<div class="receiveAmount">
			<button type="submit" id="btn" onclick="">Receive Amount</button>
		</div>
	</form>
	<form 
		name="paybackAmountButtonForm"
		method="post"
		action="paybackAmount/<?php echo $userid;?>"
		style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
		<div class="paybackAmount">
			<button type="submit" id="btn" onclick="">Payback Amount</button>
		</div>
	</form>
	</div>
	
	
		
	<!-- footer starts -->					
	<div id="footer">
						
			<p>
			&copy; All your copyright info here  
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			Design by <a href="NGOLINK">NGO</a>

   		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
   		</p>			
	
	<!-- footer ends-->
	</div>

<!-- wrap ends here -->
</div>

</body>
</html>
