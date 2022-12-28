<?php
// Include config file
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        if($stmt = $connection->prepare("SELECT id FROM users WHERE username = :username")){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', trim(htmlspecialchars($_POST["username"])));            
            // Set parameters
            // Attempt to execute the prepared statement
            try{
                if($stmt->fetchColumn() > 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } catch (Exception $ex) {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err)){
        if($stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (:username, :password)")){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':username', trim(htmlspecialchars($_POST["username"])));            
            $stmt->bindParam(':password', password_hash(trim(htmlspecialchars($_POST["password"])),PASSWORD_DEFAULT));            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

        }
    }
}
?>