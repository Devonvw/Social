<?php
class Router {
    public function route($uri, $requestMethod) {
        $api = false;
        if (str_starts_with($uri, "api/")) {
            $uri = substr($uri, 4);
            $api = true;
        }
        
        //Separate api routes and site routes
        if ($api) $this->handleApiRoutes($uri, $requestMethod);
        else $this->handleRoutes($uri, $requestMethod);
    }

    private function handleApiRoutes($uri, $requestMethod) {
        switch($requestMethod) {
            case 'GET':
                switch($uri) {
                    case "feed":
                        session_start();
                        require_once __DIR__ . '/api/controller/feedController.php';
                        $controller = new APIFeedController();
                        $controller->getFeed();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case 'POST': 
                switch($uri) {
                    case "user/login":
                        session_start();
                        require_once __DIR__ . '/api/controller/userController.php';
                        $controller = new APIUserController();
                        $controller->login();
                        break;
                    case "user/sign-up":
                        session_start();
                        require_once __DIR__ . '/api/controller/userController.php';
                        $controller = new APIUserController();
                        $controller->createUser();
                        break;
                    case "user/logout":
                        session_start();
                        require_once __DIR__ . '/api/controller/userController.php';
                        $controller = new APIUserController();
                        $controller->logout();
                        break;
                    case "feed/new-post":
                        require_once __DIR__ . '/api/controller/feedController.php';
                        $controller = new APIFeedController();
                        $controller->createNewPost();
                        break;
                    case "feed/like-unlike-post":
                        session_start();
                        require_once __DIR__ . '/api/controller/feedController.php';
                        $controller = new APIFeedController();
                        $controller->likeUnlikePost();
                        break;
                    case "feed/add-comment":
                        require_once __DIR__ . '/api/controller/feedController.php';
                        $controller = new APIFeedController();
                        $controller->addComment();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            default:
            http_response_code(404);
                break;
        }
    }

    private function handleRoutes($uri, $requestMethod) {
        switch($requestMethod) {
            case 'GET':
                switch($uri) {
                    case '': 
                        require __DIR__ . '/controller/feedController.php';
                        session_start();
                        $controller = new FeedController();
                        $controller->index();
                        break;
                    case 'login': 
                        session_start();
                        require_once __DIR__ . '/controller/userController.php';
                        $controller = new UserController();
                        $controller->login();
                        break;
                    case 'sign-up': 
                        require_once __DIR__ . '/controller/userController.php';
                        $controller = new UserController();
                        $controller->signUp();
                        break;
                    case 'new-post': 
                        session_start();
                        require __DIR__ . '/controller/feedController.php';
                        $controller = new FeedController();
                        $controller->newPost();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            case 'POST': 
                switch($uri) {
                    case 'login': 
                        require_once __DIR__ . '/controller/userController.php';
                        $controller = new UserController();
                        $controller->login();
                        break;
                    default:
                        http_response_code(404);
                        break;
                }
                break;
            default:
            http_response_code(404);
                break;
        }    
    }
}
?>