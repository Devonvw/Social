<?php 
require __DIR__ . '/../model/Post.php';
require __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../DAL/Database.php';


    class FeedDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function GetFeed() {
        try{
            //if (!isset($_SESSION["id"])) throw new Exception("Not logged in");
              
            $stmt = $this->DB::$connection->prepare("SELECT posts.*, users.id as user_id, users.username, counter.likes, CASE WHEN post_likes_account.post_id THEN true else false END as liked FROM posts left join users on users.id = posts.account_id left join (SELECT * FROM post_likes WHERE account_id = :account_id) as post_likes_account on post_likes_account.post_id = posts.id left join (SELECT COUNT(post_id) as likes, post_id FROM post_likes GROUP BY post_id) as counter on counter.post_id = posts.id ORDER BY posts.created_at DESC;");
            $account_id_param = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;

            echo($account_id_param);

            $stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll();

            $posts = [];

            foreach ($data as $row) {
              array_push($posts, new Post($row['id'], $row['title'], $row['image_url'], $row['description'], $row['likes'], $row['liked'], new User($row['id'], $row['username'])));
            }

            //$posts = $stmt->fetchAll(PDO::FETCH_CLASS, "Post");
            return $posts;
            
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

        function LikeUnlikePost($postId) {
          try{
              session_start();

              if (!isset($_SESSION["id"])) return;

              $account_id_param = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;

              $select_stmt = $this->DB::$connection->prepare("SELECT * FROM post_likes WHERE post_id = :post_id AND account_id = :account_id");
              $select_stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
              $select_stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);

              $select_stmt->execute();
              if($select_stmt->fetchColumn() > 0){
                $del_stmt = $this->DB::$connection->prepare("DELETE FROM post_likes WHERE post_id = :post_id AND account_id = :account_id");
                $del_stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
                $del_stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
                $del_stmt->execute();
              } else{
                $insert_stmt = $this->DB::$connection->prepare("INSERT INTO post_likes (post_id, account_id) VALUES (:post_id, :account_id)");
                $insert_stmt->bindValue(':post_id', $postId, PDO::PARAM_INT);
                $insert_stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
                $insert_stmt->execute();
              }

          } catch (Exception $ex) {
              echo "$ex";
              throw new Exception($ex);
          }
        }
     }
?>