<?php
    // Get list of usernames
    require_once 'users.php';

    $username = htmlspecialchars(
        trim($_GET['user'])
    );

    foreach ($resArr as $user) {
        if (in_array($username, $user)) {
            echo '{
                "userexists": true,
                "message": "username taken"
            }';
            exit(0);
        }
    } 
    echo '{
        "userexists": false,
        "message": "username available"
    }';
?>