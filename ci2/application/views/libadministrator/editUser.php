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
		#searchForm{
			padding-top:30px;
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
			<li id="current"><a href="">User Management</a></li>
			<li><a href="../../rm/index">Raw Material Management</a></li>
			<li><a href="../../bm/index">Batch Management</a></li>
			<li><a href="../../ob/placedOrders">Placed Order</a></li>
			<li><a href="../../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
	
	<div id="">
		<h2 style="text-align:center">Edit User</h2>
		<form id="editUserForm" method="post" action="<?php echo $user->id;?>">
			<table>
				<tr>
					<td>Username/Mobile No</td>
					<td><input type="textbox" name="username" value="<?php echo $user->username; ?>"></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input type="textbox" name="email" value="<?php echo $user->email; ?>"></td>
				</tr>
				<tr>
					<td>Confirm email</td>
					<td><input type="textbox" name="confirmemail" value="<?php echo $user->email; ?>"></td>
				</tr>
				<tr>
					<td>Firstname</td>
					<td><input type="textbox" name="firstname" value="<?php echo $user->first_name; ?>"></td>
				</tr>
				<tr>
					<td>surname</td>
					<td><input type="textbox" name="surname" value="<?php echo $user->last_name; ?>"></td>
				</tr>
				<tr>
					<td>Library Id</td>
					<td><input type="textbox" name="libraryid" value="<?php echo $user->libraryid; ?>"></td>
				</tr>
				<tr>
					<td>Group</td>
					<td>
						<select name="group" style="width:175px;">
		          		 	<?php foreach ($groups as $group):?>
		          		 			<?php
										$gID=$group['id'];
										$selected = '';
										$item = null;
										foreach($currentGroups as $grp) {
											if ($gID == $grp->id) {
												$selected= "selected='true'";
											break;
											}
										}
									?>
			              		<option value="<?php echo $group['id']; ?>" <?php echo $selected; ?>><?php echo $group['name'];?></option>
				         	 <?php endforeach?>
	         			 </select>
					</td>
				</tr>
				<tr>
					<td>Address</td>
					<td>
						<textarea name="address" rows="4" cols="50">
						<?php echo $user->address; ?>
						</textarea>
					</td>
				</tr>
				<tr>
					<td>Account Status</td>
					<td>
						<select name="accountStatus" style="width:175px;">
							<?php 
							$selectedActive = '';
							$selectedDeactive = '';
							if($user->active == 1)$selectedActive="selected='true'";
							if($user->active == 0)$selectedDeactive="selected='true'";
							?>
		          		 	<option value="1" <?php echo $selectedActive;?>>Active</option>
		          		 	<option value="0" <?php echo $selectedDeactive;?>>Deactive</option>
	         			 </select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" id="btn">Edit</button>
					</td>
				</tr>
				<tr>
					<div id="element"><?php echo $message;?></div>
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
