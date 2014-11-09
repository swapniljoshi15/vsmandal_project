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
		#addBatch{
			margin-left:10%;
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
			<li ><a href="">Batch Management</a></li>
			<li id="current"><a href="">Placed Order</a></li>
			<li><a href="../../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<div id="">
		<h2 style="text-align:center">Placed Order</h2>
		<form id="editOnlineOrderForm" method="post" action="">
			<table>
				<tr>
					<td style="font:bold;">Order No</td>
					<td style="font:bold;"><?php echo $orders->orderid;?></td>
				</tr>
				<tr>
					<td>First Name</td>
					<td><input type="textbox" name="firstname" value="<?php echo $orders->first_name;?>"></td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td><input type="textbox" name="lastname" value="<?php echo $orders->last_name;?>"></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input type="textbox" name="email" value="<?php echo $orders->email;?>"></td>
				</tr>
				<tr>
					<td>Phone No</td>
					<td><input type="textbox" name="phoneno" value="<?php echo $orders->phone;?>"></td>
				</tr>
				<tr>
					<td>Address</td>
					<td>
						<textarea name="address" rows="4" cols="50">
						<?php echo $orders->address;?>
						</textarea>
					</td>
				</tr>
				<tr>
					<td>Order Placed Date</td>
					<td><input type="textbox" name="dateadd" value="<?php echo $orders->dateAdded;?>" disabled='disabled'></td>
				</tr>
				<tr>
					<td>Reference Name</td>
					<td><input type="textbox" name="refname" value="<?php echo $orders->person_reference;?>"></td>
				</tr>
			</table>
			<div id="table">
			<?php
				$cols = 3;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='materialname'>Packet Name</td>";
		     	echo "<td id='materialquantity'>Packet Weight</td>";
		     	echo "<td id='materialunit'>packets want to purchase</td>";
			    echo "</tr>"; 
				
				foreach($packets as $packet){
					foreach($order_packets as $order_packet){
						if($order_packet->packet_id == $packet->packet_id){
							  echo "<tr>";
						     	echo "<td>".$packet->packet_name."</td>";
						     	echo "<td>".$packet->packet_quantity." ".$packet->packet_unit."</td>";
						     	echo "<td><input type='text' name='".$packet->packet_id."' value='".$order_packet->no_of_packets."'/></td>";
					     	 	echo "</tr>";
						}
					}
				}
				 
				?>
				<tr>
				</tr>
			</table>
			<table  border='1'>
				<tr>
					<td>Status</td>
					<?php 
						$selectedNew = '';
						$selectedPlaced = '';
						$selectedDispatched = '';
						$selectedComplete = '';
						$selectedCancelled = '';
						if($orders->order_status == 'new')$selectedNew="selected='true'";
						if($orders->order_status == 'placed')$selectedPlaced="selected='true'";
						if($orders->order_status == 'dispatched')$selectedDispatched="selected='true'";
						if($orders->order_status == 'complete')$selectedComplete="selected='true'";
						if($orders->order_status == 'cancelled')$selectedCancelled="selected='true'";
					?>
					<td>
						<select name="status">
							<option value="new" <?php echo $selectedNew;?>>New</option>
							<option value="placed" <?php echo $selectedPlaced;?>>Placed</option>
							<option value="dispatched" <?php echo $selectedDispatched;?>>Dispatched</option>
							<option value="complete" <?php echo $selectedComplete;?>>Complete</option>
							<option value="cancelled" <?php echo $selectedCancelled;?>>Cancelled</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Comment</td>
					<td>
						<textarea name="comment" rows="4" cols="50">
						<?php echo $orders->comment;?>
						</textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" id="btn">Edit</button>
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
