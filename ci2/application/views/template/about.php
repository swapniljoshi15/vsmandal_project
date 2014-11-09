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

			<li><a href="../ob/onlineBooking">Online Booking</a></li>

			<li><a href="../otherinfo/contactLanding">Contact</a></li>

			<li  id="current"><a href="">About</a></li>

		</ul>

	<!-- navigation ends-->	

	</div>					

	<div>
		<h2 style="text-align:center;">About</h2>
	</div>		

	<div style:"padding-top:200px;">
	
		<div style="float:left;padding-right:30px;padding-left:30px;width:50%;padding-top:200px;border-right-style: solid;
    	border-width: 5px;border-top-style:solid;border-color:#79A325;">
			<div style="padding-bottom:200px;font-size:20px;">This site is NGO ERP system which will be used to track NGO product.
								Site is <font color="red" size="22">Under Construction</font>.
						Thank You.
			</div>
		</div>
		
		<div style="float:right;width:50%;border-left-style: solid;border-top-style:solid;
    border-width: 5px;border-color:#79A325;">
    
    	
    	
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

