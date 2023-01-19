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
          $stmt = $this->DB::$connection->prepare("SELECT posts.*, users.id as user_id, users.username, counter.likes, CASE WHEN post_likes_account.post_id THEN true else false END as liked, pco.comments FROM posts left join users on users.id = posts.account_id left join (SELECT * FROM post_likes WHERE account_id = :account_id) as post_likes_account on post_likes_account.post_id = posts.id left join (SELECT COUNT(post_id) as likes, post_id FROM post_likes GROUP BY post_id) as counter on counter.post_id = posts.id left join (select posts.id, replace(replace(JSON_ARRAYAGG(create_objects.object), '}\"', '}'), '\"{', '{') as comments from posts left join (select post_id, JSON_MERGE(JSON_OBJECTAGG('username', users.username), JSON_OBJECTAGG('comment', post_comment.comment)) as object from post_comment left join users on users.id = post_comment.account_id group by post_comment.id) as create_objects on posts.id = create_objects.post_id group by posts.id) as pco on pco.id = posts.id ORDER BY posts.created_at DESC;");
          $account_id_param = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;

          $stmt->bindValue(':account_id', $account_id_param, PDO::PARAM_INT);
          $stmt->execute();
          $data = $stmt->fetchAll();

          $posts = [];

          foreach ($data as $row) {
            array_push($posts, new Post($row['id'], $row['title'], $row['image_url'], $row['description'], $row['likes'], $row['liked'], $row['created_at'], json_decode(stripslashes($row['comments'])), new User($row['id'], $row['username'])));
          }

          return $posts;
        }

        function GetPost($post_id) {
          if (!$post_id) throw new Exception("Please choose a post", 1);

          $stmt = $this->DB::$connection->prepare("SELECT posts.*, users.id as user_id, users.username FROM posts left join users on users.id = posts.account_id where posts.id = :post_id LIMIT 1;");

          $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
          $stmt->execute();

          $data = $stmt->fetch();

          if(!$data) {
            throw new Exception("This post doesn't exist", 1);
          } 

          return new Post($data['id'], $data['title'], $data['image_url'], $data['description'], null, null, null, null, new User($data['id'], $data['username']));
        }

       function CreateNewPost($title, $imgUrl, $description) {
          session_start();

          if (!isset($_SESSION["id"])) throw new Exception("Not logged in", 1);

          if (empty(trim($title))) throw new Exception("Please enter a title", 1);
          if (empty(trim($imgUrl))) throw new Exception("Please enter an image url", 1);
          if (empty(trim($description))) throw new Exception("Please enter a description", 1);

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
        }

        function EditPost($post_id, $title, $imgUrl, $description) {
          session_start();

          if (!isset($_SESSION["id"])) throw new Exception("Not logged in", 1);

          if (!$post_id) throw new Exception("Please choose a post", 1);
          if (empty(trim($title))) throw new Exception("Please enter a title", 1);
          if (empty(trim($imgUrl))) throw new Exception("Please enter an image url", 1);
          if (empty(trim($description))) throw new Exception("Please enter a description", 1);

          $select_stmt = $this->DB::$connection->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
          $select_stmt->bindValue(':id', $post_id, PDO::PARAM_INT);

          $select_stmt->execute();
          $post = $select_stmt->fetch();

          if(!$post){
            throw new Exception("This post doesn't exist", 1);
          } 

          if($post["account_id"] != $_SESSION["id"]){
            throw new Exception("This is not your post", 1);
          } 

          $stmt = $this->DB::$connection->prepare("UPDATE posts SET title = :title, image_url = :image_url, description = :description where id = :post_id");
          
          $title_param = trim(htmlspecialchars($title));
          $image_url_param = trim(htmlspecialchars($imgUrl));
          $description_param = trim(htmlspecialchars($description));
          $account_id_param = trim(htmlspecialchars($_SESSION["id"]));

          $stmt->bindValue(':title', $title_param, PDO::PARAM_STR);
          $stmt->bindValue(':image_url', $image_url_param, PDO::PARAM_STR);
          $stmt->bindValue(':description', $description_param, PDO::PARAM_STR);
          $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
          $stmt->execute();
        }

        function DeletePost($post_id) {
          if (!$post_id) throw new Exception("Choose a post", 1);
          if (!isset($_SESSION["id"])) throw new Exception("Not logged in", 1);

          $select_stmt = $this->DB::$connection->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
          $select_stmt->bindValue(':id', $post_id, PDO::PARAM_INT);

          $select_stmt->execute();
          $post = $select_stmt->fetch();

          if(!$post){
            throw new Exception("This post doesn't exist", 1);
          } 

          if($post["account_id"] != $_SESSION["id"]){
            throw new Exception("This is not your post", 1);
          } 

          //Delete all rows associated with this post
          $del_stmt = $this->DB::$connection->prepare("DELETE FROM post_likes where post_id = :post_id");
          $del_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
          $del_stmt->execute();

          $del_stmt = $this->DB::$connection->prepare("DELETE FROM post_comment where post_id = :post_id");
          $del_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
          $del_stmt->execute();

          $del_stmt = $this->DB::$connection->prepare("DELETE FROM posts where id = :id");
          $del_stmt->bindValue(':id', $post_id, PDO::PARAM_INT);
          $del_stmt->execute();
        }

        function LikeUnlikePost($postId) {
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
        }

        function AddComment($comment, $postId) {
          session_start();

          if (!isset($_SESSION["id"])) return;

          if (empty(trim($comment))) throw new Exception("Please enter a comment", 1);

          $stmt = $this->DB::$connection->prepare("INSERT INTO post_comment (post_id, account_id, comment) VALUES (:post_id, :account_id, :comment)");

          $stmt->bindValue(':post_id', trim(htmlspecialchars($postId)), PDO::PARAM_INT);
          $stmt->bindValue(':account_id', trim(htmlspecialchars($_SESSION["id"])), PDO::PARAM_INT);
          $stmt->bindValue(':comment', trim(htmlspecialchars($comment)), PDO::PARAM_STR);
          $stmt->execute();
        }
     }
?>