<article>
	<script>
	var chartData = [
<?
//var_dump($this->arIndex['history']);

foreach ($this->historyModif as $val) {
	echo "{ year: new Date('".$val['date']."'),  value: ".$val['percent']."},";
	//var_dump(date('m/d/Y', $val['mkdate']->sec));
}

?>
];
	</script>

	<div class="row">
    	<div class="col-lg-12">
			<div class="page-header">
				<h1 id="tables">ПАММ Счет <?=$this->arIndex['name']?></h1>
			</div>

			<div id="chartdiv" style="width: 100%; height: 400px;"></div>
			<script src="/public/js/charts.js"></script>

	  </div>
	</div>
</article>