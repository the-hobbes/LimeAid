<?php

$connectId = mysql_connect("webdb.uvm.edu","helpline_admin","7iC6BbZhUEwUs9st");
if (!$connectId)
  {
  	die('Could not connect: ' . mysql_error());
  }
mysql_select_db("HELPLINE_Limeaid", $connectId);

?>