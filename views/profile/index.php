<div class="page-header">
    <h1>Профили</h1>

    <div class="btn-group">
      <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" href="#">
        Создать <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- dropdown menu links -->
        <?foreach ($this->arCategories as $id => $name) {?>
           <li><a href="/profile/add?set=<?=$id?>"><?=$name?></a></li>
        <?}?>  
      </ul>
    </div> 
    <br><br> 
    <ul class="nav nav-pills">
      <li class="<?if(!isset($_GET['set'])){echo 'active';}?>">
        <a href="/profile">Все</a>
      </li>
      <?foreach ($this->arCategories as $id => $name) {?>
         <li class="<?if($_GET['set']==$id){echo 'active';}?>"><a href="/profile?set=<?=$id?>"><?=$name?></a></li>
      <?}?>   
    </ul>
  </div>

  <? if($this->arProfiles){ ?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Название</th>      
        <th>Примечание</th>
        <th>Категории</th>
        <th>Корневая категория</th>
        <th>ID</th>   
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?$i=1;?>
      <?foreach ($this->arProfiles as $profile): 
        $profile['help'] = (isset($profile['help']))? $profile['help'] : '';
      ?> 
      <tr>
        <td><?=$i;?></td>
        <td><a href="/profile/edit/<?=$profile['_id']?>"><?=$profile['p_name']?></a></td>
        <td><?=$profile['help']?></td>        
        <td><?=implode(", ", $profile['p_categories'])?></td> 
        <td><?=$this->arCategories[(string)$profile['p_set']]?></td>        
        <td><?=$profile['_id']?></td>   
        <td>
          <form action="/profile/delete" method="post">
          <button onclick="return confirm('Удалить профиль?')" class="label label-warning">delete</button>
          <input type="hidden" name='id' value='<?=$profile['_id']?>'>
          </form>
        </td>        
      </tr>
      <?$i++;?>
      <?endforeach;?>   
    </tbody>
  </table>
  <?}else{?>
    <span class="text-error">Профили не созданы</span>
  <?}?>
  <?=$this->pagin;?>
