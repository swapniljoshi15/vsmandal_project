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
	<div id="">
		<h2 style="text-align:center">Delete Utana Group</h2>
		<form id="deleteUtanaGroupForm" method="post" action="<?php echo $utanaGroup->ug_id; ?>">
			<table>
				<tr>
					<td>Group Name</td>
					<td><input type="textbox" name="ugname" value="<?php echo $utanaGroup->ug_name; ?>" disabled="disabled"></td>
				</tr>
				<tr>
					<td>Group Address</td>
					<td>
						<textarea name="ugaddress" rows="4" cols="50" disabled="disabled">
						<?php echo $utanaGroup->ug_address; ?>
						</textarea>
					</td>
				</tr>
				<tr>
					<td>Contact Name</td>
					<td><input type="textbox" name="ugcontactname" value="<?php echo $utanaGroup->ug_contact_name; ?>" disabled="disabled"></td>
				</tr>
				<tr>
					<td>Contact Phone</td>
					<td><input type="textbox" name="ugcontactno" value="<?php echo $utanaGroup->ug_contact_phone; ?>" disabled="disabled"></td>
				</tr>
				<tr>
					<td>Group Status</td>
					<td>
						<select name="groupStatus" style="width:175px;" disabled="disabled">
							<?php 
							$selectedActive = '';
							$selectedDeactive = '';
							if($utanaGroup->ug_active == 1)$selectedActive="selected='true'";
							if($utanaGroup->ug_active == 0)$selectedDeactive="selected='true'";
							?>
		          		 	<option value="1" <?php echo $selectedActive;?>>Active</option>
		          		 	<option value="0" <?php echo $selectedDeactive;?>>Deactive</option>
	         			 </select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" id="btn">Delete</button>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div id="element"><?php echo $message;?></div>
					</td>
				</tr>
			</table>
			<input type="hidden" name="confirm" value="yes" /> 
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
