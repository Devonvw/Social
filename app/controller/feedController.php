<?php
require_once __DIR__ . '/controller.php';
require __DIR__ . '/../service/feedService.php';

class FeedController extends Controller {

    private $feedService; 

    // initialize services
    function __construct() {
        $this->feedService = new FeedService();
    }

    // router maps this to /article and /article/index automatically
    public function index() {
        // retrieve data 
        $feed = $this->feedService->GetFeed();
    
        // show view, param = accessible as $model in the view
        // displayView maps this to /views/article/index.php automatically
        $this->displayView($feed);
    }

    public function newPost() {
      $this->displayView("");
  }
}
?>