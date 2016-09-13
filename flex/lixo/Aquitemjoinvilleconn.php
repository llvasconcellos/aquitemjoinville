<?php
/**
 * connection settings
 * replace with your own hostname, database, username and password 
 */
$hostname_conn = "localhost";
$database_conn = "aquitem_db";
$username_conn = "aquitem_user";
$password_conn = "zb3T)i>n}YC6";
$conn = mysql_pconnect($hostname_conn, $username_conn, $password_conn) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_conn, $conn);
mysql_query("SET NAMES 'utf8'");
?>