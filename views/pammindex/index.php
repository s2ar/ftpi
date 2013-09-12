<article>
    

<div id="chartdiv" style="width: 100%; height: 362px;"></div>
<script src="/public/js/charts.js"></script>


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
                <th>Имя</th>
                <th>Column heading</th>
                <th>Column heading</th>
              </tr>
            </thead>
<?
foreach ($this->arIndexes as $index) {
  ?><tr>
    <td><a href="/pammindex/view/<?=$index['name'];?>"><?=$index['name']?></a></td>
    <td>Column content</td>
    <td>Column content</td>
  </tr><?
}
?> 
         
               
              </table>
            </div><!-- /example -->
          </div>
        </div>
      </div>
</article>