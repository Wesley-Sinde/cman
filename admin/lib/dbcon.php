<?php
//core
$conn;
$conn1;

function dbcon()
{
	global $conn;
	global $conn1;
	$user = "root";
	$pass = "";
	$host = "localhost";
	$db = "cman";
	$conn = mysqli_connect($host, $user, $pass, $db) or die('Cannot connect to the databse.');
	$conn1 = mysqli_connect($host, $user, $pass, $db) or die('Cannot connect to the databse.');
}

function host()
{
	$h = "http://" . $_SERVER['HTTP_HOST'] . "/bankdb/";
	return $h;
}

function hRoot()
{
	$url = $_SERVER['DOCUMENT_ROOT'] . "/bankdb/";
	return $url;
}

//parse string
function gstr()
{
	$qstr = $_SERVER['QUERY_STRING'];
	parse_str($qstr, $dstr);
	return $dstr;
}
