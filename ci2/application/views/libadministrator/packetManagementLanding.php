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
    		padding-top:5%;
    		padding-left:60%;
    	}
    	#listrawmaterials{
			padding-top:10px;
			padding-left:50px;
		}
		#materialno{
			width:50px;
		}
		#materialname{
			width:150px;
		}
		#materialunit{
			width:100px;
		}
		#materialref{
			width:250px;
		}
		#materialaction{
			width:75px;
		}
		#materialstatus{
			width:75px;
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
			<li ><a href="../um/index">User Management</a></li>
			<li id="current"><a href="">Raw Material Management</a></li>
			<li><a href="../bm/index">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="buttonContainer">
	<form 
		name="addPacketForm"
		method="get"
		action="addPacket"
		style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
		<div class="addPacket">
			<button type="submit" id="btn" onclick="">Add Packet</button>
		</div>
	</form>
	</div>
	<div id="listrawmaterials">
		<div id="table">
			<?php
				$counter = 1;
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='materialno'>No</td>";
		     	echo "<td id='materialname'>Packet Name</td>";
		     	echo "<td id='materialunit'>Packet Quantity</td>";
		     	echo "<td id='materialunit'>Packet Unit</td>";
		     	echo "<td id='materialref'>Reference (Message)</td>";
		     	echo "<td id='materialaction'>Action</td>";
			    echo "</tr>"; 
				
				foreach($packets as $packet){
				      
				    echo "<tr>";
			     	echo "<td>".$counter++."</td>";
			     	echo "<td>".$packet->packet_name."</td>";
			     	echo "<td>".$packet->packet_quantity."</td>";
			     	echo "<td>".$packet->packet_unit."</td>";
			     	echo "<td>".$packet->packet_reference."</td>";
			     	echo "<td><a href='editPacket/".$packet->packet_id."'>Edit</a><br/></td>";
			     	echo "</tr>";
				    
				}
				 
				echo "</table>";
				?>
		</div>
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
