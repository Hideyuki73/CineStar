<?php
class Router
{
    static $INSTANCE;
    var $routes = [];

    public function add($method, $path, $handler){
        self::getInstance()->routes[$path][$method] = $handler;
    }

    public function process(){
        header("Content-Type: application/json");
        $path = $_SERVER["PATH_INFO"];
        $method = $_SERVER["REQUEST_METHOD"];

        $handler = self::getInstance()->routes[$path][$method];
        if($handler == null){
            http_response_code(404);
            echo json_encode([
                "error" => "NOT_FOUND",
                "msg" => "Path '$path' not found for method $method"
            ]);
            return;
        }


        $handler();
    }
    /**
     * @return Router
     */
    public static function getInstance()
    {
        if(self::$INSTANCE == null){
            self::$INSTANCE = new Router();
        }
        return self::$INSTANCE;
    }
}