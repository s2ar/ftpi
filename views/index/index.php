<article>
   
<?php echo $this->msg;

function random_float($min,$max) {
   return ($min+lcg_value()*(abs($max-$min)));
}



//echo GaussMethod(0, 1);
//die();

/*
function GaussMethod($mu, $sigma, $num) {
    $dSumm = 0;
    $dRandValue = 0;
   
    for ($n = 0; $n <= $num; $n++) {
        $dSumm = 0;
        for ($i = 0; $i <= 12; $i++) {
            $R = round(random_float(0,1),2);
            //var_dump($R);
            $dSumm = $dSumm + $R;
        }
        $dRandValue = round(($mu + $sigma * ($dSumm - 6)), 3);
        //echo $dRandValue;
        $massive[$n] = $dRandValue;
    }
    return $massive; 
}
*/


function GaussMethod($m, $s, $n) {
    for ($i=1; $i <= $n ; $i++) { 
       /* mean m, standard deviation s */
       $x1 = 0; $x2 = 0; $w = 0; $y1 = 0; $y2 = 0;

       do {
          $x1 = 2.0 * random_float(0,1) - 1.0;
          $x2 = 2.0 * random_float(0,1) - 1.0;
          $w = $x1 * $x1 + $x2 * $x2;
       } while ( $w >= 1.0 );

       $w = sqrt( (-2.0 * log( $w ) ) / $w );
       $y1 = $x1 * $w;
       $y2 = $x2 * $w;

       $arGauss[] = round(($m + $y1 * $s),2);
   }
   return $arGauss;
}

$arGauss = GaussMethod(0,1,100000);

//var_dump($arGauss);
$arGaussSum = array();
foreach ($arGauss as $val) {
    if(isset($arGaussSum[strval($val)])){
        $arGaussSum[strval($val)] +=1;
    }else{
        $arGaussSum[strval($val)] = 1;
    }
}
ksort($arGaussSum);

//echo "<pre>";
//var_dump($arGauss);
//var_dump($arGaussSum);
//echo "</pre>";

    ?>
<script>

    var chartData = [
    <?
    //var_dump($this->arIndex['history']);

    foreach ($arGaussSum as $key => $val) {
        echo "{ num: ".$key.",  value: ".$val."},";
        //var_dump(date('m/d/Y', $val['mkdate']->sec));
    }

    ?>
];

var chart;

AmCharts.ready(function() {
    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.dataProvider = chartData;
    chart.categoryField = "num";
    chart.startDuration = 1;

    // AXES
    // category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.labelRotation = 90;
    categoryAxis.gridPosition = "start";

    // value
    // in case you don't want to change default settings of value axis,
    // you don't need to create it, as one value axis is created automatically.
    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.valueField = "value";
    graph.balloonText = "[[category]]: [[value]]";
    graph.type = "column";
    graph.lineAlpha = 0;
    graph.fillAlphas = 0.8;
    chart.addGraph(graph);

    chart.write("chartdiv");
});



</script>


<div id="chartdiv" style="width: 100%; height: 400px;"></div>

</article>

