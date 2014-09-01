<?php

class Pamm extends Controller{

    function __construct() {
        parent::__construct();   
    }
    
    function index(){   
        $arFilter =array();
        $this->view->arIndexes = $this->model->getList($arFilter, false) ;    
        $this->view->msg = $this->rus2translit('ПАММ Счета');
        
        $this->view->render('pamm/index');
    }    

    function add(){
        // Если переменная "add" содержит 1 - значит форма отправлена с данными, 
        // нужно создать запись, иначе выводим форму

        if($_POST) {  
            $url = (isset($_POST['url']))? $_POST['url']: '';     

            if(!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->add_flash_message("Ошибка. Неправильный адрес памм счета", 'danger', false);
                $this->view->render('pamm/form');
                exit; 
            }  
            // TODO возвратить id индекса, чтобы выбрать его имя
            $arUpload = $this->model->upload($url);
            if($this->model->create($arUpload)){
            //if(false){
                $this->add_flash_message("Памм счет <strong>".$_POST['name']."</strong> добавлен", 'success');
                $this->redirect_to("/pamm/");
            }else{
                $this->add_flash_message("Ошибка. Памм счет не добавлен", 'danger', false);
            }                
        }        
        $this->view->render('pamm/form');  
    }

    function view($name) {
        if(!is_string($name)) return false;

        $this->view->arIndex = $this->model->getByName($name);

        $this->view->historyModif = $this->model->calcCompInterest($this->view->arIndex['history']);
        $this->view->render('pamm/view');
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
                $this->add_flash_message("Памм счет <strong>".$name."</strong> обновлен", 'success');
            }else{
                $this->add_flash_message("Памм счет <strong>".$name."</strong> не обновлен", 'danger');
            }
        }else{
            $this->add_flash_message("Не найден URL Памм счет <strong>".$name."</strong>", 'danger');
        }
        $this->redirect_to('/pamm/');
    }



}