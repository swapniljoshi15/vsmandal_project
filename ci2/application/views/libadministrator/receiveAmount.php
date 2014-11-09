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
    	input[type="radio"] {
		    margin-left:50px;
		}
		input[type="textbox"] {
		    margin-left:50px;
		    width:300px;
		}
		button[type="submit"] {
			padding-top:100px;
		    margin-left:150px;
		}
		#messages{
			padding-top:20px;
			margin-left:150px;
			text-color:red;
		}
		td{
			text-align:center;
			padding-top:20px;
		}
		tr{
			text-align:center;
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
			<li ><a href="../../auth/index">Home</a></li>
			<li id="current"><a href="#">User Management</a></li>
			<li><a href="../../rm/index">Raw Material Management</a></li>
			<li><a href="../../bm/index">Batch Management</a></li>
			<li><a href="../../ob/placedOrders">Placed Order</a></li>
			<li><a href="../../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="">
		<h2 style="text-align:center">Received Amount</h2>
		<form id="addPacketForm" method="post" action="">
			<table>
				<tr>
					<td>User Mobile No</td>
					<td><input type="textbox" name="" value="<?php echo $user->username;?>" disabled='disabled'></td>
				</tr>
				<tr>
					<td>First Name</td>
					<td><input type="textbox" name="" value="<?php echo $user->first_name;?>" disabled='disabled'></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td><input type="textbox" name="" value="<?php echo $user->last_name;?>" disabled='disabled'></td>
				</tr>
				<tr>
					<td>Amount</td>
					<td><input type="textbox" name="amount" value=""></td>
				</tr>
				<tr>
					<td>Reenter Amount</td>
					<td><input type="textbox" name="ramount" value=""></td>
				</tr>
				<input type="hidden" name="userid" value="<?php echo $user->id;?>"/>
				<tr>
					<td></td>
					<td>
						<button type="submit" id="btn">Received</button>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div id="element"><?php echo $message;?></div>
					</td>
				</tr>
			</table>
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
