<?php
//if( $_FILES['file']['name'] != "" )
//{
//   copy( $_FILES['file']['name'], "/tmp" ) or 
//           die( "Could not copy file!");
//}
//else
//{
//    die("No file specified!");
//}
var_dump($_POST);
var_dump($_FILES);
?>
<html>
<head>
<title>Uploading Complete</title>
</head>
<body>
<h2>Uploaded File Info:</h2>
<ul>

<li>Sent file: <?php echo $_FILES['file']['name'];  ?>
<li>File size: <?php echo $_FILES['file']['size'];  ?> bytes
<li>File type: <?php echo $_FILES['file']['type'];  ?>
<li>File type: <?php echo $_FILES['file']['error'];  ?>
</ul>
</body>
</html>
 
