<?php

class Profile extends Controller {

    function __construct() {
        parent::__construct();        
    }
    
    function index(){
        $arFilter =array();
        if(!empty($_GET['set'])){
            $arFilter = array('p_set'=>$_GET['set']);
        }
        $page = (isset($_GET['page']) && intval($_GET['page'])>0) ? intval($_GET['page']) : 1;

        //var_dump($this->model->totalFields);
        // Очистим $_GET от page и url
        unset($_GET['page']);
        unset($_GET['url']);
        $urlQuery = http_build_query($_GET);

        $this->view->arProfiles = $this->model->get_list($arFilter, $page);
        $this->view->pagin = $this->view->pagination($this->model->totalFields, Config::perPage, $page, '/profile?'.$urlQuery);

        // Загрузка корневых категорий
        $obModelCategory = $this->load_model('category', true);
        $arTopCategories = $obModelCategory->get_list(array('parent'=>null)); 
        $arCategoriesNew =array();
        foreach ($arTopCategories as $value) {
            $arCategoriesNew[(string)$value['_id']] = $value['name'];
        }

        $this->view->arCategories = $arCategoriesNew; 
        $this->view->render('profile/index');
    }


    function add(){
        // Первым делом проверям get параметр set категории
        if(empty($_GET['set'])) $this->redirect_to("/profile");

        // Если переменная "add" содержит 1 - значит форма отправлена с данными, 
        // нужно создать запись, иначе выводим форму
        $this->view->pageName = "Создание профиля";
        $this->view->type = "add";
        $this->view->set = $_GET['set'];
        //$this->view->field_types = Config::get_field_types();

        /********TODO выборку и построение дерева убрать в один метод***********/ 
        $obModelCategory = $this->load_model('category', true);   
        /* Получим весь массив категорий для отображения имен категорий и их предков в списке*/   
        $this->view->arCategoriesInfo = $obModelCategory->prepare_info();
        // Подготовим массив для построения дерева
        $obModelCategory->arInTree = $obModelCategory->prepare_data_to_tree();
        //Зададим фильтр 
        $obModelCategory->arOnlyRoot = array($_GET['set']);
        // Построим дерево. Результат запишется в $this->arToTree
        $obModelCategory->build_array_to_tree('', 0);
        // Передадим в вид
        $this->view->arToTree = $obModelCategory->arToTree;
        /********************************************************************/
        $this->view->arProfile =array();
        if(isset($_POST['add']) && $_POST['add']==1) {  
            $this->view->arProfile = $_POST['p']; 
           // Сформируем массив поля 
            $arProfileValues = $_POST['p'];
            $arProfileValues['p_enable'] = (boolean)$arProfileValues['p_enable'];        
            $arProfileValues['p_seo'] = ($_POST['p']['p_seo'])? $_POST['p']['p_seo']:  parent::str2url($_POST['p']['p_name']);

            if($this->model->create($arProfileValues)){
            //if(false){
                $this->add_flash_message("Профиль <strong>".$_POST['p_name']."</strong> добавлен", 'success');
                $this->redirect_to("/profile");
            }else{
                $this->add_flash_message("Ошибка. Профиль не добавлен", 'error', false);
            }              
        }
        $this->view->fields = $this->build_form($this->view->set, $this->view->arProfile);      
        $this->view->render('profile/form');         
    }    


    function edit($id){
    	
        // Если переменная "edit" содержит 1 - значит форма отправлена с данными, 
        // нужно редактировать запись, иначе выводим форму
        $this->view->pageName = "Редактирование профиля";
        $this->view->type = "edit";    
        $this->view->arProfile = $this->model->get_by_id($id);
        $this->view->set = $this->view->arProfile['p_set'];
		/********TODO выборку и построение дерева убрать в один метод***********/ 
        $obModelCategory = $this->load_model('category', true);   
        /* Получим весь массив категорий для отображения имен категорий и их предков в списке*/   
        $this->view->arCategoriesInfo = $obModelCategory->prepare_info();
        // Подготовим массив для построения дерева
        $obModelCategory->arInTree = $obModelCategory->prepare_data_to_tree();
        //Зададим фильтр 
        $obModelCategory->arOnlyRoot = array($this->view->arProfile['p_set']);
        // Построим дерево. Результат запишется в $this->arToTree
        $obModelCategory->build_array_to_tree('', 0);
        // Передадим в вид
        $this->view->arToTree = $obModelCategory->arToTree;
        /********************************************************************/

        

        if(isset($_POST['edit']) && $_POST['edit']==1) {  
            $this->view->arProfile = $_POST['p'];
            $arProfileValues = $this->post_data_processing($_POST['p']);
           // Сформируем массив поля 

                     
            if($this->model->update($id, $arProfileValues)){
            //if(false){
                $this->add_flash_message("Профиль <strong>".$_POST['p_name']."</strong> изменен", 'success');
                $this->redirect_to("/profile");
            }else{
                $this->add_flash_message("Ошибка. Профиль не изменен", 'error', false);
            }              
        }  
        $this->view->fields = $this->build_form($this->view->set, $this->view->arProfile); 
        $this->view->render('profile/form');         
    }



