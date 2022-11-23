<?php 
require_once("model/Post.php");
require_once("DAL/Database.php");

    class FeedDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function GetFeed() {
        try{
            session_start();

            if (!isset($_SESSION["id"])) throw new Exception("Not logged in");
              
            $stmt = $this->DB::$connection->prepare("SELECT posts.*, counter.likes, CASE WHEN post_likes_account.post_id THEN true else false END as liked FROM posts left join (SELECT * FROM post_likes WHERE account_id = :account_id) as post_likes_account on post_likes_account.post_id = posts.id left join (SELECT COUNT(post_id) as likes, post_id FROM post_likes GROUP BY post_id) as counter on counter.post_id = posts.id ORDER BY posts.created_at DESC;");
            $account_id_param = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;

            $stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_CLASS, "Post");
        } catch (Exception $ex) {
            echo "$ex";
            throw new Exception($ex);
        }
      }

       function CreateNewPost($title, $imgUrl ,$description) {
        try{
            session_start();

            if (!isset($_SESSION["id"])) throw new Exception("Not logged in");
              
            $stmt = $this->DB::$connection->prepare("INSERT INTO posts (title, image_url, description, account_id) VALUES (:title, :image_url, :description, :account_id)");
            
            $title_param = trim(htmlspecialchars($title));
            $image_url_param = trim(htmlspecialchars($imgUrl));
            $description_param = trim(htmlspecialchars($description));
            $account_id_param = trim(htmlspecialchars($_SESSION["id"]));

            $stmt->bindValue(':title', $title_param, PDO::PARAM_STR);
            $stmt->bindValue(':image_url', $image_url_param, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description_param, PDO::PARAM_STR);
            $stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $ex) {
            echo "$ex";
            throw new Exception($ex);
        }
      }

        function LikeUnlikePost($postId, $loading) {
          try{
              $loading = true;
              session_start();
  
              if (!isset($_SESSION["id"])) throw new Exception("Not logged in");

              $account_id_param = $_SESSION["id"];

              $select_stmt = $this->DB::$connection->prepare("SELECT post_likes WHERE post_id = :post_id AND WHERE account_id = :account_id");
              $select_stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
              $select_stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);

              if($select_stmt->fetchColumn() > 1){
                $del_stmt = $this->DB::$connection->prepare("DELETE FROM post_likes WHERE post_id = :post_id AND WHERE account_id = :account_id");
                $del_stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
                $del_stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
                $del_stmt->execute();
              } else{
                $insert_stmt = $this->DB::$connection->prepare("INSERT INTO post_likes (post_id, account_id) VALUES (:post_id, :account_id)");
                $insert_stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
                $insert_stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
                $insert_stmt->execute();
              }

              $loading = false;
          } catch (Exception $ex) {
              echo "$ex";
              throw new Exception($ex);
          }
        }
     }
?>