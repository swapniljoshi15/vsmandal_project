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
    	#addPacketDistribution{
    		padding-left:10%
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
			<li id="current"><a href="">User Management</a></li>
			<li><a href="../../rm/index">Raw Material Management</a></li>
			<li><a href="../../bm/index">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="addPacketDistribution">
		<h2 style="text-align:center">Create New Distribution Batch</h2>
		<form id="addPacketDistributionForm" method="post" action="">
			<table>
				<tr>
					<td>Packet Name</td>
					<td>
						<select name="packettype" style="width:175px;">
							<option value=''>select</option>
							<?php foreach($packets as $packet){
								echo "<option value='".$packet->packet_id."'>".$packet->packet_name." ".$packet->packet_quantity." ".$packet->packet_unit."</option>";
								}
				          	 ?>
			          	 </select>
					</td>
				</tr>
				<tr>
					<td>No Of Packets taken for distribution</td>
					<td><input type="textbox" name="noofpacket" value=""></td>
				</tr>
				<tr>
					<td>Amount of each packet</td>
					<td><input type="textbox" name="amount" value=""></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" id="btn">Create</button>
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
