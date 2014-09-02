<article> 
  <div class="bs-docs-section">
  <div class="row">
    <div class="col-lg-12">
      <div class="page-header">
        <h1 id="tables">ПАММ Счета</h1>
          <a href="/pamm/add">Добавить</a>
      </div>

      <div class="bs-example">
        <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>имя</th>
                <th>% инвестору</th>
                <th>средняя доходность(для инвестора)</th>                
                <th>худшая неделя</th>
                <th>сред.квадрат. отклонение</th>
                <th>дата обновления</th>
                <th>действия</th>             
              </tr>
            </thead>
<?
$i=1;
foreach ($this->arIndexes as $index) {
  ?><tr>
    <td><?=$i?></td>
    <td><a href="/pamm/view/<?=$index['number'];?>"><?=$index['name']?></a></td>
    <td><?=$index['remuneration']*100?></td>
    <td><?=$index['mean']*$index['remuneration']?></td>
    <td><?=$index['min']?></td>    
    <td><?=$index['st_deviat']?></td>
   
    <td><?=date('d.m.Y', $index['date_create']->sec)?></td>
    <td><a href="/pamm/update/<?=$index['number'];?>">обновить</a></td>

  </tr><?
    $i++;
}
?> 
         
               
              </table>
            </div><!-- /example -->
        
	<div class="bs-example">
        <table>
    
<?
foreach ($this->arIndexes as $index) {
  ?><tr>
    <td><a href="/pamm/view/<?=$index['number'];?>"><?=$index['name']?></a></td>
    <td><?=$index['remuneration']?></td>
    <td><?=$index['mean']*$index['remuneration']/100?></td>
    <td><?=$index['min']/100?></td>    
  </tr><?
}
?> 
         
               
              </table>
            </div>
        
        
          </div>
        </div>
      </div>
</article>