    function delete() {
        if ($_POST['id']) {
            if($this->model->delete($_POST['id'])){
                $this->add_flash_message("Профиль удален", 'success');                
            }else{
                $this->add_flash_message("Ошибка. Профиль не удален", 'error');
            }
        }
        $this->redirect_to("/profile");
    }

/************** Private method **************/

    /**
     *  Метод строет html форму
     * @param str $set - набор
     * @param array $arProfile - может принимать массив профиля (при редактировании)
     * @return str
     */
    private function build_form($set, $arProfile = array()) {
        // Получим массив полей для набора профиля
        $obModelField = $this->load_model('field', true); 
        $arFields = $obModelField->get_list(array('set'=>$set), false);
        //var_dump($arFields);
        $html = '';
         foreach ($arFields as $f) {
            $arProfile[$f['name']] = (isset($arProfile[$f['name']]))? $arProfile[$f['name']] : '';
            switch ($f['type']) {
                case 'input':
                    $html .= '  <div class="control-group">
                                  <label class="control-label" for="'.$f['name'].'">'.$f['name'].'</label>
                                  <div class="controls">
                                    <input id="'.$f['name'].'" name="p['.$f['name'].']" type="text" class="input-xlarge" value="'.$arProfile[$f['name']].'">
                                    <p class="help-block">'.$f['help'].'</p>
                                  </div>
                                </div>';
                    break;                

                case 'textarea':
                    $html .= '  <div class="control-group">
                                  <label class="control-label for="'.$f['name'].'"">'.$f['name'].'</label>
                                  <div class="controls">                     
                                    <textarea id="'.$f['name'].'" name="p['.$f['name'].']">'.$arProfile[$f['name']].'</textarea>
                                  </div>
                                </div>';
                
                    break;

                case 'date':      
                    $date = ($arProfile[$f['name']] !='')? date('Y/m/d', $arProfile[$f['name']]->sec) : '';                 
                    $html .= '  <div class="control-group">
                                  <label class="control-label" for="'.$f['name'].'"">'.$f['name'].'</label>
                                  <div class="controls">
                                    <div class="input-prepend">
                                      <span class="add-on"><i class="icon-th"></i></span>
                                      <input id="'.$f['name'].'" name="p['.$f['name'].']" class="span2 datepicker" value="'.$date.'" type="text">
                                    </div>
                                    <p class="help-block">'.$f['help'].'</p>
                                  </div>
                                </div>';
                    break; 

                case 'checkbox':
                    $checked = ($arProfile[$f['name']])? "checked" : ''; 
                    $html .= '<div class="control-group">
                      <label class="control-label" for="'.$f['name'].'"">'.$f['name'].'</label>                   
                        <div class="controls">                     
                          <input type="checkbox" '.$checked.' name="p['.$f['name'].']" id="'.$f['name'].'" value="1">                      
                      </div>
                    </div>';
                    break;                

                case 'img':
             
                    $html .= '<div class="control-group">
                      <label class="control-label" for="'.$f['name'].'"">'.$f['name'].'</label>                   
                        <div class="controls">                     
                          <input type="file" name="p['.$f['name'].']" id="'.$f['name'].'" value="">                      
                      </div>
                    </div>';
                    break;

                default:
                    # code...
                    break;
            }
        }
        return $html;
    }

    /**
     *  Метод обрабатывает данные с $_POST
     * @param array $arProfileValues
     * @return array
     */
    private function post_data_processing($arProfileValues) {
       
        $arProfileValues['p_enable'] = (boolean)$arProfileValues['p_enable'];        
        $arProfileValues['p_seo'] = ($arProfileValues['p']['p_seo'])? $arProfileValues['p']['p_seo']:  parent::str2url($arProfileValues['p']['p_name']);
        $arProfileValues['birthday'] = (!empty($arProfileValues['birthday']))? new MongoDate(strtotime($arProfileValues['birthday'])) : '';

        return $arProfileValues;
    }







}