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
	<div id="addBatch">
		<h2 style="text-align:center">New Batch</h2>
		<form id="createNewBatchForm" method="post" action="createNewBatch">
			<h4>Raw Material</h4>
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
				</tr>
			</table>
			<h4>Group Information</h4>
			<select name="groupid" style="width:175px;">
				<option value=''>select</option>
			<?php foreach($utana_groups as $utana_group){
				echo "<option value='".$utana_group->ug_id."'>".$utana_group->ug_name."</option>";
				}
          	 ?>
          	 </select>
		</div>
		<button type="submit" id="btn" style="margin-left:30%;">Create</button>
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
