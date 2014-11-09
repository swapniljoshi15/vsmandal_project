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
    		padding-left:60%;
    	}
    	#buttonContainer .editUser{
    		float:left;
    		padding-top:5%;
		}
		#buttonContainer .removeUser{
			float:right;
			padding-top:5%;
			padding-right:30px;
		}
		#addPacketDistributionButton{
			padding-top:10%;
			padding-left:60%;
		}
		#table{
			padding-top:2%;
			padding-left:2%;
		}
		#materialno{
			width:20px;
		}
		#packetname{
			width:100px;
		}
		#packetquantity{
			width:100px;
		}
		#noofpacketsdist{
			width:125px;
		}
		#amountof{
			width:125px;
		}
		#amountpaid{
			width:125px;
		}
		#action{
			width:125px;
		}
		#accountInformation{
			padding-top:2%;
		}
		#accountManagement{
			padding-top:2%;
			padding-left:60%;
		}
		#accountTable{
			padding-top:2%;
			padding-left:5%;
		}
		#accountamount{
			width:175px;
		}
		#packetstotalamount{
			width:175px;
		}
		#remainingamount{
			width:175px;
		}
		#accbalance{
			width:175px;
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
			<li><a href="../../ob/placedOrders">Placed Order</a></li>
			<li><a href="../../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="buttonContainer">
	<form 
		name="editUserButtonForm"
		method="get"
		action="../editUser/<?php echo $userid?>"
		style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
		<div class="editUser">
			<button type="submit" id="btn" onclick="">Edit User</button>
		</div>
	</form>
	<form 
		name="removeUserButtonForm"
		method="post"
		action="../removeUser/<?php echo $userid?>"
		style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
		<div class="removeUser">
			<input type="hidden" name="userid" value="<?php echo $userid;?>" />
			<input type="hidden" name="confirm" value="no" />
			<button type="submit" id="btn" onclick="">Delete User</button>
		</div>
	</form>
	</div>
	
	<div>
		<div id="addPacketDistributionButton">
			<form 
				name="addPacketDistributionButtonForm"
				method="post"
				action="../../pd/addPacketDistribution/<?php echo $userid?>"
				style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
				<div class="removeUser">
					<button type="submit" id="btn" onclick="">Create New Distribution Batch</button>
				</div>
			</form>
		</div>
	
	<div id="table">
			<?php
				$counter = 1;
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='packetno'>No</td>";
		     	echo "<td id='packetname'>Packet Name</td>";
		     	echo "<td id='packetquantity'>Packet Quantity</td>";
		     	echo "<td id='noofpacketsdist'>Packets taken for Distribution</td>";
		     	echo "<td id='amountof'>Amount of each packet</td>";
		     	echo "<td id='amountpaid'>Total amount to be paid</td>";
		     	echo "<td id='action'>Action</td>";
			    echo "</tr>"; 
				
			    if($packetDistributions != NULL){
				    foreach($packetDistributions as $packetDistribution){
					      foreach($packets as $packet){
					      	if($packet->packet_id == $packetDistribution->packetid){
					      		 echo "<tr>";
						     	echo "<td>".$counter++."</td>";
						     	echo "<td>".$packet->packet_name."</td>";
						     	echo "<td>".$packet->packet_quantity." ".$packet->	packet_unit."</td>";
						     	echo "<td>".$packetDistribution->noofpackets."</td>";
						     	echo "<td>".$packetDistribution->amountofpacket."</td>";
						     	echo "<td>".($packetDistribution->noofpackets*$packetDistribution->amountofpacket)."</td>";
						     	echo "<td><a href='../../pd/returnPacketsFromBatch/".$packetDistribution->id."'>Return packets</a><br/><a href='../../pd/addPacketsToBatch/".$packetDistribution->id."'>Add packets</a></td>";
						     	echo "</tr>";
					      	}
					      }
					}
			    }
				 
				echo "</table>";
				?>
		</div>
	</div>
	
	<div id="accountInformation">
		<div id="accountManagement">
			<form 
				name="accountManagementButtonForm"
				method="post"
				action="../../am/accountManagement"
				style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
				<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
				<div class="accMgmt">
					<button type="submit" id="btn" onclick="">Account Management</button>
				</div>
			</form>
		</div>
		<div id="accountTable">
			<?php
				$counter = 1;
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='accountamount'>Account Amount</td>";
		     	echo "<td id='packetstotalamount'>Packets Total Amount</td>";
		     	echo "<td id='remainingamount'>Remaining Amount</td>";
		     	echo "<td id='accbalance'>Account Balance</td>";
			    echo "</tr>"; 
				
	      		 if($account != NULL){
	      		 	echo "<tr>";
			     	echo "<td>".$account->accamnt."</td>";
			     	echo "<td>".$account->pkttotalamnt."</td>";
			     	echo "<td>".$account->remamnt."</td>";
			     	echo "<td>".$account->	accbaln."</td>";
			     	echo "</tr>";
	      		 }
				
				echo "</table>";
				?>
				<div id="element"><?php echo $message;?></div>
		
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
