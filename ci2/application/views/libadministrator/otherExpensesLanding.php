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
    	#listotherexpenses{
			padding-top:2%;
			padding-left:2%;
		}
		#odesc{
			width:150px;
		}
		#oexpamnt{
			width:75px;
		}
		#oadddate{
			width:75px;
		}
		#oaddby{
			width:75px;
		}
		#oeditdate{
			width:75px;
		}
		#oeditby{
			width:150px;
		}
		#oaction{
			width:75px;
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
			<li><a href="../bm/index">Batch Management</a></li>
			<li><a href="../ob/placedOrders">Placed Order</a></li>
			<li id="current"><a href="../oe/index">Expenses</a></li>
		</ul>
	<!-- navigation ends-->	
	</div>					
			
	<!-- content starts -->
	<div id="buttonContainer">
	<form 
		name="addOtherExpensesButtonForm"
		method="get"
		action="addOtherExpenses"
		style="margin:0;padding:0px 0px 0px 0px;border:0px 0px 0px 0px;background:NONE; ">
		<div class="addOtherExpenses">
			<button type="submit" id="btn" onclick="">Add Other Expenses</button>
		</div>
	</form>
	</div>
	<div id="listotherexpenses">
		<div id="table">
			<?php
				$counter = 1;
				$totalExpense = 0;
				 
				echo "<table border='1'>";
				 echo "<tr>";
		     	echo "<td id='ono'>No</td>";
		     	echo "<td id='odesc'>Expense Description</td>";
		     	echo "<td id='oexpamnt'>Expense Amount</td>";
		     	echo "<td id='oadddate'>Addition date</td>";
		     	echo "<td id='oaddby'>Added By</td>";
		     	echo "<td id='oeditdate'>Edited Date</td>";
		     	echo "<td id='oeditby'>Edited By</td>";
		     	echo "<td id='oaction'>Action</td>";
			    echo "</tr>"; 
				
				if($otherExpenses != NULL){
					foreach($otherExpenses as $otherExpense){
					      
					   if($otherExpense != NULL && $otherExpense->ostatus == 1){
					   	 echo "<tr>";
				     	echo "<td>".$counter++."</td>";
				     	echo "<td>".$otherExpense->odescription."</td>";
				     	echo "<td>".$otherExpense->oamount."</td>";
				     	echo "<td>".$otherExpense->oaddeddate."</td>";
				     	echo "<td>".$otherExpense->oaddedby."</td>";
				     	echo "<td>".$otherExpense->oeditedate."</td>";
				     	echo "<td>".$otherExpense->oeditedby."</td>";
				     	echo "<td><a href='editOtherExpenses/".$otherExpense->oid."'>Edit</a><br/><a href='removeOtherExpenses/".$otherExpense->oid."'>Delete</a></td>";
				     	echo "</tr>";
				     	$totalExpense = $totalExpense + $otherExpense->oamount;
					   }
					    
					}
				}
				?>
				</table>
				<table  border='1' style="padding-top:2%;padding-bottom:2%;text-align:CENTER;">
				<tr>
				<td>
				<h3 style="font:bold;color:GREEN;">Total Expenses = <?php echo $totalExpense;?>Rs</h3>
				</td>
				</tr>
				</table>
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
