<?php
class Controller {
    
    function displayView($data) {        
        $directory = substr(get_class($this), 0, -10);
        $view = debug_backtrace()[1]['function'];
        require __DIR__ . "/../view/$directory/$view.php";
    }

}