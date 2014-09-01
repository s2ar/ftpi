<?
class Config {
    
    const mongo_db_name = 'ftpi';
    const perPage = 15;


    public function get_field_types() {
        return array('textarea', 'input', 'file', 'img', 'checkbox', 'date');
    }

    /**
     *  Загрузка конфига компонента
     *  @param str $component - имя компонента
     *  @return object
     */
    static function load($component){
        if(!is_string($component)) return false;
        include_once "config.".$component.".php";
        $className ="Config".ucfirst($component);  
        return $className::getInstance();
    }
}
