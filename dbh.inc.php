<!-- Connecting to database-->
<?php

$conn = mysqli_connect('localhost','root', '', 'TillampadData');
//$conn = mysqli_connect('studentmysql.miun.se','nagu2000', 'thdkuk7k', 'nagu2000');

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());

}