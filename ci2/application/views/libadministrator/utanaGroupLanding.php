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
    	#table{
    		padding-left:2%;
    	}
    	#ug_no{
			width:25px;
		}
		#ug_name{
			width:100px;
		}
		#ug_address{
			width:250px;
		}
		#ug_contactname{
			width:150px;
		}
		#ug_contactphone{
			width:100px;
		}
		#ug_action{
			width:50px;
		}
		#ug_status{
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
			<li ><a href="../rm/index">Raw Material Management</a></li>
			<li id="current"><a href="">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="buttonContainer">
	<form 
		name="addUtanaGroupForm"
		method="get"
		action="addUtanaGroup"
		style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
		<div class="addUtanaGroup">
			<button type="submit" id="btn" onclick="">Add Utana Group</button>
		</div>
	</form>
	</div>
	
	<div id="listutanagroups">
		<div id="table">
			<?php
				$counter = 1;
				$cols = 5;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='ug_no'>No</td>";
		     	echo "<td id='ug_name'>Group Name</td>";
		     	echo "<td id='ug_address'>Group Address</td>";
		     	echo "<td id='ug_contactname'>Contact Name</td>";
		     	echo "<td id='ug_contactphone'>Contact Phone</td>";
		     	echo "<td id='ug_action'>Action</td>";
		     	echo "<td id='ug_status'>Status</td>";
			    echo "</tr>"; 
				
				foreach($utanaGroups as $utanaGroup){
				      
				    echo "<tr>";
			     	echo "<td>".$counter++."</td>";
			     	echo "<td>".$utanaGroup->ug_name."</td>";
			     	echo "<td>".$utanaGroup->ug_address."</td>";
			     	echo "<td>".$utanaGroup->ug_contact_name."</td>";
			     	echo "<td>".$utanaGroup->ug_contact_phone."</td>";
			     	echo "<td><a href='editUtanaGroup/".$utanaGroup->ug_id."'>Edit</a><br/><a href='removeUtanaGroup/".$utanaGroup->ug_id."'>Delete</a></td>";
				    if($utanaGroup->ug_active){
				    	echo "<td>Active</td>";
				    }
				    else{
				    	echo "<td>Inactive</td>";
				    }
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
