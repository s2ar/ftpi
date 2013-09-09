<?php

class Index extends Controller{

    function __construct() {
        parent::__construct();   
    }
    
    function index(){
       
        $this->view->msg = $this->rus2translit('Админка');      
        
        $this->view->render('index/index');
    }
    
     function def(){
       
        $this->view->msg = 'Главная страница';
        $this->view->render('index/index');
    }


}