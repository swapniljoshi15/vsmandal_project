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
			<li id="current"><a href="">Batch Management</a></li>
			<li><a href="../../ob/placedOrders">Placed Order</a></li>
			<li><a href="../../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="addBatch">
		<h2 style="text-align:center">Edit Batch</h2>
		<h3>Batch Id =			  <?php echo $batch->id; ?></h3>
		<form id="editBatchForm" method="post" action="<?php echo $batch->id;?>">
			<h4>Raw Material</h4>
			<div id="table">
			<?php
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='materialname'>Material Name</td>";
		     	echo "<td id='materialquantity'>Material Quantity</td>";
		     	echo "<td id='materialunit'>Material Unit</td>";
		     	echo "<td id='materialunit'>Add/Subtract Material</td>";
		     	echo "<td id='materialavailability'>Total Availability</td>";
			    echo "</tr>"; 
				$counter = 0;
				foreach($rawMaterials as $rawMaterial){
				    echo "<tr>";
			     	echo "<td>".$rawMaterial->material_name."</td>";
			     	echo "<td>".$batchRawMaterials[$counter]->rawmaterialquantity."</td>";
			     	echo "<td>".$rawMaterial->material_unit."</td>";
			     	echo "<td><input type='text' name='".$rawMaterial->material_id."' value='0'/></td>";
			     	echo "<td>".$rawMaterial->material_quantity."</td>";
		     	 	echo "</tr>";
		     	 	$counter++;
				}
				 
				?>
				<tr>
				</tr>
			</table>
			<h4>Group Information</h4>
			<select name="groupid" style="width:175px;">
				<?php foreach ($utana_groups as $utana_group):?>
           			<?php
						$selected = '';
						if ($batch->groupid == $utana_group->ug_id) {
							$selected= "selected='true'";
						}
					?>
					<option value="<?php echo $utana_group->ug_id; ?>" <?php echo $selected; ?>><?php echo $utana_group->ug_name;?></option>
	         	 <?php endforeach?>
         	 </select>
         	 <br/><br/>
         	 <h4>Packet Information</h4>
         	 <div id="">
			<?php
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='materialname'>Packet Name</td>";
		     	echo "<td id='materialquantity'>Packet Quantity</td>";
		     	echo "<td id='materialquantity'>Packet Unit</td>";
		     	echo "<td id='materialquantity'>Add/Subtract packets</td>";
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
				     	echo "<td><input type='text' name='packet".$info->packetid."' value='0'/></td>";
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
         	 <h4>Batch Status</h4>
         	 <select name="status">
         	 <?php 
         	 	$selectcreated = '';
         	 	$selectinprogress = '';
         	 	$selectcompleted = '';
         	 	if(strtolower($batch->status) == 'created')$selectcreated = "selected='true'";
         	 	if(strtolower($batch->status) == 'inprogress')$selectinprogress = "selected='true'";
         	 	if(strtolower($batch->status) == 'completed')$selectcompleted = "selected='true'";
         	 
         	 ?>
         	 	<option value="created" <?php echo $selectcreated;?>>Created</option>
         	 	<option value="inprogress" <?php echo $selectinprogress;?>>In Progress</option>
         	 	<option value="completed" <?php echo $selectcompleted;?>>Completed</option>
         	 </select>
		</div>
		<button type="submit" id="btn" style="margin-left:30%;">Edit</button>
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
