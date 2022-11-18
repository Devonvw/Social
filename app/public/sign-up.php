<?php 
require_once "conf/config.php";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$databasename",$username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
}

//include 'controller/sign-up.php'

$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        if($stmt = $connection->prepare("SELECT id FROM users WHERE username = :username")){
            // Bind variables to the prepared statement as parameters
            $username_param = trim(htmlspecialchars($_POST["username"]));
            $stmt->bindParam(':username', $username_param);            
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
            $username_param = trim(htmlspecialchars($_POST["username"]));
            $password_param = password_hash(trim(htmlspecialchars($_POST["password"])),PASSWORD_DEFAULT);
            
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
else { ?>
<script src="https://cdn.tailwindcss.com"></script>

<html>

<body>
    <div class="">
        <?php include 'components/nav.php' ?>
        <div class="h-[80vh] flex justify-center items-center mt-32">
            <div class="max-w-xl">
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-xl xl:p-0 dark:bg-teal-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Create an account
                        </h1>
                        <form class="space-y-4 md:space-y-6" method="post">
                            <div>
                                <label for="username"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    username</label>
                                <input type="text" name="username" id="username"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="..." required="">
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-50 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required="">
                            </div>
                            <button type="submit"
                                class="w-full text-white border border-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create
                                an account</button>
                            <p class="text-sm font-light text-gray-100">
                                Already have an account? <a href="login.php"
                                    class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login
                                    here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
}
<?php }
?>