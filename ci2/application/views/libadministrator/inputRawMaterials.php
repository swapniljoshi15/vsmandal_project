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
		#materialname{
			width:150px;
		}
		#materialquantity{
			width:200px;
		}
		#materialunit{
			width:100px;
		}
		#materialavailability{
			width:150px;
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
			<li ><a href="../rm/index">Raw Material Management</a></li>
			<li id="current"><a href="">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="listrawmaterials">
		<h2 style="text-align:center">Input Raw Material</h2>
		<form name="inputrawmaterial" method="post" action="../rm/inputRawMaterialAvailability">
		<div id="table">
			<?php
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='materialname'>Material Name</td>";
		     	echo "<td id='materialquantity'>Material Quantity</td>";
		     	echo "<td id='materialunit'>Material Unit</td>";
		     	echo "<td id='materialavailability'>Total Availability</td>";
			    echo "</tr>"; 
				
				foreach($rawMaterials as $rawMaterial){
				    echo "<tr>";
			     	echo "<td>".$rawMaterial->material_name."</td>";
			     	echo "<td><input type='text' name='".$rawMaterial->material_id."' value='0'/></td>";
			     	echo "<td>".$rawMaterial->material_unit."</td>";
			     	echo "<td>".$rawMaterial->material_quantity."</td>";
		     	 	echo "</tr>";
				}
				 
				?>
				<tr>
					<td></td>
					<td>
						<button type="submit" id="btn">Edit</button>
					</td>
					<td></td>
					<td></td>
				</tr>
			</table>
		</div>
		</form>
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
