<?
class Category extends Controller{


    function __construct() {
        parent::__construct(); 
    }
    
    function index(){
        $page = (isset($_GET['page']) && intval($_GET['page'])>0) ? intval($_GET['page']) : 1;

       
        /* Получим весь массив категорий для отображения имен категорий и их предков в списке*/   
        $this->view->arCategoriesInfo = $this->model->prepare_info();
    

        //var_dump($this->view->arCategoriesInfo);
        // Очистим $_GET от page и url
        unset($_GET['page']);
        unset($_GET['url']);
        $urlQuery = http_build_query($_GET);

        $this->view->arCategories = $this->model->get_list(array(), true, $page);
        $this->view->pagin = $this->view->pagination($this->model->totalCategories, Config::perPage, $page, '/category?'.$urlQuery);
 
        $this->view->render('category/index');
    }    

    function add(){       

        /* Получим весь массив категорий для отображения имен категорий и их предков в списке*/   
        $this->view->arCategoriesInfo = $this->model->prepare_info();
        // Подготовим массив для построения дерева
        $this->model->arInTree = $this->model->prepare_data_to_tree();
        // Построим дерево. Результат запишется в $this->arToTree
        $this->model->build_array_to_tree('', 0);
        // Передадим в вид
        $this->view->arToTree = $this->model->arToTree;

        // Если переменная "add" содержит 1 - значит форма отправлена с данными, 
        // нужно создать запись, иначе выводим форму
        $this->view->pageName = "Создание категории";
        $this->view->type = "add";
        if(isset($_POST['add']) && $_POST['add']==1) {              
            $this->view->arCategory = $_POST['cat']; 
            // Создадим _id для будущей записи, оноже будет и seo name
            $_POST['cat']['_id'] = parent::str2url($_POST['cat']['name']);
            $_POST['cat']['parent'] = ($_POST['cat']['parent']!=null)? $_POST['cat']['parent'] : null;
            if($this->model->create($_POST['cat'])){
            //if(false){
                $this->add_flash_message("Категория добавлена", 'success');
                $this->redirect_to("/category");
            }else{
                $this->add_flash_message("Ошибка. Категория не добавлена", 'error', false);
            }
                
        }        
        $this->view->render('category/form');         
    }

    function edit($id){

        /* Получим весь массив категорий для отображения имен категорий и их предков в списке*/   
        $this->view->arCategoriesInfo = $this->model->prepare_info();
        // Подготовим массив для построения дерева
        $this->model->arInTree = $this->model->prepare_data_to_tree();
        // Построим дерево. Результат запишется в $this->arToTree
        $this->model->build_array_to_tree('', 0);
        // Передадим в вид
        $this->view->arToTree = $this->model->arToTree;

        // Если переменная "add" содержит 1 - значит форма отправлена с данными, 
        // нужно создать запись, иначе выводим форму
        $this->view->pageName = "Редактирование категории";
        $this->view->type = "edit";
        $this->view->arCategory = $this->model->get_by_id($id);
        //var_dump($arCategory);
        if(isset($_POST['edit']) && $_POST['edit']==1) {
            $this->view->arCategory = $_POST['cat'];
            $_POST['cat']['parent'] = ($_POST['cat']['parent']!=null)? $_POST['cat']['parent'] : null;
            if($this->model->update($id, $_POST['cat'])){
            //if(false){
                $this->add_flash_message("Категория изменена", 'success');
                $this->redirect_to("/category");
            }else{
                $this->add_flash_message("Ошибка. Категория не изменена", 'error', false);
            }
                
        }       
        $this->view->render('category/form'); 
    }





}