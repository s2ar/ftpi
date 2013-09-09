<?
$this->arField['name']  = (isset($this->arField['name']))? $this->arField['name'] : '';
$this->arField['help']  = (isset($this->arField['help']))? $this->arField['help'] : '';
$this->arField['type']  = (isset($this->arField['type']))? $this->arField['type'] : '';
$this->arField['set']   = (isset($this->arField['set']))? $this->arField['set'] : '';
$this->arField['order'] = (isset($this->arField['order']))? $this->arField['order'] : '';
?>

<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend><?=$this->pageName;?></legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Название</label>
  <div class="controls">
    <input id="name" name="field[name]" type="text" value="<?=$this->arField['name']?>" placeholder="введите название" class="input-xlarge" required="">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Подсказка о заполнении</label>
  <div class="controls">
    <textarea id="help" name="field[help]" placeholder="подсказка" class="input-xlarge" required=""><?=$this->arField['help']?></textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Тип поля</label>
  <div class="controls">
    <select id="type" name="field[type]" class="input-xlarge">
    	<?foreach ($this->field_types as $t) {?>
  			<option  <?if($t==$this->arField['type']){echo 'selected';}?> value="<?=$t?>"><?=$t?></option>
      	<?}?> 
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Категория</label>
  <div class="controls">
    <select id="set" name="field[set]" class="input-xlarge">
    	<?foreach ($this->arTopCategoties as $cat) {?>
  			<option <?if($cat['_id']==$this->arField['set']){echo 'selected';}?> value="<?=$cat['_id']?>"><?=$cat['name']?></option>
      	<?}?> 
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Состояние</label>
  <div class="controls">
    <select id="visible" name="field[visible]" class="input-xlarge">
      <option value="1">включено</option>
      <option value="0">выключено</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Порядок полей</label>
  <div class="controls">
    <input id="order" name="field[order]" value="<?=$this->arField['order']?>" type="text" placeholder="порядок" class="input-xlarge" required="">
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
