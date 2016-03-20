	<!DOCTYPE html>
<html>
 <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/respect.css" />
<head>

<title>T-Care Homecare Dublin</title>
<div id ="header"style="height: 155px;
 padding: 0; text-align: center;
background:green; margin-left:30px;color: #D4E6F4; clear :both; height: margin-right:30px; padding: 1em; font-size:bold ; width:1200px"}/>

<nav class="top-bar"style="background:#D4E6F4;">
<h4 style="color: white;"></h4>

<ul class="title_area">
<li class="name"style="background: #D4E6F4;"><h5><a href="#"style="color:black; background:font-style:italic;font-size:20px;font-weight:bold">T-Care Homecare Dublin</a></h5></li>
<h6 style="color:black;text-align:center;font size:15px;font-style:italic;"></h6>
 
<li class="toggle-topbar menu icon"><a href="#"><span>menu</span></a></li>
</ul>
<section class="top-bar-section"style="margin-left:70px;margin-right:70px;">
<ul class="left">
<li class="divider"></li>
<li class="active"><a href="edit_admin_account.php"style="color:green;background:white;">Edit My Account</a></li>
<li class="divider"></li>
<li class="active"><a href="admin_manage_patients.php"style="color:green;background:white;">Manage Patients</a></li>
<li class="divider"></li>
<li class="active"><a href="admin_manage_carers.php"style="color:green;background:white;">Manage Carers</a></li>
<li class="divider"></li>
<li class="active"><a href="admin_manage_schedule.php"style="color:green;background:white;">Manage Schedule</a></li>
<li class="divider"></li>
<li class="active"><a href="manage_admin_users.php"style="color:green;background:white;">Manage Admin Users</a></li>
<li class="divider"></li>
<li class="active"><a href="admin_reports.php"style="color:green;background:white;">Admin Reports</a></li>
<li class="divider"></li>
<li class="active"><a href="admin_logout.php"style="color:green;background:white;">Log Out</a></li>
<li class="divider"></li>
</ul>
</section>
</nav>
  
 </head>  
  <body style="background:white;">
<h5  style="background:black;color:white;font-style:italic;margin-top:80px"></h5>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="foundation.css" />
 
    
  </body>
</html><br />
<body style="background:#FFFAF0;">

       <div class="admin" style="text-align:center; margin-top:25px;margin-left:400px;margin-right:400px">

<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: home4_care.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to home4_care.php"); 
    } 
     
    // Everything below this point in the file is secured by the login system 
     
    // We can retrieve a list of members from the database using a SELECT query. 
    // In this case we do not have a WHERE clause because we want to select all 
    // of the rows from the database table. 
    $query = " 
        select Concat(C.FirstName, ' ', C.LastName) as carername, 
		H.carerholidayid, H.CarerID, H.datefrom, H.dateto, H.noofdays
 		from tblcarerholiday H
		inner join tblcarer C 
		on H.CarerID = C.CarerID
 		where approvedbyadminid >0 and datefrom > CURDATE() order by datefrom";
     
    try 
    { 
        // These two statements run the query against your database table. 
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    } 
         
    // Finally, we can retrieve all of the found rows into an array using fetchAll 
    $rows = $stmt->fetchAll(); 

    $i = 0;
?> 
<h1>View Approved Carer Holidays</h1> <br>
<a href=admin_manage_carers.php> Manage Carers</a>  |   | <a href=admin_approve_holidays.php>Approve Carer Holidays</a>
<table> 
    <tr> 
	<th>No</th>
        <th>Carer Name</th> 
        <th>Date From</th> 
	<th>Date To</th> 
        <th>No Of Days</th>
    </tr> 
    <?php foreach($rows as $row): $i = $i + 1;?> 
        <tr> 
            <td><?php echo $i; ?></td> <!-- htmlentities is not needed here because $row['id'] is always an integer --> 
            <td><?php echo htmlentities($row['carername'], ENT_QUOTES, 'UTF-8'); ?></td> 
            <td><?php echo htmlentities($row['datefrom'], ENT_QUOTES, 'UTF-8'); ?></td> 
            <td><?php echo htmlentities($row['dateto'], ENT_QUOTES, 'UTF-8'); ?></td> 
            <td><?php echo htmlentities($row['noofdays'], ENT_QUOTES, 'UTF-8'); ?></td> 
     
        </tr> 
    <?php endforeach; ?> 
</table> 