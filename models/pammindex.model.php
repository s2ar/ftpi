<?
class PammindexModel extends Model {
    //public $totalFields;
	private $collection;
    public $totalIndexes = 5;

    function __construct() {
        parent::__construct();
        $this->collection = $this->db->selectCollection('pammindexes');
       
    }


    function upload($url) {
        // http://fx-trend.com/pamm/index/Prize
        $html = file_get_html($url); // создание объекта по ссылке

        // Массив значений
        $arValues = array();

        $headerBlock = $html->find('div#mb_center table tr', 0); 
        // Имя памм индекса
        $arValues['name'] = $headerBlock->find('td table tr',0)->find('td',1)->innertext;
        // Дата создания памм индекса
        $dateStart = $headerBlock->find('td table tr',1)->find('td',1)->innertext;
        $dateStartExpl = explode(' ', $dateStart);
        $dateStartExp2 = explode('.', $dateStartExpl[0]);
        $arValues['date_start'] = mktime( 0, 0, 0, intval($dateStartExp2[1]), intval($dateStartExp2[2]), intval($dateStartExp2[0]));
        $arValues['date_start'] = new MongoDate($arValues['date_start']);

        $tr = $html->find('table.my_accounts_table tr');
        $arHistory = array();
        $i = -1;
        foreach ($tr as $el) {
            $i++;
            if($el->find('td div') || $i==0) continue;
            $date = $el->children(0)->innertext;
            $percent = $el->children(1)->children(0)->innertext;  

            $dateExpl = explode("-", $date);
            $dateExpl1 = explode('.', trim($dateExpl[1]));

            $mkRow = mktime( 0, 0, 0, $dateExpl1[1], $dateExpl1[0], $dateExpl1[2]);

            $row = array('mkdate'=>new MongoDate($mkRow), 'percent'=>floatval($percent)); 
            $arHistory[]=$row;

        }
        $arValues['history'] = $arHistory;
        //var_dump($arHistory);

        return $this->create($arValues);       
       
    }

    /**
     * Получить список индексов
     * @param array $arFilter - подготовленый массив для выборки
     * @param int $page - номер страницы
     */
    function getList($arFilter, $pageMode = true, $page=1)  {
        if(!is_array($arFilter) || !is_numeric($page)) return false;       
              
        $cursor = $this->collection->find($arFilter);
        if ($pageMode) {
            $skip = ($page - 1) * Config::perPage; // сдвиг выборки           
            $this->totalIndexes = $cursor->count();   
            $cursor->sort(array('order'=>1))->skip($skip)->limit(Config::perPage);    
        }    
        return  parent::cursor_to_array($cursor);         
    } 


    /**
     * Получить индекс по имени
     * @param str $name
     * @return array
     */
    function getByName($name) {
        return $this->collection->findOne(array('name'=>$name));
    }      

    /**
     * Посчитать сложный процент 
     * @param array $arHistory
     * @return array 
     */
    function calcCompInterest($arHistory) {
        if(!is_array($arHistory)) return false;
        $arNewHistory = array();
        $compPercent = 1;
        foreach ($arHistory as $rec) {
            $compPercent =  round($compPercent*(1+($rec['percent']/100)),4);
            //echo  $compPercent."<br />";
            $arNewHistory[]=array('date'=>date('m/d/Y', $rec['mkdate']->sec), 'percent'=>$compPercent);
        }
        return $arNewHistory;
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