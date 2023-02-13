<?php
    session_start();
  # Clean input data for storage and security purposes
    function clean_input($input) {
        return htmlspecialchars(
            stripslashes(trim($input))
      );
    }
?>

<?php
    // Database connection
    $con = new mysqli("localhost", "root", "", "notes");
    if ($con->connect_error) exit(0);

    // real_escape_string used to prevent SQL injection attack
    $user = mysqli_real_escape_string(
      $con, filter_var(
        clean_input($_POST['user']), FILTER_SANITIZE_EMAIL
      )
    );
    $password = mysqli_real_escape_string(
      $con, trim($_POST['password'])
    );

    if ($_POST['form'] == 'login-form') {
    # Validate login credentials

    // Query and execution
    $q1 = "SELECT apassword FROM author WHERE aname = '$user'";
    $res = $con->query($q1);

    // Check the presence of existing user for entered user
    if ($res->num_rows == 1) {
        $corr_pass = $res->fetch_assoc()["apassword"];
        // Match entered password with stored password
        if ($password === $corr_pass) {
            $_SESSION['user'] = $user;
            $_SESSION['logged'] = TRUE;
            echo "success";  
        } else {
            echo "invalid password";
        }
    } else {
        echo "user does not exist";
    }
  }

  elseif ($_POST['form'] == 'signup-form') {
    # Validate signup details and store in database

    // Queries
    $q1 = "SELECT * FROM author WHERE aname = '$user'";
    $q2 = "INSERT INTO author VALUES ('$user', '$password')";
    $check = $con->query($q1);

    // Check the presence of existing user for entered username
    if ($check->num_rows == 0) {
      if ($con->query($q2) === TRUE) {
        echo "success";
      } else {
        echo "Signup failed";
      }
    } else {
      echo "user with entered username already exists";
    }
  }

  $con -> close();
?>