<?php

class View {

    function __construct() {        
    }


    /**
     * Метод подключает шаблоны 
     * @param str|array $name может быть строкой либо массивом строк
     */ 
    public function render($name, $noInclude = false) {
   
        if(is_array($name)) {
            if ($noInclude == false) require_once 'views/header.php';
            foreach ($name as $value) {
                require_once 'views/' . $value . '.php';
            }
            if ($noInclude == false) require_once 'views/footer.php';
            
        }elseif(is_string($name)){
            if ($noInclude == TRUE) {
                require_once 'views/' . $name . '.php';
            } else {
                require_once 'views/header.php';
                require_once 'views/' . $name . '.php';
                require_once 'views/footer.php';
            }    
        }       
    }

    /**
     * Метод создает пагинацию 
     * Входящие параметры
     * @param int $all колличество всех записей
     * @param int $N шаг
     * @param int $curP текущая страница
     * @param str $url адрес
     *  
     * @return str Возвращает html шаблон
     * 
     */
    public function pagination($all, $N, $curP, $url){
        if ($all <= $N)  return;

        $countP = ceil($all / $N);       
        $str_arrows_left = "&lt;";
        $str_arrows_left_all = "&lt;&lt;";
        $str_arrows_right = "&gt;";
        $str_arrows_right_all = "&gt;&gt;";
        

        // Выводим только предыдущие и последующие страницы до 5
        $startP = 1;
        if (($curP > 6) && (($countP - 5) >= $curP)) {
            $startP = $curP - 5;
            $endP = $curP + 5;
        } elseif ($curP <= 6) {
            $startP = 1;
            if ($countP > 11) {
                $endP = 11;
            } else {
                $endP = $countP;
            }
        } elseif (($countP - 5) < $curP) {
            $startP = $countP - 10;
            if ($startP < 1)
                $startP = 1;
            $endP = $countP;
        }

        $html_n ='';
        $html = "<div class='pagination pagination-centered'><ul>";
        if ($curP > 1) {
            $prevP = $curP - 1;
            $html_1 = "<li class='open' data-page='" . $prevP . "'><a href='".$url."&page=".$prevP."'>" . $str_arrows_left . "</a></li>";
            $html_1_1 = "<li class='open' data-page='1'><a href='".$url."&page=1'>" . $str_arrows_left_all . "</a></li>";
        } else {
            $html_1 = "<li class='disabled'><a>" . $str_arrows_left . "</a></li>";
            $html_1_1 = "<li class='disabled'><a>" . $str_arrows_left_all . "</a></li>";
        }
        for ($index = $startP; $index <= $endP; $index++) {
            if ($curP == $index) {
                $html_n.="<li class='active' data-page='" . $index . "'><a>" . $index . "</a></li>";
            } else {
                $html_n.="<li class='open' data-page='" . $index . "'><a href='".$url."&page=".$index."'>" . $index . "</a></li>";
            }
        }
        if ($curP < $countP) {
            $nextP = $curP + 1;
            $html_2 = "<li class='open' data-page='" . $nextP . "'><a href='".$url."&page=".$nextP."'>" . $str_arrows_right . "</a></li>";
            $html_2_2 = "<li class='open' data-page='" . $countP . "'><a href='".$url."&page=".$countP."'>" . $str_arrows_right_all . "</a></li>";
        } else {
            $html_2 = "<li class='disabled'><a>" . $str_arrows_right . "</a></li>";
            $html_2_2 = "<li class='disabled'><a>" . $str_arrows_right_all . "</a></li>";
        }

        $html .=$html_1_1 . $html_1 . $html_n . $html_2 . $html_2_2;
        $html .="</ul></div>";
        return $html;   

    }




}

?>
