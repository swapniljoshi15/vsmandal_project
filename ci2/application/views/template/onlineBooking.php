<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->

<head>
	 <title>Utana Project</title>
	 
	 <!-- Load stylesheets for login_template-->
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/login_form.css'; ?>">
	
	<!-- Load stylesheets for general_template-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/screen.css'; ?>">
	<!-- // Load stylesheets -->
	
	
	 <style>
    	input[type="radio"] {
		    margin-left:50px;
		}
		input[type="textbox"] {
		    margin-left:50px;
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
		tr {
			height: 0px;
			background: #fff;
		}
		td {
			padding-left: 0px;
			padding-right: 0px;
			border: 1px solid #E7F0CC;	
		}	
		#onlineBooking{
			padding-top:3%;
			padding-left:2%;
		}
		#element{
			padding-top:3%;	
		 	padding-left:40%;	
		}
		div#recaptcha_image > img{
			height:46px;
			width:240px;
		}
		iframe{
			margin: 0;
			padding: 0;
			border: 0;
			outline: 0;
			font-weight: NONE;
			font-style: NONE;
			font-size: 100%;
			font-family: NONE;
			vertical-align: baseline;
			background: transparent;
		}
		#trid{
			text-align:center;
		}
		#tdid{
			text-align:center;
			padding-top:20px;
			width:5%;
		}
    </style>
	
	
	
</head>

<body>

<!-- wrap starts here -->
<div id="wrap">

	<!--header -->
	<div id="header">			
				
		<h1 id="logo-text"><a href="index.html" title="">Utana Project</a></h1>		
		<p id="slogan">Utana Project</p>			
				
	<!--header ends-->					
	</div>
		
	<!-- navigation starts-->	
	<div  id="nav">
		<ul>
			<li ><a href="../auth/login">Home</a></li>
			<li id="current"><a href="">Online Booking</a></li>
			<li><a href="../otherinfo/contactLanding">Contact</a></li>
			<li><a href="../otherinfo/aboutLanding">About</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<div id="onlineBooking">
		<h2 style="text-align:center">Online Booking</h2>
		<form id="onlineBookingForm" method="post" action="placeOnlineOrder">
			<table border='1'>
				<tr id="trid">
				<td id="tdid">First Name</td>
				<td style="text-align:center;padding-top:20px;"><input type="text" name="firstname" style="width:250px;"/></td>
				</tr>
				<tr id="trid">
				<td id="tdid">Last Name</td>
				<td id="tdid"><input type="text" name="lastname" style="width:250px;"/></td>
				</tr>
				<tr id="trid">
				<td id="tdid">Email</td>
				<td id="tdid"><input type="text" name="email" style="width:250px;"/></td>
				</tr>
				<tr id="trid">
				<td id="tdid">Phone Number with extension</td>
				<td id="tdid"><input type="text" name="phoneno" style="width:250px;"/></td>
				</tr>
				<tr id="trid">
				<td id="tdid">Address</td>
				<td id="tdid">
				<textarea rows="4" cols="8" name="address" style="width:400px;">
				</textarea>
				</td>
				</tr>
				<tr id="trid">
				<td id="tdid">Reference Name</td>
				<td id="tdid"><input type="text" name="refname" style="width:400px;"/></td>
				</tr>
			</table>
			
			<div id="table">
			<?php
				$cols = 3;// define number of columns
				 
				echo "<table border='1'>";
				 echo "<tr id='trid'>";
		     	echo "<td id='tdid'>Packet Name</td>";
		     	echo "<td id='tdid'>Packet Weight</td>";
		     	echo "<td id='tdid'>packets want to purchase</td>";
			    echo "</tr>"; 
				
				foreach($packets as $packet){
				    echo "<tr id='trid'>";
			     	echo "<td id='tdid'>".$packet->packet_name."</td>";
			     	echo "<td id='tdid'>".$packet->packet_quantity." ".$packet->packet_unit."</td>";
			     	echo "<td id='tdid'><input type='text' name='".$packet->packet_id."' value='0'/></td>";
		     	 	echo "</tr>";
				}
				 
				?>
				<tr>
				</tr>
			</table>
			<div style="padding-left:35%;">
					<?php 
						 require_once('application/third_party/recaptchalib.php');
						  //$publickey = "6Lf8D_ESAAAAAC2432j0Lawf23Dg8igRar7mdrQW"; // you got this from the signup page
                                                    $publickey = "6LdsVvESAAAAAP6u9C73H7Un85j-2jkxwEKL2UAK"; // you got this from the signup page
						  echo recaptcha_get_html($publickey);
					?>
			</div>
		
		<button type="submit" id="btn" style="margin-left:30%;">Place Order</button>
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
