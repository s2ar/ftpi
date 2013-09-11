<article>
    


<script src="http://www.amcharts.com/lib/amcharts.js" type="text/javascript"></script>
<div id="chartdiv" style="width: 100%; height: 362px;"></div>

<script>
  var chart;
var chartData = [];

// generate some random data, quite different range
function generateChartData() {
    // current date
    var date = new Date();
    // now set 1000 minutes back                 
    date.setMinutes(date.getDate() - 1000);

    // and generate 1000 data items
    for (var i = 0; i < 1000; i++) {
        var newDate = new Date(date);
        // each time we add one minute
        newDate.setMinutes(newDate.getMinutes() + i);
        // some random number      
        var visits = Math.round(Math.random() * 40) + 10;
        // add data item to the array                          
        chartData.push({
            date: newDate,
            visits: visits
        });
    }
}

AmCharts.ready(function() {
    // generate some random data
    generateChartData();

    // SERIAL CHART
    chart = new AmCharts.AmSerialChart();
    chart.pathToImages = "http://www.amcharts.com/lib/images/";
    chart.autoMarginOffset = 3;
    chart.marginRight = 15;
    chart.zoomOutButton = {
        backgroundColor: '#000000',
        backgroundAlpha: 0.15
    };
    chart.dataProvider = chartData;
    chart.categoryField = "date";

    // data updated event will be fired when chart is displayed,
    // also when data will be updated. We'll use it to set some
    // initial zoom
    chart.addListener("dataUpdated", zoomChart);

    // AXES
    // Category
    var categoryAxis = chart.categoryAxis;
    categoryAxis.parseDates = true; // in order char to understand dates, we should set parseDates to true
    categoryAxis.minPeriod = "mm"; // as we have data with minute interval, we have to set "mm" here.             
    categoryAxis.gridAlpha = 0.07;
    categoryAxis.showLastLabel = false;
    categoryAxis.axisColor = "#DADADA";

    // Value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.gridAlpha = 0.07;
    valueAxis.title = "Прибыль, %";
    chart.addValueAxis(valueAxis);

    // GRAPH
    var graph = new AmCharts.AmGraph();
    graph.type = "line"; // try to change it to "column"
    graph.title = "red line";
    graph.valueField = "visits";
    graph.lineAlpha = 1;
    graph.lineColor = "#d1cf2a";
    graph.fillAlphas = 0.3; // setting fillAlphas to > 0 value makes it area graph
    chart.addGraph(graph);

    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorPosition = "mouse";
    chartCursor.categoryBalloonDateFormat = "JJ:NN, DD MMMM";
    chart.addChartCursor(chartCursor);

    // SCROLLBAR
    var chartScrollbar = new AmCharts.ChartScrollbar();

    chart.addChartScrollbar(chartScrollbar);

    // WRITE
    chart.write("chartdiv");
});


// this method is called when chart is inited as we listen for "dataUpdated" event


function zoomChart() {
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
}
</script>












    
    <?php echo $this->msg;?>
    <!-- Tables
      ================================================== -->
      <div class="bs-docs-section">

        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="tables">ПАММ Индексы</h1>
            </div>

            <div class="bs-example">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Column heading</th>
                    <th>Column heading</th>
                    <th>Column heading</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="success">
                    <td>4</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="danger">
                    <td>5</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="warning">
                    <td>6</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                  <tr class="active">
                    <td>7</td>
                    <td>Column content</td>
                    <td>Column content</td>
                    <td>Column content</td>
                  </tr>
                </tbody>
              </table>
            </div><!-- /example -->
          </div>
        </div>
      </div>
</article>