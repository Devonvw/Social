<?php 
require_once("model/User.php");
require_once("DAL/Database.php");

    class UserDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function LogoutUser() {
          if (isset($_SESSION["loggedin"]))
            session_destroy();
       }

       function LoginUser($username, $password) {
        if(empty(trim($username))){
            throw new Exception("Please enter a username.");
        }

        try{
            $stmt = $this->DB::$connection->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $username_param = trim(htmlspecialchars($username));
            $stmt->bindValue(':username', $username_param, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetchObject("User");

            if(password_verify($password, $user->password)){
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user->id;
                $_SESSION["username"] = $user->username;                            
                
                // Redirect user to welcome page
                header("location: index.php");
            } else throw new Exception("Password is not correct");
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
       }

       function CreateUser($username, $password) {
        if(empty(trim($username))){
            throw new Exception("Please enter a username.");
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
            throw new Exception("Username can only contain letters, numbers, and underscores.");
        } else{
            // Prepare a select statement
            if($stmt = $this->DB::$connection->prepare("SELECT id FROM users WHERE username = :username")){
                // Bind variables to the prepared statement as parameters
                $username_param = trim(htmlspecialchars($username));
                $stmt->bindParam(':username', $username_param);            
                // Set parameters
                // Attempt to execute the prepared statement
                try{
                    if($stmt->fetchColumn() > 1){
                        throw new Exception("This username is already taken.");
                    } else{
                        $username = trim($username);
                    }
                } catch (Exception $ex) {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
        }
        
        // Validate password
        if(empty(trim($password))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($password)) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($password);
        }
        
        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err)){
            if($stmt = $this->DB::$connection->prepare("INSERT INTO users (username, password) VALUES (:username, :password)")){
                // Bind variables to the prepared statement as parameters
                $username_param = trim(htmlspecialchars($username));
                $password_param = password_hash(trim(htmlspecialchars($password)),PASSWORD_DEFAULT);
                
                $stmt->bindParam(':username', $username_param);            
                $stmt->bindParam(':password', $password_param);            
                
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
     }
?>