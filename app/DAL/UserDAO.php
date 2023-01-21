<?php 
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Post.php';
require_once __DIR__ . '/../DAL/Database.php';

    class UserDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function logoutUser() {
          if (isset($_SESSION["loggedin"])){
            session_destroy();
          }
       }

       function loginUser($username, $password) {
        if(empty(trim($username))){
            throw new Exception("Please enter a username.", 1);
        }
        if(empty(trim($password))){
            throw new Exception("Please enter a password.", 1);
        }

        $stmt = $this->DB::$connection->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $username_param = trim(htmlspecialchars($username));
        $stmt->bindValue(':username', $username_param, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetchObject("User");

        if(!$user) throw new Exception("This user does not exist", 1);

        if(password_verify($password, $user->password)){

            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user->id;
            $_SESSION["username"] = $user->username;  

            session_write_close();
        } else throw new Exception("Password is not correct", 1);
       }

       function createUser($username, $password) {
        if(empty(trim($username))){
            throw new Exception("Please enter a username", 1);
        } 
        
        if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
            throw new Exception("Username can only contain letters, numbers, and underscores", 1);
        } 

        if($stmt = $this->DB::$connection->prepare("SELECT id FROM users WHERE username = :username")){
            $username_param = trim(htmlspecialchars($username));
            $stmt->bindParam(':username', $username_param);  
            $stmt->execute();
            if($stmt->fetchColumn() > 1){
                throw new Exception("This username is already taken", 1);
            } 
        }
        
        // Validate password
        if(empty(trim($password))){
            throw new Exception("Please enter a password", 1);
        } 
        if(strlen(trim($password)) < 6){
            throw new Exception("Password must have atleast 6 characters", 1);
        } 
        
        if($stmt = $this->DB::$connection->prepare("INSERT INTO users (username, password) VALUES (:username, :password)")){
            $username_param = trim(htmlspecialchars($username));
            $password_param = password_hash(trim(htmlspecialchars($password)),PASSWORD_DEFAULT);
            
            $stmt->bindParam(':username', $username_param);            
            $stmt->bindParam(':password', $password_param);            
            
            $stmt->execute();
        }
       }

       function getMyPosts() {
        $stmt = $this->DB::$connection->prepare("SELECT posts.*, users.id as user_id, users.username, counter.likes, CASE WHEN post_likes_account.post_id THEN true else false END as liked, pco.comments FROM posts left join users on users.id = posts.account_id left join (SELECT * FROM post_likes WHERE account_id = :account_id) as post_likes_account on post_likes_account.post_id = posts.id left join (SELECT COUNT(post_id) as likes, post_id FROM post_likes GROUP BY post_id) as counter on counter.post_id = posts.id left join (select posts.id, replace(replace(JSON_ARRAYAGG(create_objects.object), '}\"', '}'), '\"{', '{') as comments from posts left join (select post_id, JSON_MERGE(JSON_OBJECTAGG('username', users.username), JSON_OBJECTAGG('comment', post_comment.comment)) as object from post_comment left join users on users.id = post_comment.account_id group by post_comment.id order by post_comment.created_at desc) as create_objects on posts.id = create_objects.post_id group by posts.id) as pco on pco.id = posts.id where users.id = :account_id ORDER BY posts.created_at DESC;");
        $account_id_param = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;

        $stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $posts = [];

        foreach ($data as $row) {
          array_push($posts, new Post($row['id'], $row['title'], $row['image_type'], base64_encode($row['image_data']), $row['description'], $row['likes'], $row['liked'], $row['created_at'], json_decode(stripslashes($row['comments'])), new User($row['id'], $row['username'])));
        }

        return $posts;
      }
     }
?>