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
			<li id="current"><a href="">Raw Material Management</a></li>
			<li ><a href="">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="addBatch">
		<h2 style="text-align:center">Open Raw Material</h2>
		<h3>Batch Id =			  <?php echo $batchId; ?><?php ?></h3>
		<form id="openRawMaterialForm" method="post" action="">
			<h4>Raw Material </h4>
			
			<div id="table">
			<?php
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='materialname'>Material Name</td>";
		     	echo "<td id='materialquantity'>Material Quantity</td>";
		     	echo "<td id='materialunit'>Material Unit</td>";
			    echo "</tr>"; 
                            $counter = 0;				

				foreach($batchRawMaterials as $batchRawMaterial){
				    echo "<tr>";
			     	echo "<td>".$batchRawMaterial->rawmaterialname."</td>";
			     	echo "<td>".$batchRawMaterial->rawmaterialquantity."</td>";
			     	//echo "<td>".$rawMaterials[$batchRawMaterial->rawmaterialid - 1]->material_unit."</td>";
		     	 	echo "<td>".$rawMaterials[$counter]->material_unit."</td>";
                                echo "</tr>";
                                $counter++;
				}
				 
				?>
				<tr>
				</tr>
			</table>
		</div>
		<div id="element"><?php echo $message;?></div>
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
