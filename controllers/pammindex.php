<?php

class Pammindex extends Controller{

    function __construct() {
        parent::__construct();   
    }
    
    function index(){   
        $arFilter =array();
        $this->view->arIndexes = $this->model->getList($arFilter, false) ;    
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
            $arUpload = $this->model->upload($url);
            if($this->model->create($arUpload)){
            //if(false){
                $this->add_flash_message("Памм индекс <strong>".$_POST['name']."</strong> добавлен", 'success');
                $this->redirect_to("/pammindex/");
            }else{
                $this->add_flash_message("Ошибка. Памм индекс не добавлен", 'danger', false);
            }                
        }        
        $this->view->render('pammindex/form');  
    }

    function view($name) {
        if(!is_string($name)) return false;

        $this->view->arIndex = $this->model->getByName($name);

        $this->view->historyModif = $this->model->calcCompInterest($this->view->arIndex['history']);
        $this->view->render('pammindex/view');
    }

    /**
     * Обновление индекса
     */
    function update($name) {
        if(!is_string($name)) return false;
        $arIndex = $this->model->getByName($name);
        if(isset($arIndex['url'])&& !empty($arIndex['url'])){
            $arUpload = $this->model->upload($arIndex['url']);

            // простая проверка на соответствие имени
            if($arUpload['name'] ==$name){
                $this->model->delete($arIndex['_id']);
                $this->model->create($arUpload);
                $this->add_flash_message("Памм индекс <strong>".$name."</strong> обновлен", 'success');
            }else{
                $this->add_flash_message("Памм индекс <strong>".$name."</strong> не обновлен", 'danger');
            }
        }else{
            $this->add_flash_message("Не найден URL Памм индекса <strong>".$name."</strong>", 'danger');
        }
        $this->redirect_to('/pammindex/');
    }



}