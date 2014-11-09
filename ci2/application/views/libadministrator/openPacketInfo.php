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
    	#openPacket{
    		padding-left:6%;
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
			<li ><a href="../../um/index">User Management</a></li>
			<li ><a href="../../rm/index">Raw Material Management</a></li>
			<li id="current"><a href="">Batch Management</a></li>
			<li><a href="../../ob/placedOrders">Placed Order</a></li>
			<li><a href="../../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="openPacket">
		<h2 style="text-align:center">Open Packet Information</h2>
		<h3>Batch Id =			  <?php echo $batchId; ?><?php ?></h3>
		<form id="openpacketinfoForm" method="post" action="">
			<h4>Packet Information</h4>
			
			<div id="table">
			<?php
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='materialname'>Packet Name</td>";
		     	echo "<td id='materialquantity'>Packet Quantity</td>";
		     	echo "<td id='materialquantity'>Packet Unit</td>";
		     	echo "<td id='materialquantity'>Packet Received For Batch</td>";
		     	echo "<td id='materialquantity'>Overall Packet Availablity</td>";
			    echo "</tr>"; 
				$counter = 0;
				foreach($packetInfo as $info){
					if(isset($packets[$counter])){
						echo "<tr>";
				     	echo "<td>".$packets[$counter][0]->packet_name."</td>";
				     	echo "<td>".$packets[$counter][0]->packet_quantity."</td>";
				     	echo "<td>".$packets[$counter][0]->packet_unit."</td>";
				     	echo "<td>".$info->received."</td>";
				     	echo "<td>".$packets[$counter][0]->packet_unit."</td>";
			     	 	echo "</tr>";
					}
					$counter++;
				}
				 
				?>
				<tr>
				</tr>
			</table>
		</div>
		</form>
	</div>
	<div id="element"><?php echo $message;?></div>	
	
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
