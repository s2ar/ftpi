
<div class="page-header">
    <h1>Поля</h1>

    <ul class="nav nav-pills">
      <li class="<?if(!isset($_GET['set'])){echo 'active';}?>">
        <a href="/field">Все</a>
      </li>
      <?foreach ($this->arCategories as $id => $name) {?>
         <li class="<?if($_GET['set']==$id){echo 'active';}?>"><a href="/field?set=<?=$id?>"><?=$name?></a></li>
      <?}?>   
    </ul>
  </div>

  <? if($this->arFields){ ?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Название</th>      
        <th>Подсказка</th>
        <th>Тип</th>
        <th>Набор</th>
        <th>Состояние</th>
        <th>Порядок</th>
        <th>ID</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?$i=1;?>
      <?foreach ($this->arFields as $field): ?> 
      <tr>
        <td><?=$i;?></td>
        <td><a href="/field/edit/<?=$field['_id']?>"><?=$field['name']?></a></td>
        <td><?=$field['help']?></td>        
        <td><?=$field['type']?></td> 
        <td><?=$this->arCategories[(string)$field['set']]?></td>        
        <td><? if($field['visible']==1){echo 'включено';}else{echo 'выключено';}?></td>        
        <td><?=$field['order']?></td>        
        <td><?=$field['_id']?></td>        
        <td>
          <form action="/field/delete" method="post">
          <button onclick="return confirm('При удалении будут затронуты данные в других коллекциях. Продолжить?')" class="label label-warning">delete</button>
          <input type="hidden" name='id' value='<?=$field['_id']?>'>
          </form>
        </td>        
      </tr>
      <?$i++;?>
      <?endforeach;?>   
    </tbody>
  </table>
  <?}else{?>
    <span class="text-error">Поля не созданы</span>
  <?}?>
  <?=$this->pagin;?>
