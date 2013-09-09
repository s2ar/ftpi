<?
class FieldModel extends Model {
    public $totalFields; 


	private $collection;
    function __construct() {
        parent::__construct();
        $this->collection = $this->db->selectCollection('fields');
       
    }

    /**
     * Получить список полей 
     * @param array $arFilter - подготовленый массив для выборки
     * @param int $page - номер страницы
     */
    function get_list($arFilter, $pageMode = true, $page=1)  {
        if(!is_array($arFilter) || !is_numeric($page)) return false;       
              
        $cursor = $this->collection->find($arFilter);
        if ($pageMode) {
            $skip = ($page - 1) * Config::perPage; // сдвиг выборки           
            $this->totalFields = $cursor->count();   
            $cursor->sort(array('order'=>1))->skip($skip)->limit(Config::perPage);    
        }    
        return  parent::cursor_to_array($cursor);         
    } 


    /**
     * Получить поле по id
     * @param int $id
     * @return array
     */
    function get_by_id($id) {
        return $this->collection->findOne(array('_id'=>new MongoId($id)));
    }       

    /**
     * Удалить поле по id
     * @param int $id
     * @return bool
     */
    function delete($id) {
        return $this->collection->remove(array('_id'=>new MongoId($id)));
    }    

    /**
     * Создать поле
     * @param array $arValues данные поля
     * @return bool
     */
    function create($arValues) {
        $arValues['date_create'] = new MongoDate();        
        return $this->collection->insert($arValues);       
    }    

    /**
	 * Обновить поле
     * @param array $arValues массив обновляемых полей
     * @return bool
     */
    function update($id, $arValues) {
        return $this->collection->update(array('_id' => new MongoId($id)), array('$set' => $arValues));   
    }


}