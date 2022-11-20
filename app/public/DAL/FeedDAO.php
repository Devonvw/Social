<?php 
require_once("model/Post.php");
require_once("DAL/Database.php");

    class PostDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function CreateNewPost($title, $imgUrl ,$description) {
        try{
            $stmt = $this->DB::$connection->prepare("INSERT INTO posts (title, image_url, description, account_id) VALUES (:title, :image_url, :description, :account_id)");
            
            session_start();

            if (!isset($_SESSION["id"])) throw new Exception("Not logged in");
            
            $title_param = trim(htmlspecialchars($title));
            $image_url_param = trim(htmlspecialchars($imgUrl));
            $description_param = trim(htmlspecialchars($description));
            $account_id_param = trim(htmlspecialchars($_SESSION["id"]));

            $stmt->bindValue(':title', $title_param, PDO::PARAM_STR);
            $stmt->bindValue(':image_url', $image_url_param, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description_param, PDO::PARAM_STR);
            $stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $ex) {
            echo "$ex";
            throw new Exception($ex);
        }
       }
     }
?>