<?
class CategoryModel extends Model {

    public $arToTree = array(); // сформированый массив дерева
    public $arInTree = array(); // входной массив для формирование дерева
    public $arOnlyRoot = array(); // вывести дерево только заданой корневой категории

	private $collection;
    function __construct() {
        parent::__construct();
        $this->collection = $this->db->selectCollection('categories');
       
    }

    /**
     * Получить список категорий 
     * @param array $arFilter - подготовленый массив для выборки
     * @param int $page - номер страницы
     */
    function get_list($arFilter, $pageMode = true, $page=1)  {
        if(!is_array($arFilter) || !is_numeric($page)) return false;       
              
        $cursor = $this->collection->find($arFilter);
        if ($pageMode) {
            $skip = ($page - 1) * Config::perPage; // сдвиг выборки           
            $this->totalCategories = $cursor->count();   
            $cursor->sort(array('order'=>1))->skip($skip)->limit(Config::perPage);    
        }
    
        return  parent::cursor_to_array($cursor);         
    }  

    /**
     * Подготовить данные для построение массива дерева 
     * @return array
     */
    function prepare_data_to_tree($arFilter=array()) {
        $cursor = $this->collection->find();
        $arResult = array();
        while($cursor->hasNext()):
            $arRow = $cursor->getNext();          
            $arResult[$arRow['parent']][] =$arRow;          
        endwhile;
        return $arResult;
    }

    /**
     * Подготовить данные категорий к удобному виду
     * _id => name
     * @return array
     */
    function prepare_info() {
        /* Получим весь массив категорий для отображения имен категорий и их предков в списке*/
        $arCategoriesInfo = $this->get_list(array(), false);
        $arCategoriesInfoModif = array();
        foreach ($arCategoriesInfo as $value) {
            $arCategoriesInfoModif[$value['_id']] = $value['name'];
        }
        return $arCategoriesInfoModif;
    }  


    /** 
     * Вывод дерева 
     * @param Integer $parent_id - id-родителя 
     * @param Integer $level - уровень вложености 
     */ 
    function build_array_to_tree($parent_id, $level) { 
         
        if (isset($this->arInTree[$parent_id])) { //Если категория с таким parent_id существует 
            foreach ($this->arInTree[$parent_id] as $value) { //Обходим 
                if(!in_array($value["_id"], $this->arOnlyRoot) && $level==0 && !empty($this->arOnlyRoot)) continue;
                $this->arToTree[] = array('_id'=>$value["_id"], 'level'=> $level);          
                $level++; //Увеличиваем уровень вложености 
                //Рекурсивно вызываем эту же функцию, но с новым $parent_id и $level 
                $this->build_array_to_tree($value["_id"], $level); 
                $level--; //Уменьшаем уровень вложености 
            } 
        } 
    }   

    /**
     * Получить набор по id
     * @param int $id
     * @return array
     */
    function get_by_id($id) {
        return $this->collection->findOne(array('_id'=>$id));
    }    

    /**
     * Создать категорию
     * @param array $arValues данные категории
     * @return bool
     */
    function create($arValues) {
        $arValues['date_create'] = new MongoDate();        
        return $this->collection->insert($arValues);       
    }    

    /**
	 * Обновить набор
     * @param array $arValues массив обновляемых полей
     * @return bool
     */
    function update($id, $arValues) {
        return $this->collection->update(array('_id' => $id), array('$set' => $arValues));   
    }


}