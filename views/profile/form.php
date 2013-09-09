<?
$this->arProfile['p_name'] = (isset($this->arProfile['p_name']))? $this->arProfile['p_name'] : '';
$this->arProfile['p_seo'] = (isset($this->arProfile['p_seo']))? $this->arProfile['p_seo'] : '';
$this->arProfile['p_enable'] = (isset($this->arProfile['p_enable']))? $this->arProfile['p_enable'] : '';
$this->arProfile['p_categories'] = (isset($this->arProfile['p_categories']))? $this->arProfile['p_categories'] : '';

?>
<link href="/public/css/datepicker.css" rel="stylesheet" media="screen">

<script src="/public/js/bootstrap-datepicker.js"></script>
<script src="/public/js/locales/bootstrap-datepicker.ru.js"></script>
<script src="/libs/tinymce/tinymce.min.js"></script>


<form class="form-horizontal" method="post">
<fieldset>

<!-- Form Name -->
<legend><?=$this->pageName;?></legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Название</label>
  <div class="controls">
    <input id="textinput" name="p[p_name]" type="text" class="input-xlarge" required="" value="<?=$this->arProfile['p_name']?>">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">SEO</label>
  <div class="controls">
    <input id="textinput" name="p[p_seo]" type="text" class="input-xlarge"  value="<?=$this->arProfile['p_seo']?>">
  </div>
</div>

<!-- Checkboxes -->
<div class="control-group">
  <label class="control-label">Показывать</label>
  <div class="controls">
    <label class="checkbox">
      <input type="checkbox" <?if($this->arProfile['p_enable']){echo 'checked';}?> name="p[p_enable]" value="1">    
    </label>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Категории</label>
  <div class="controls">
    <select id="selectbasic" name="p[p_categories][]" class="input-xlarge"  multiple="multiple" required="">
      <?
      // При создании профиля, массив должен быть пуст
      $arCatProf = ($this->arProfile['p_categories']) ? $this->arProfile['p_categories'] : array();
          //var_dump($this->arToTree);
    	foreach ($this->arToTree as $item) {?>
      <?

      ?>
    		<option <?if(in_array($item['_id'], $arCatProf)){echo 'selected';}?> value="<?=$item['_id']?>" >
          <?=str_repeat("&nbsp;", $item['level']*2);?>  <?=$this->arCategoriesInfo[$item['_id']];?></option>
    	<?}?>
    </select>
  </div>
</div>

<?=$this->fields?>

<!-- Button -->
<div class="control-group">
  <div class="controls">
    <input  type="hidden" type="text" name="p[p_set]" value="<?=$this->set?>">
  	<input  type="hidden" type="text" name="<?=$this->type?>" value="1">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Сохранить</button>
  </div>
</div>

</fieldset>
</form>

<script>
$(function() {
  $('.datepicker').datepicker({
    language: 'ru',
     format: 'yyyy/mm/dd',
  });

  tinymce.init({
      selector: "textarea",
      plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table contextmenu paste moxiemanager"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
  });


})
</script>