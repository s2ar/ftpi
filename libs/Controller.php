<?php

class Controller {

    private $flash = array();

    function __construct() {  
        Session::init();         
        $this->view = new View();
        $this->view->flash_messages = $this->get_flash_messages();
    }


    /**
     * Добавляет сообщение в сессию
     * @param string $message
     * @param string $class
     * @param bool $useSession  - сохранить в сесии или в свойстве класса
     */
    public function add_flash_message($message, $class='info', $useSession=true){
        if($useSession){
            $_SESSION['core_message'][] = '<div class="alert alert-'.$class.'"><button class="close" data-dismiss="alert" type="button">×</button>'.$message.'</div>';
        }else{
            $this->flash[] = '<div class="alert alert-'.$class.'"><button class="close" data-dismiss="alert" type="button">×</button>'.$message.'</div>'; 
            $this->view->flash_messages = $this->get_flash_messages();
        }
        
    }

    /**
     * Возвращает массив сообщений сохраненных в сессии
     */
    public function get_flash_messages(){

        if (isset($_SESSION['core_message']) && isset($this->flash)){
            $messages = $this->flash = array_merge($_SESSION['core_message'], $this->flash);

        } elseif(isset($_SESSION['core_message'])) {
            $messages = $this->flash = $_SESSION['core_message'];        

        } elseif(isset($this->flash)) {
            $messages = $this->flash;
        }else{   
            $messages = false;
        }

        $this->clear_flash_messages();
        return $messages;

    }

    /**
     * Очищает очередь сообщений сессии
     */
    public function clear_flash_messages(){
        unset($_SESSION['core_message']);
    }




    /**
     * Параметр @return - возвращать ли обьект 
     * 
     */ 
    public function load_model($name, $return=false){
   
        $path = 'models/'.$name.'.model.php';
        
        if (file_exists($path)) {
            require_once 'models/'.$name.'.model.php';
            
            $modelName = ucfirst($name).'Model';
            if(!$return){
                $this->model = new $modelName();            
            }else{
                return new $modelName();
            }
        }
        
    }
    
    public function rus2translit($str) { 
        $str    = str_replace(' ', '-', strtolower(trim($str)));         
        $string = rtrim(preg_replace ('/[^a-zA-Zа-яёА-ЯЁ0-9\-]/iu', '-', $str), '-');
        while(mb_strstr($string, '--')){ $string = str_replace('--', '-', $string); }
     
        $ru_en = array(
                        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d',
                        'е'=>'e','ё'=>'yo','ж'=>'zh','з'=>'z',
                        'и'=>'i','й'=>'i','к'=>'k','л'=>'l','м'=>'m',
                        'н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s',
                        'т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c',
                        'ч'=>'ch','ш'=>'sh','щ'=>'sch','ъ'=>'','ы'=>'y',
                        'ь'=>'','э'=>'ye','ю'=>'yu','я'=>'ja'
                      );

        foreach($ru_en as $ru=>$en){
            $string = preg_replace('/(['.$ru.']+?)/iu', $en, $string);
        }      
        if (!$string){ $string = 'empty_seoname'; }
        return $string;
    }

    function str2url($str) {
        // переводим в транслит
        $str = $this->rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }

    /**
     *  Редирект к URL
     *  @param str $url
     */
    public function redirect_to($url) {
    	header('location: '.$url);
        exit;
    }

}

?>
