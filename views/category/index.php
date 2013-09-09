 <div class="page-header">
    <h1>Категории</h1>
  </div>
  <? if($this->arCategories){ ?>
  <table class="table table-bordered table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>ID</th>
        <th>Название</th>      
        <th>Родительская категория</th>    
        <th>Описание</th>    
        <th></th>    
      </tr>
    </thead>
    <tbody>
      <?$i=1;?>
      <?foreach ($this->arCategories as $cat): ?> 
      <tr>
        <td><?=$i;?></td>
        <td><?=$cat['_id']?></td>  
        <td><a href="/category/edit/<?=$cat['_id']?>"><?=$cat['name']?></a></td>
        <td>
          <?if(isset($this->arCategoriesInfo[$cat['parent']]) && $this->arCategoriesInfo[$cat['parent']]){?>
          <a href="/category/edit/<?=$cat['parent']?>">
            <?=$this->arCategoriesInfo[$cat['parent']];  ?>
          </a>
          <?}else{?>
           root
          <?}?>
        </td>
        <td><?=$cat['text']?></td>
        <td>удалить</td>
      </tr>
      <?$i++;?>
      <?endforeach;?>   
    </tbody>
  </table>
  <?}else{?>
    <span class="text-error">Категории не созданы</span>
  <?}?>
  <?=$this->pagin;?>