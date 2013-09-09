<?
class Field extends Controller{

    function __construct() {
        parent::__construct(); 
    }
    
    function index(){

        $arFilter =array();
        if(!empty($_GET['set'])){
            $arFilter = array('set'=>$_GET['set']);
        }
        $page = (isset($_GET['page']) && intval($_GET['page'])>0) ? intval($_GET['page']) : 1;

        //var_dump($this->model->totalFields);
        // Очистим $_GET от page и url
        unset($_GET['page']);
        unset($_GET['url']);
        $urlQuery = http_build_query($_GET);

        $this->view->arFields = $this->model->get_list($arFilter, true, $page);
        $this->view->pagin = $this->view->pagination($this->model->totalFields, Config::perPage, $page, '/field?'.$urlQuery);

        // Загрузка корневых категорий
        $obModelCategory = $this->load_model('category', true);
        $arTopCategories = $obModelCategory->get_list(array('parent'=>null)); 
        $arCategoriesNew =array();
        foreach ($arTopCategories as $value) {
            $arCategoriesNew[(string)$value['_id']] = $value['name'];
        }

        $this->view->arCategories = $arCategoriesNew; 
        $this->view->render('field/index');
    }    

    function add(){       

        // Если переменная "add" содержит 1 - значит форма отправлена с данными, 
        // нужно создать запись, иначе выводим форму
        $this->view->pageName = "Создание поля";
        $this->view->type = "add";
        $this->view->field_types = Config::get_field_types();

        // Загрузка списка наборов
        $obModelCategory = $this->load_model('category', true);
        $this->view->arTopCategoties = $obModelCategory->get_list(array('parent'=>null));

        if( isset($_POST['add']) && $_POST['add']==1) {  
            $this->view->arField = $_POST['field']; 
           // Сформируем массив поля 
            $arFieldValues = $_POST['field'];
            $arFieldValues['visible'] = (boolean)$arFieldValues['visible'];          
            if (!is_numeric($arFieldValues['order'])) {
                $this->add_flash_message("Ошибка. Порядок должен быть числом", 'error', false);
                $this->view->render('field/form');
                exit;  
            }
            $arFieldValues['order'] = intval($arFieldValues['order']);
          
            if($this->model->create($arFieldValues)){
            //if(false){
                $this->add_flash_message("Поле <strong>".$_POST['name']."</strong> добавлено", 'success');
                $this->redirect_to("/field");
            }else{
                $this->add_flash_message("Ошибка. Поле не добавлено", 'error', false);
            }

                
        }        
        $this->view->render('field/form');         
    }

    function edit($id){
        // Если переменная "edit" содержит 1 - значит форма отправлена с данными, 
        // нужно обновить запись, иначе выводим форму
        $this->view->pageName = "Редактирование поля";
        $this->view->type = "edit";
        $this->view->field_types = Config::get_field_types();

        // Загрузка списка наборов
        $obModelCategory = $this->load_model('category', true);
        $this->view->arTopCategoties = $obModelCategory->get_list(array('parent'=>null));


        $arField = $this->model->get_by_id($id);
        
        if(isset($_POST['edit']) && $_POST['edit']==1) {   
            $this->view->arField = $_POST['field'];          
           // Сформируем массив поля 
            $arFieldValues = $_POST['field'];
            $arFieldValues['visible'] = (boolean)$arFieldValues['visible'];          
            if (!is_numeric($arFieldValues['order'])) {

                $this->add_flash_message("Ошибка. Порядок должен быть числом", 'error', false);
                $this->view->render('field/form');
                exit;  
            }
            $arFieldValues['order'] = intval($arFieldValues['order']);
          
            if($this->model->update($id, $arFieldValues)){
            //if(false){
                $this->add_flash_message("Поле обновлено", 'success');
                $this->redirect_to("/field");
            }else{
                $this->add_flash_message("Ошибка. Поле не обновлено", 'error', false);
            }  

        }else{
           $this->view->arField = $arField;
        }        
        $this->view->render('field/form'); 
    }  

    function delete() {
        if ($_POST['id']) {
            if($this->model->delete($_POST['id'])){
                $this->add_flash_message("Поле удалено", 'success');                
            }else{
                $this->add_flash_message("Ошибка. Поле не удалено", 'error');
            }
        }
        $this->redirect_to("/field");
    }

}