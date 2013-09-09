<?
/**
 *  Модель профиля
 * Соглашения:
 * - наименование базовых полей начинаются с приствки p. Например  p_name, p_categories, p_set etc
 *
 * Структура документа
 * 
 */

class ProfileModel extends Model {
    public $totalFields; 


	private $collection;
    function __construct() {
        parent::__construct();
        $this->collection = $this->db->selectCollection('profiles');
       
    }

    /**
     * Получить список профилей 
     * @param array $arFilter - подготовленый массив для выборки
     * @param int $page - номер страницы
     */
    function get_list($arFilter, $page=1)  {
        if(!is_array($arFilter) || !is_numeric($page)) return false;       
              
        $cursor = $this->collection->find($arFilter);

        $skip = ($page - 1) * Config::perPage; // сдвиг выборки           
        $this->totalFields = $cursor->count();   
        $cursor->sort(array('order'=>1))->skip($skip)->limit(Config::perPage);        
        return  parent::cursor_to_array($cursor);         
    }

    /**
     * Получить профиль по id
     * @param int $id
     * @return array
     */
    function get_by_id($id) {
        return $this->collection->findOne(array('_id'=>new MongoId($id)));
    }  

    /**
     * Создать профиль
     * @param array $arValues данные категории
     * @return bool
     */
    function create($arValues) {
        $arValues = $this->cleaning_empty_values($arValues);
        $arValues['p_date_create'] = new MongoDate();        
        return $this->collection->insert($arValues);       
    }

    /**
     * Обновить профиль
     * @param array $arValues массив обновляемых полей
     * @return bool
     */
    function update($id, $arValues) {
        return $this->collection->update(array('_id' => new MongoId($id)), array('$set' => $arValues));   
    }

    /**
     * Удалить профиль по id
     * @param int $id
     * @return bool
     */
    function delete($id) {
        return $this->collection->remove(array('_id'=>new MongoId($id)));
    }

    /************** Private method **************/

    /**
     *  Метод очищает пустые данные c массива записи. Вызывается перед записью в бд
     * @param array $arValues
     * @return array
     */
    private function cleaning_empty_values($arValues){
        if(!is_array($arValues)) return array();
        $arResult =array();
        foreach ($arValues as $key => $value) {
            if(!empty($value)) $arResult[$key]=$value;
        }
        return $arResult;
    } 
}