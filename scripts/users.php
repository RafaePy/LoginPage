<?php
    $con = new mysqli("localhost", "root", "", "notes");
    if ($con->connect_error) exit(0);

    $res = $con->query("SELECT aname FROM author;");
    // Get array of usernames
    $resArr = $res->fetch_all(MYSQLI_NUM);
    $res -> free_result();
?>