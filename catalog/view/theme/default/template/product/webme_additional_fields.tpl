<!-- webme - additional fields - mod - start //-->
	<?php if ($w_additional_fields) { ?>
	
	<style type="text/css">
	.w_additional_fields_list {width: 100%; border: 1px solid #CCCCCC;}
	.w_additional_fields_list td {border: 1px solid #CCCCCC;}
	</style>
	<div id="w_additional_fields_list">
		<table id="w_additional_fields_tbl" class="w_additional_fields_list" cellpadding="4" cellspacing="0">
			<?php foreach ($w_additional_fields as $waf) { ?>
			<tr class="w_af_row" id="<?php echo $waf["field_id"]; ?>_waf_row">
				<td><?php echo $waf["field_name"]; ?></td>
				<td><?php echo $waf["field_value"]; ?></td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<?php } ?>
<!-- webme - additional fields - mod - end //-->