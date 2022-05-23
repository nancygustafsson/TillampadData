<?php

function setMessages($conn) {                  // Funktionen returnerar ett värde om knappen trycks på och värdet är inte NULL, isset funktionen kollar om variablen är tom
    if (isset($_POST['commentSubmit'])){
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '$message')"; 
        $result = $conn->query($sql); // Värdena sätts in i tabellen och skickas in i databasen
    }
}

function getMessages($conn) {                   // Denna funktion får meddelandena från databasen
    $sql = "SELECT * FROM comments";
    $result = $conn->query($sql);         

    while ($row = $result->fetch_assoc()) {     // While loopen kör igenom varje rad och returnerar varje värde som läggs in
        echo "<div class='comment-box'><p>";
            echo $row['uid']."<br>";
            echo $row['date']."<br>";
            echo nl2br($row['message']);


        // Raderar kommentarerna
        echo "</p>                               
            <form class='delete-form' method='POST' action='".deleteMessages($conn)."'> 
                <input type='hidden' name='cid' value='".$row['cid']."'>
                
                <button type='submit' name='commentDelete'>Radera</button>
            </form>
        </div>";                                     
    } 
}

function deleteMessages($conn) {               // Denna funktion raderar kommentarerna om radera-knappen trycks på
    if (isset($_POST['commentDelete'])){
        $cid = $_POST['cid'];

        $sql = "DELETE FROM comments WHERE cid='$cid'";
        $result = $conn->query($sql);
        header ("Location: forum.php");
    }
}