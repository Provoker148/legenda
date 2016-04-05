<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ($success) { ?>
	<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons">
	<a onclick="$('#form input[name=apply]').val(1); $('#form').submit();" class="button"><?php echo $button_apply; ?></a>
	<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  
  <div class="content">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
	<table id="module" class="list">
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_addtocart_logic; ?></td>
	<td style="padding:10px;">
	<input type="checkbox" name="popupcart_extended_module_addtocart_logic" value="1" <?php if ($popupcart_extended_module_addtocart_logic) { echo 'checked="checked"'; } ?> />
	&nbsp; Если не отмечено, то просто будет меняться надпись на кнопке
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_click_on_cart; ?></td>
	<td style="padding:10px;">
	<input type="checkbox" name="popupcart_extended_module_click_on_cart" value="1" <?php if ($popupcart_extended_module_click_on_cart) { echo 'checked="checked"'; } ?> />
	&nbsp; Если не отмечено, то просто будет стандартный блок корзины
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_related_show; ?></td>
	<td style="padding:10px;">
	<input type="checkbox" name="popupcart_extended_module_related_show" value="1" <?php if ($popupcart_extended_module_related_show) { echo 'checked="checked"'; } ?> />
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_related_heading; ?></td>
	<td style="padding:10px;">
	<?php foreach ($languages as $language) { ?>
	<input type="text" size="40" name="popupcart_extended_module_related_heading[<?php echo $language['code']; ?>]" value="<?php if ($popupcart_extended_module_related_heading[$language['code']]) { echo $popupcart_extended_module_related_heading[$language['code']]; } else { echo $entry_related_heading; } ?>">
	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />	
	<br />
	<?php } ?>
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_head; ?></td>
	<td style="padding:10px;">
	<?php foreach ($languages as $language) { ?>
	<input type="text" size="40" name="popupcart_extended_module_head[<?php echo $language['code']; ?>]" value="<?php if ($popupcart_extended_module_head[$language['code']]) { echo $popupcart_extended_module_head[$language['code']]; } else { echo $entry_head; } ?>">
	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />	
	<br />
	<?php } ?>		
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_button_name_shopping_show; ?></td>
	<td style="padding:10px;">
	<input type="checkbox"  name="popupcart_extended_module_button_shopping_show" value="1" <?php if ($popupcart_extended_module_button_shopping_show) { echo 'checked="checked"'; } ?> />
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_button_name_shopping; ?></td>
	<td style="padding:10px;">
	<?php foreach ($languages as $language) { ?>
	<input type="text" size="40" name="popupcart_extended_module_button_shopping[<?php echo $language['code']; ?>]" value="<?php if ($popupcart_extended_module_button_shopping[$language['code']]) { echo $popupcart_extended_module_button_shopping[$language['code']]; } else { echo $entry_button_name_shopping; } ?>">
	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />	
	<br />
	<?php } ?>		
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px; background:url('http://oc-dev.ru/image/bg.png')"><?php echo $text_button_name_cart_show; ?></td>
	<td style="padding:10px;">
	<input type="checkbox"  name="popupcart_extended_module_button_cart_show" value="1" <?php if ($popupcart_extended_module_button_cart_show) { echo 'checked="checked"'; } ?> />
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_button_name_cart; ?></td>
	<td style="padding:10px;">
	<?php foreach ($languages as $language) { ?>
	<input type="text" size="40" name="popupcart_extended_module_button_cart[<?php echo $language['code']; ?>]" value="<?php if ($popupcart_extended_module_button_cart[$language['code']]) { echo $popupcart_extended_module_button_cart[$language['code']]; } else { echo $entry_button_name_cart; } ?>">
	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />	
	<br />
	<?php } ?>		
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_button_name_checkout; ?></td>
	<td style="padding:10px;">
	<?php foreach ($languages as $language) { ?>
	<input type="text" size="40" name="popupcart_extended_module_button_checkout[<?php echo $language['code']; ?>]" value="<?php if ($popupcart_extended_module_button_checkout[$language['code']]) { echo $popupcart_extended_module_button_checkout[$language['code']]; } else { echo $entry_button_name_checkout; } ?>">
	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />	
	<br />
	<?php } ?>		
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_manufacturer_show; ?></td>
	<td style="padding:10px;">
	<input type="checkbox" name="popupcart_extended_module_manufacturer_show" value="1" <?php if ($popupcart_extended_module_manufacturer_show) { echo 'checked="checked"'; } ?> />
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_button_name_incart_logic; ?></td>
	<td style="padding:10px;">
	<input type="radio" id="logic0" name="popupcart_extended_module_button_incart_logic" value="0" <?php if (!$popupcart_extended_module_button_incart_logic) { echo 'checked="checked"'; } ?> /><label for="logic0"><?php echo $text_button_name_incart_logic_label0; ?></label>
	<input type="radio" id="logic1" name="popupcart_extended_module_button_incart_logic" value="1" <?php if ($popupcart_extended_module_button_incart_logic) { echo 'checked="checked"'; } ?> /><label for="logic1"><?php echo $text_button_name_incart_logic_label1; ?></label>
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_button_name_incart; ?></td>
	<td style="padding:10px;">
	<?php foreach ($languages as $language) { ?>
	<input type="text" size="40" name="popupcart_extended_module_button_incart[<?php echo $language['code']; ?>]" value="<?php if ($popupcart_extended_module_button_incart[$language['code']]) { echo $popupcart_extended_module_button_incart[$language['code']]; } else { echo $entry_button_name_incart; } ?>">
	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />	
	<br />
	<?php } ?>	
	</td>
	</tr>
	<tr>
	<td style="width:250px; padding:10px;"><?php echo $text_button_name_incart_with_options; ?></td>
	<td style="padding:10px;">
	<?php foreach ($languages as $language) { ?>
	<input type="text" size="40" name="popupcart_extended_module_button_incart_with_options[<?php echo $language['code']; ?>]" value="<?php if ($popupcart_extended_module_button_incart_with_options[$language['code']]) { echo $popupcart_extended_module_button_incart_with_options[$language['code']]; } else { echo $entry_button_name_incart_with_options; } ?>">
	<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />	
	<br />
	<?php } ?>		
	</td>
	</tr>
	</table>
	<input type="hidden" name="apply" value="0" />
    </form>
	<div id="copyright"><?php echo $text_copyright; ?></div>
  </div>
</div>
<?php echo $footer; ?>