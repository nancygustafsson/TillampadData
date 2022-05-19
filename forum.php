<?php
$page_title = "Startsida";
include("includes/header.php");
date_default_timezone_set('Europe/Stockholm');
include 'dbh.inc.php';                          
include 'comments.inc.php';
?>


<div id="container4">
<div id="forumSida">
<br><br><h1> Forum för tankar kring jämställdhet </h1>
<h3> Här kan du skriva om dina åsikter och tankar:</h3>
<h4> Tankarna kan vara om samhällets jämlikhet, privata upplevelser eller kring statistiken på vår hemsida</h4>

<!-- Use the setMessages function and make the boxes where you can write in your name and the message -->

<?php


echo "<form method='POST' ".setMessages($conn).">
        <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
        Namn:<br>
        <textarea name='uid'></textarea><br>
        Kommentar:<br>
        <textarea name='message'></textarea><br>
        <button type='submit' name='commentSubmit'>Dela</button><br>
        <h3>Inlägg: </h3>
      </form>";

getMessages($conn);

?>
</div>
</div>
</body>

</html>