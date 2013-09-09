<?
$this->arCategory['name'] = (isset($this->arCategory['name']))? $this->arCategory['name'] : '';
$this->arCategory['text'] = (isset($this->arCategory['text']))? $this->arCategory['text'] : '';


?>

<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend><?=$this->pageName;?></legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Название</label>
  <div class="controls">
    <input id="textinput" name="cat[name]" type="text" class="input-xlarge" required="" value="<?=$this->arCategory['name'];?>">
  </div>
</div>
<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Родительская категория</label>
  <div class="controls">
    <select id="selectbasic" name="cat[parent]" class="input-xlarge">
      <option value="">root</option>
    	<?
//var_dump($this->arToTree);
    	foreach ($this->arToTree as $item) {?>
      <?

      ?>
    		<option <?if( isset($this->arCategory['parent']) && ($item['_id'] == $this->arCategory['parent'])){echo 'selected';}?> value="<?=$item['_id']?>" >
          <?=str_repeat("&nbsp;", $item['level']*2);?>  <?=$this->arCategoriesInfo[$item['_id']];?></option>
    	<?}?>
    </select>
  </div>
</div>
<!-- Textarea -->
<div class="control-group">
  <label class="control-label">Описание</label>
  <div class="controls">                     
    <textarea id="textarea" name="cat[text]"><?=$this->arCategory['text']?></textarea>
  </div>
</div>
<!-- Button -->
<div class="control-group">
  <div class="controls">
  	<input  type="hidden" type="text" name="<?=$this->type?>" value="1">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Сохранить</button>
  </div>
</div>

</fieldset>
</form>
