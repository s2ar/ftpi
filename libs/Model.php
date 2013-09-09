<?php

class Model {
    protected $db; 
    
    function __construct() {
        $this->db = DatabaseMongo::init();
    } 

    /**
     *  Преобразование курсора в массив
     *  @param obj  $cursor
     *  @return array
     */
    function cursor_to_array($cursor) {
        $arResult = array();
        while($cursor->hasNext()):
            $arResult[] = $cursor->getNext();          
        endwhile;
        return $arResult;
    }     
}

?>
