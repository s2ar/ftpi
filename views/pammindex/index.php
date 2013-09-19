<article> 
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
                <th>имя</th>
                <th>мат.ожидание</th>
                <th>сред.квадрат. отклонение</th>
                <th>мат/сред * 100</th>
                <th>дата обновления</th>
                <th>действия</th>             
              </tr>
            </thead>
<?
foreach ($this->arIndexes as $index) {
  ?><tr>
    <td><a href="/pammindex/view/<?=$index['name'];?>"><?=$index['name']?></a></td>
    <td><?=$index['mean']?></td>
    <td><?=$index['st_deviat']?></td>
    <td><?=round($index['mean']/$index['st_deviat'],2)*100?></td>
    <td><?=date('d.m.Y', $index['date_create']->sec)?></td>
    <td><a href="/pammindex/update/<?=$index['name'];?>">обновить</a></td>

  </tr><?
}
?> 
         
               
              </table>
            </div><!-- /example -->
          </div>
        </div>
      </div>
</article>