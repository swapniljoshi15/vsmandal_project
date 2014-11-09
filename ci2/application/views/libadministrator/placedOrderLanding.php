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
		#listorders{
			padding-top:10px;
		}
		#orderno{
			width:50px;
		}
		#orderfirstname{
			width:100px;
		}
		#orderlastname{
			width:100px;
		}
		#orderemail{
			width:10x;
		}
		#orderphoneno{
			width:100px;
		}
		#orderaddress{
			width:100px;
		}
		#orderrefname{
			width:100px;
		}
		#orderdate{
			width:75px;
		}
		#orderstatus{
			width:50px;
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
			<li><a href="../rm/index">Raw Material Management</a></li>
			<li><a href="../bm/index">Batch Management</a></li>
			<li id="current"><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
	
	<form method="post" action="createNewUser">
	
	<h2 style="text-align:center">Placed Order List</h2>	
	<div id="listorders">
		<div id="">
			<?php
				$counter = 1;
				$cols = 9;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='orderno'>No</td>";
		     	echo "<td id='orderfirstname'>Firstname</td>";
		     	echo "<td id='orderlastname'>Lastname</td>";
		     	echo "<td id='orderemail'>Email</td>";
		     	echo "<td id='orderphoneno'>Phone No</td>";
		     	echo "<td id='orderaddress'>Address</td>";
		     	echo "<td id='orderrefname'>Reference Name</td>";
		     	echo "<td id='orderdate'>Order Date</td>";
		     	echo "<td id='orderstatus'>Order Status</td>";
			    echo "</tr>"; 
				
				if($orders != NULL){
					foreach($orders as $order){
					      
					    echo "<tr>";
				     	echo "<td><a href='editOnlineOrder/".$order->orderid."'>".$counter++."</a></td>";
				     	echo "<td>".$order->first_name."</td>";
				     	echo "<td>".$order->last_name."</td>";
				     	echo "<td>".$order->email."</td>";
				     	echo "<td>".$order->phone."</td>";
				     	echo "<td>".$order->address."</td>";
				     	echo "<td>".$order->person_reference."</td>";
				     	echo "<td>".$order->dateAdded."</td>";
				     	echo "<td>".$order->order_status."</td>";
					    echo "</tr>";
					    
					}
				}
				 
				echo "</table>";
				?>
		</div>
	</div>
	</form>
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
