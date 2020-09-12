<?php

     
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include '_dbconnect.php';
        echo "Ramjan baa na poda";
        $showError = "false" ;
        $user_email = $_POST['signupEmail'];
        $pass = $_POST['signupPassword'];
        $cpass = $_POST['signupcPassword'];
    

    // check whether if this email exists or not 

    $existSql = "select * from `users` where user_email = 'user_email'";
    $result = mysqli_query($conn , $existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows > 0)
    {
        $showError = "Email is already registered";
         

    }
    else
    {
        if($pass == $cpass)
        {
            $hash  = password_hash($pass , PASSWORD_DEFAULT );
            $sql = "INSERT INTO `users` ( `user_email`, `user_pass`, `timestamp`) 
            VALUES ( '$user_email', '$hash', current_timestamp())";

            $result = mysqli_query($conn , $sql);
            if($result)
            {
                $showAlert = true ; 
               header("Location: /forum/index.php?signupsuccess=true");
               exit();

            }

        }
        else
        {
            $showError = "Passwords do not match" ; 
            header("Location: /forum/index.php?signupsuccess=false&error=$showError");


        }
        header("Location: /forum/index.php?signupsuccess=false&error=$showError");

    }


}


?>