<?php

class Pammindex extends Controller{

    function __construct() {
        parent::__construct();   
    }
    
    function index(){       
        $this->view->msg = $this->rus2translit('ПАММ Индексы');
        
        $this->view->render('pammindex/index');
    }    

    function add(){       
        // Если переменная "add" содержит 1 - значит форма отправлена с данными, 
        // нужно создать запись, иначе выводим форму

        if($_POST) {  
            $url = (isset($_POST['url']))? $_POST['url']: '';     

            if(!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->add_flash_message("Ошибка. Неправильный адрес памм индекса", 'danger', false);
                $this->view->render('pammindex/form');
                exit; 
            }  
            // TODO возвратить id индекса, чтобы выбрать его имя
            if($this->model->upload($url)){
            //if(false){
                $this->add_flash_message("Памм индекс <strong>".$_POST['name']."</strong> добавлен", 'success');
                $this->redirect_to("/pammindex");
            }else{
                $this->add_flash_message("Ошибка. Памм индекс не добавлен", 'danger', false);
            }

                
        }        
        $this->view->render('pammindex/form');  
    }


    



}