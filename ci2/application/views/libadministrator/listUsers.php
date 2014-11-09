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
		#createUser{
			padding-top:30px;
			padding-left:60%;
		}
		#listusers{
			padding-top:10px;
			padding-left:50px;
		}
		td{
			width:100px;
		}
		#element{
			padding-top:3%;	
		 	padding-left:40%;	
		}
	</style>
	
	<script>
	</script>
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
			<li id="current"><a href="">User Management</a></li>
			<li><a href="../rm/index">Raw Material Management</a></li>
			<li><a href="../bm/index">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
	
	<form method="post" action="createNewUser">
	<div id="createUser">
		<button type="submit" id="btn" onclick="">Create New User</button>
	</div>
	
	<div id="listusers">
		<div id="table">
			<?php
				$counter = 1;
				$cols = 7;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td>No</td>";
		     	echo "<td>Userid/Mobile No</td>";
		     	echo "<td>Firstname</td>";
		     	echo "<td>Lastname</td>";
		     	echo "<td>Address</td>";
		     	echo "<td>Library Id</td>";
		     	echo "<td>Status</td>";
			    echo "</tr>"; 
				
				foreach($rows as $row){
				      
				    echo "<tr>";
			     	echo "<td><a href='userProfile/".$row['user_id']."'>".$counter++."</a></td>";
			     	echo "<td>".$row['username']."</td>";
			     	echo "<td>".$row['firstname']."</td>";
			     	echo "<td>".$row['lastname']."</td>";
			     	echo "<td>".$row['address']."</td>";
			     	echo "<td>".$row['libraryid']."</td>";
					 if($row['status']){
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
	</form>
		
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
