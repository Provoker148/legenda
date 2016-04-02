<!-- webme - additional fields - mod - start //-->
	<?php if ($product_id) { ?>
	
	<style type="text/css">
	.w_additional_fields_list {width: 100%; border: 1px solid #CCCCCC;}
	.w_additional_fields_list #w_additional_fields_tbl_title {text-align: center;}
	.w_additional_fields_list #w_additional_fields_tbl_empty {text-align: center;}
	.w_additional_fields_list td {border: 1px solid #CCCCCC;}
	
	.where_get_orders {width: 100%; font-weight:bold; color:#000000;}
	
	.w_af_row input {width: 90%; color:#000000;}
	
	#waf_result {display: none;}
	</style>
	<div id="w_additional_fields">
		<div align="right"><a id="w_af_add" class="button"><span><?php echo $entry_w_additional_fields_add; ?></span></a></div>
		<br />
		<div id="w_additional_fields_list">
			<div id="waf_result"></div>
			<table id="w_additional_fields_tbl" class="w_additional_fields_list" cellpadding="4" cellspacing="0">
				<tr id="w_additional_fields_tbl_title">
					<td width="25%"><?php echo $column_field_name; ?></td>
					<td width="50%"><?php echo $column_field_value; ?></td>
					<td width="15%"><?php echo $column_status; ?></td>
					<td width="10%"><?php echo $column_actions; ?></td>
				</tr>
			<?php if ($w_additional_fields) { ?>
				<?php foreach ($w_additional_fields as $waf) { ?>
				<tr align="center" class="w_af_row" id="<?php echo $waf["field_id"]; ?>_waf_row">
					<td><input type="text" name="w_af['name'][<?php echo $waf["field_id"]; ?>]" id="<?php echo $waf["field_id"]; ?>_name" value="<?php echo $waf["field_name"]; ?>"></td>
					<td><input type="text" name="w_af['value'][<?php echo $waf["field_id"]; ?>]" id="<?php echo $waf["field_id"]; ?>_value" value="<?php echo $waf["field_value"]; ?>"></td>
					<td>
						<select name="w_af['status'][<?php echo $waf["field_id"]; ?>]" id="<?php echo $waf["field_id"]; ?>_status">
						<?php if ($waf["status"]) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
						</select>
					</td>
					<td>
					<input type="hidden" name="w_af['id'][<?php echo $waf["field_id"]; ?>]" id="<?php echo $waf["field_id"]; ?>_id" value="<?php echo $waf["field_id"]; ?>" >
					<img id="w_af_img_<?php echo $waf["field_id"]; ?>_remove" onclick="w_af_delete('<?php echo $waf["field_id"]; ?>'); return false;" src="view/image/waf/waf_delete_inactive_32x32_grey_iconza.png" width="22" height="22" alt="<?php echo $entry_w_additional_fields_delete; ?>" title="<?php echo $entry_w_additional_fields_delete; ?>" onmouseover="$(this).attr('src', 'view/image/waf/waf_delete_active_32x32_red_iconza.png');" onmouseout="$(this).attr('src', 'view/image/waf/waf_delete_inactive_32x32_grey_iconza.png');" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="w_af_img_<?php echo $waf["field_id"]; ?>_save" onclick="w_af_save('<?php echo $waf["field_id"]; ?>'); return false;" src="view/image/waf/waf_save_inactive_32x32_grey_iconza.png" width="22" height="22" alt="<?php echo $entry_w_additional_fields_save; ?>" title="<?php echo $entry_w_additional_fields_save; ?>" onmouseover="$(this).attr('src', 'view/image/waf/waf_save_active_32x32_blue_iconza.png');"  onmouseout="$(this).attr('src', 'view/image/waf/waf_save_inactive_32x32_grey_iconza.png');" />
					</td>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<tr id="w_additional_fields_tbl_empty">
					<td colspan="4"><?php echo $entry_w_additional_fields_no_fields; ?></td>
				</tr>
			<?php } ?>
			</table>
		</div>
	</div>
	<script type="text/javascript"><!--
		var w_af_row = 1;
		$('#w_af_add').click(function() {
			
			var new_af = '';
			
			new_af += '<tr align="center" id="new_'+w_af_row+'_waf_row" class="w_af_row">';
			new_af += '<td><input type="text" name="w_af[\'name\'][\'new_'+w_af_row+'\']" id="new_'+w_af_row+'_name"></td>';
			new_af += '<td><input type="text" name="w_af[\'value\'][\'new_'+w_af_row+'\']" id="new_'+w_af_row+'_value"></td>';
			new_af += '<td>';
			new_af += '<select name="w_af[\'status\'][\'new_'+w_af_row+'\']" id="new_'+w_af_row+'_status">';
			new_af += '<option value="1"><?php echo $text_enabled; ?></option>';
			new_af += '<option value="0"><?php echo $text_disabled; ?></option>';
			new_af += '</select>';
			new_af += '</td>';
			new_af += '<td>';
			new_af += '<input type="hidden" name="w_af[\'id\'][\'new_'+w_af_row+'\']" id="new_'+w_af_row+'_id" value="new_'+w_af_row+'" >';
			new_af += '<img id="w_af_img_new_'+w_af_row+'_remove" onclick="w_af_remove(\'new_'+w_af_row+'\'); return false;" src="view/image/waf/waf_remove_inactive_32x32_grey_iconza.png" width="22" height="22" alt="<?php echo $entry_w_additional_fields_remove; ?>" title="<?php echo $entry_w_additional_fields_remove; ?>" onmouseover="$(this).attr(\'src\', \'view/image/waf/waf_remove_active_32x32_red_iconza.png\');" onmouseout="$(this).attr(\'src\', \'view/image/waf/waf_remove_inactive_32x32_grey_iconza.png\');" />';
			new_af += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="w_af_img_new_'+w_af_row+'_save" onclick="w_af_save(\'new_'+w_af_row+'\'); return false;" src="view/image/waf/waf_save_inactive_32x32_grey_iconza.png" width="22" height="22" alt="<?php echo $entry_w_additional_fields_save; ?>" title="<?php echo $entry_w_additional_fields_save; ?>" onmouseover="$(this).attr(\'src\', \'view/image/waf/waf_save_active_32x32_blue_iconza.png\');"  onmouseout="$(this).attr(\'src\', \'view/image/waf/waf_save_inactive_32x32_grey_iconza.png\');" />';
			new_af += '</td>';
			new_af += '</tr>';
			
			//$('#w_additional_fields_tbl_empty').remove();
			$('#w_additional_fields_tbl').append(new_af);
			
			w_af_row++;
			
			return false;
		});
		
		function w_af_remove(row_id) {
			$('#'+row_id+'_waf_row').remove();
		}
		
		function w_af_save(row_id) {
			
			var waf_error = '';
			
			var waf_name = $('#'+row_id+'_name').val();
			var waf_value = $('#'+row_id+'_value').val();
			var waf_status = $('#'+row_id+'_status').val();
			var waf_id = $('#'+row_id+'_id').val();
			
			if (waf_name == '' || waf_name == 'undefined') {
				waf_error += '<?php echo $error_w_additional_fields_name; ?>';
			}
			
			if (waf_value == '' || waf_value == 'undefined') {
				if  (waf_error != '') {
					waf_error += '<br />';
				}
				waf_error += '<?php echo $error_w_additional_fields_value; ?>';
			}
			
			if (waf_error == '') {
				$.ajax({
					type: 'POST',
					url: 'index.php?route=catalog/webme_additional_fields/waf_add&product_id=<?php echo $product_id; ?>&token=<?php echo $token; ?>',
					dataType: 'html',
					data: 'waf_name='+waf_name+'&waf_value='+waf_value+'&waf_status='+waf_status+'&waf_id='+waf_id,
					beforeSend: function() {
					},
					complete: function() {
					},
					success: function(html) {
						$('#waf_result').removeClass();
						$('#waf_result').addClass('success');
						$('#waf_result').html(html);
						$('#waf_result').fadeIn('3000');
						
						$('#'+row_id+'_waf_row :input').css({
							'border-color': '#008800',
							'background-color': '#E4F1C9'
						});
					}
				});
			} else {
				$('#waf_result').removeClass();
				$('#waf_result').addClass('warning');
				$('#waf_result').html(waf_error);
				$('#waf_result').fadeIn('2000');
				
				//$('#'+row_id+'_waf_row :input').css('border-color', '#FF0000');
				$('#'+row_id+'_waf_row :input').css({
					'border-color': '#FF9999',
					'background-color': '#FFDFE0'
				});
			}
		}
		
		function w_af_delete(row_id) {
			if (confirm('<?php echo $text_waf_confirm_delete; ?>')) {
				
				//alert(row_id);
				//var waf_id = $('#'+row_id+'_id').val();
				
				var waf_id = row_id;
				$.ajax({
					type: 'POST',
					url: 'index.php?route=catalog/webme_additional_fields/waf_delete&product_id=<?php echo $product_id; ?>&token=<?php echo $token; ?>',
					dataType: 'html',
					data: 'waf_id='+waf_id,
					beforeSend: function() {
					},
					complete: function() {
						$('#'+row_id+'_waf_row').remove();
					},
					success: function(html) {
						$('#waf_result').removeClass();
						$('#waf_result').addClass('success');
						$('#waf_result').html(html);
						$('#waf_result').fadeIn('3000');
					}
				});
			} else {
				return false;
			}
		}
	//--></script>
	
	<?php } ?>
<!-- webme - additional fields - mod - end //-->