<?php

//  Live Price / Динамическое обновление цены - живая цена
//  Support: support@liveopencart.com / Поддержка: opencart@19th19th.ru

?>
<?php echo $header; ?>
<div id="content">
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php if ( isset($error_warning) && $error_warning ) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>

<?php if ( isset($success) && $success ) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

<div class="box">
  <div class="heading">
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
  </div>
  <div class="content">
		<div>
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				
				<?php echo $module_description; ?>
				
				<table class="form">
					<tbody>
						<tr>
							<td>
							</td>
							<td>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo $entry_multiplied_price; ?>
							</td>
							<td style="width: 100px;">
								<input type="checkbox" name="liveprice_settings[multiplied_price]" value="1" <?php if (isset($liveprice_settings['multiplied_price']) && $liveprice_settings['multiplied_price']) echo "checked"; ?> >
							</td>	
							<td>	
								
							</td>
						</tr>
						<tr>
							<td>
								<?php echo $entry_discount_quantity; ?>
								<?php
									$discount_quantity = 0;
									if (isset($liveprice_settings['discount_quantity'])) {
										$discount_quantity = $liveprice_settings['discount_quantity'];
									}
								?>
							</td>
							<td style="width: 100px;">
								<select id="discount_quantity" name="liveprice_settings[discount_quantity]">
									<option value="0" <?php if ($discount_quantity==0) echo "selected"; ?> ><?php echo $text_discount_quantity_0; ?></option>
									<option value="1" <?php if ($discount_quantity==1) echo "selected"; ?> ><?php echo $text_discount_quantity_1; ?></option>
									<option value="2" <?php if ($discount_quantity==2) echo "selected"; ?> ><?php echo $text_discount_quantity_2; ?></option>
								</select>
							<td>	
								<span class="help" style="display: none;" id="text_relatedoptions_notify"><?php echo $text_relatedoptions_notify; ?></span>
							</td>
						</tr>
					</tbody>
				</table>
			
				<br>
				<?php /*
				<a onclick="$(this).hide();$('#module').show();"><?php echo $text_edit_position; ?></a>
				<table id="module" class="list" style="width: 500px; display: none">
					<thead>
						<tr>
							<td class="left"><?php echo $entry_layout; ?></td>
							<!--
							<td class="left"><?php echo $entry_position; ?></td>
							<td class="left"><?php echo $entry_status; ?></td>
							<td class="right"><?php echo $entry_sort_order; ?></td>
							-->
							<td style="width:200px;"></td>
						</tr>
					</thead>
					<?php $module_row = 0; ?>
					<?php foreach ($modules as $module) { ?>
					<tbody id="module-row<?php echo $module_row; ?>">
						<tr>
							<td class="left"><select name="liveprice_module[<?php echo $module_row; ?>][layout_id]">
									<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $module['layout_id']) { ?>
									<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
								<input type="hidden" name="liveprice_module[<?php echo $module_row; ?>][position]" value="content_bottom">
								<input type="hidden" name="liveprice_module[<?php echo $module_row; ?>][status]" value="1">
								<input type="hidden" name="liveprice_module[<?php echo $module_row; ?>][sort_order]" value="0">
							</td>
							<td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
						</tr>
					</tbody>
					<?php $module_row++; ?>
					<?php } ?>
					<tfoot>
						<tr>
							<td colspan="1"></td>
							<td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
						</tr>
					</tfoot>
				</table>
				*/ ?>
			</form>
			
			
			<?php echo $entry_we_recommend; ?> <button id="show_we_recommend" onclick="$('#we_recommend').show();$('#show_we_recommend').remove();"><?php echo $entry_show_we_recommend; ?></button>
			<br>
			<table id="we_recommend" style="display: none; max-width: 700px;"><tr><td>
				
				<?php echo $text_we_recommend; ?>
			</td></tr></table>
			<br>
			<br>
			
		</div>
		<div>
		<span class="help"><?php echo $module_info; ?></span><br><span class="help" style="font-size: 9px"><?php echo $module_copyright; ?></span>
		</div>
  </div>
	
	
</div>
<script type="text/javascript"><!--

function checkRelatedOptionsNotify() {
	
	if ( $('#discount_quantity').val() == "2" ) {
		$('#text_relatedoptions_notify').show();
	} else {
		$('#text_relatedoptions_notify').hide();
	}
	
}

$(document).ready(function(){
	
	$('#discount_quantity').change(function(){
		checkRelatedOptionsNotify();
	});
	
	checkRelatedOptionsNotify();
	
});


//--></script>
<?php echo $footer; ?>