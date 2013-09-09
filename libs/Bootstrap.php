<?php

class Bootstrap {

    function __construct() {
      
        $url = isset ($_GET['url']) ? $_GET['url']: null;
        $url = explode('/', rtrim($url, '/'));
        //print_r($url);
        if (empty($url[0])){
            require_once 'controllers/index.php';
            $controller = new Index();
            $controller->index();
            return false;
        }

        $file = 'controllers/' . $url[0] . '.php';
        if (file_exists($file)){
             require $file;
        } else {
            $this->error();
            return false;
       
        }
        
        $controller = new $url[0];
        $controller->load_model($url[0]);

        if (isset($url[2])) {
            if(method_exists($controller, $url[1])){
                $controller->{$url[1]}($url[2]);
            }else {
                $this->error();
                return false;
            }        
            
        } else {
            if (isset($url[1])) {
                if(method_exists($controller, $url[1])){
                    $controller->{$url[1]}();                    
                }else{
                    $this->error(); 
                    return false;
                }           
           
            }  else {
                $controller->index();
            }
        }
        
    }
    
    function error() {
        require_once 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        return false;
        
    }
    

}

