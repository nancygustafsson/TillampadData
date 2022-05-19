<?php

function setMessages($conn) {                  // This function return value if the button is pressed and the variabel is not NULL, the isset function checks whether a variable is empty
    if (isset($_POST['commentSubmit'])){
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '$message')"; 
        $result = $conn->query($sql); // The values ​​are inserted in the tables and puts in to the database
    }
}

function getMessages($conn) {                   // This function gets the messages from the database
    $sql = "SELECT * FROM comments";
    $result = $conn->query($sql);         

    while ($row = $result->fetch_assoc()) {     // The while loop runs through all the lines and then return the values that the user putted in
        echo "<div class='comment-box'><p>";
            echo $row['uid']."<br>";
            echo $row['date']."<br>";
            echo nl2br($row['message']);


        // Delete the comments
        echo "</p>                               
            <form class='delete-form' method='POST' action='".deleteMessages($conn)."'> 
                <input type='hidden' name='cid' value='".$row['cid']."'>
                
                <button type='submit' name='commentDelete'>Radera</button>
            </form>
        </div>";                                     
    } 
}

function deleteMessages($conn) {               // This function delete the comments if the button is pressed
    if (isset($_POST['commentDelete'])){
        $cid = $_POST['cid'];

        $sql = "DELETE FROM comments WHERE cid='$cid'";
        $result = $conn->query($sql);
        header ("Location: index.php");
    }
}