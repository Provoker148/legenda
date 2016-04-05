<?php
// Related Options / Связанные опции
// Support: support@liveopencart.com / Поддержка: help@liveopencart.ru
?>
<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if (isset($success) && $success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if (isset($updated) && $updated) { ?>
  <div class="success"><?php echo $updated; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  
  <?php
 
  ?>
  
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      
      <div id="tabs" class="htabs"> 
        <a href="#tab-settings"><?php echo $entry_settings; ?></a>
        <a href="#tab-additional"><?php echo $entry_additional; ?></a>
        <a href="#tab-export"><?php echo $entry_export; ?></a>
        <a href="#tab-import"><?php echo $entry_import; ?></a>
        <a href="#tab-about"><?php echo $entry_about; ?></a>
      </div>
      
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      
        <div id="tab-settings">
               
          <table class="form">
            <tr>
              <td>
                <?php echo $entry_update_quantity; ?>:
              </td>
              <td width="130">
                <input type="checkbox" name="related_options[update_quantity]" value="1" <?php  if(isset($modules['update_quantity']) && $modules['update_quantity']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_update_quantity_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_update_options; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[update_options]" value="1" <?php  if(isset($modules['update_options']) && $modules['update_options']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_update_options_help; ?></span>
              </td>
            </tr>
            
            <tr>
              <td>
                <?php echo $entry_subtract_stock; ?>:
              </td>
              <td>
                <select name="related_options[subtract_stock]">
                  <option value="0" <?php  if( !isset($modules['subtract_stock']) || (int)$modules['subtract_stock'] == 0) echo "selected"; ?>><?php echo $text_subtract_stock_from_product; ?></option>
                  <option value="1" <?php  if( isset($modules['subtract_stock']) && (int)$modules['subtract_stock'] == 1) echo "selected"; ?>><?php echo $text_subtract_stock_from_product_first_time; ?></option>
                  <option value="2" <?php  if( isset($modules['subtract_stock']) && (int)$modules['subtract_stock'] == 2) echo "selected"; ?>><?php echo $text_yes; ?></option>
                  <option value="3" <?php  if( isset($modules['subtract_stock']) && (int)$modules['subtract_stock'] == 3) echo "selected"; ?>><?php echo $text_no; ?></option>
                </select>
              </td>
              <td>
                <span class="help"><?php echo $entry_subtract_stock_help; ?></span>
              </td>
            </tr>
           
            <tr>
              <td>
                <?php echo $entry_edit_columns; ?>:
              </td>
              <td>
                <select name="related_options[edit_columns]">
                  <option value="0" <?php  if( !isset($modules['edit_columns']) || (int)$modules['edit_columns'] == 0) echo "selected"; ?>><?php echo $entry_edit_columns_0; ?></option>
                  <option value="2" <?php  if( isset($modules['edit_columns']) && (int)$modules['edit_columns'] == 2) echo "selected"; ?>><?php echo $entry_edit_columns_2; ?></option>
                  <option value="3" <?php  if( isset($modules['edit_columns']) && (int)$modules['edit_columns'] == 3) echo "selected"; ?>><?php echo $entry_edit_columns_3; ?></option>
                  <option value="4" <?php  if( isset($modules['edit_columns']) && (int)$modules['edit_columns'] == 4) echo "selected"; ?>><?php echo $entry_edit_columns_4; ?></option>
                  <option value="5" <?php  if( isset($modules['edit_columns']) && (int)$modules['edit_columns'] == 5) echo "selected"; ?>><?php echo $entry_edit_columns_5; ?></option>
                  <option value="100" <?php  if( isset($modules['edit_columns']) && (int)$modules['edit_columns'] == 100) echo "selected"; ?>><?php echo $entry_edit_columns_100; ?></option>
                </select>
              </td>
              <td>
                <span class="help"><?php echo $entry_edit_columns_help; ?></span>
              </td>
            </tr>
            
            <tr>
              <td>
                <?php echo $entry_allow_zero_select; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[allow_zero_select]" value="1" <?php  if(isset($modules['allow_zero_select']) && $modules['allow_zero_select']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_allow_zero_select_help; ?></span>
              </td>
            </tr>  
            <tr>
              <td>
                <?php echo $entry_stock_control; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[stock_control]" value="1" <?php  if(isset($modules['stock_control']) && $modules['stock_control']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_stock_control_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_show_stock; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[show_stock]" value="1" <?php  if(isset($modules['show_stock']) && $modules['show_stock']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_show_stock_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_show_clear_options; ?>:
              </td>
              <td>
                <select name="related_options[show_clear_options]">
                  <option value="0" <?php  if(!isset($modules['show_clear_options']) || (int)$modules['show_clear_options']==0) echo "selected";?>><?php echo $option_show_clear_options_not; ?></option>
                  <option value="1" <?php  if(isset($modules['show_clear_options']) && (int)$modules['show_clear_options']==1) echo "selected";?>><?php echo $option_show_clear_options_top; ?></option>
                  <option value="2" <?php  if(isset($modules['show_clear_options']) && (int)$modules['show_clear_options']==2) echo "selected";?>><?php echo $option_show_clear_options_bot; ?></option>
                </select>
              </td>
              <td>
                <span class="help"><?php echo $entry_show_clear_options_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_hide_inaccessible; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[hide_inaccessible]" value="1" <?php  if(isset($modules['hide_inaccessible']) && $modules['hide_inaccessible']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_hide_inaccessible_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_select_first; ?>:
              </td>
              <td>
                <select name="related_options[select_first]">
                  <option value="0" <?php  if(!isset($modules['select_first']) || (int)$modules['select_first']==0) echo "selected";?>><?php echo $option_select_first_not; ?></option>
                  <option value="1" <?php  if(isset($modules['select_first']) && (int)$modules['select_first']==1) echo "selected";?>><?php echo $option_select_first; ?></option>
                  <option value="2" <?php  if(isset($modules['select_first']) && (int)$modules['select_first']==2) echo "selected";?>><?php echo $option_select_first_last; ?></option>
                </select>
              </td>
              <td>
                <span class="help"><?php echo $entry_select_first_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_step_by_step; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[step_by_step]" value="1" <?php  if(isset($modules['step_by_step']) && $modules['step_by_step']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_step_by_step_help; ?></span>
              </td>
            </tr>
            
            <tr>
              <td style="vertical-align: top">
                <?php echo $entry_ro_use_variants; ?><br>
                
              </td>
              <td colspan="2">
                <input type="checkbox" id="use_variants" name="related_options[use_variants]" value="1"  onclick="show_options_variants();" <?php  if(isset($modules['use_variants']) && $modules['use_variants']) echo "checked"; ?> >
                <br><br>
                
                <div id="options_variants" style="display: none">
                  
                  <table id="variants_list" class="list" style="width: 740px">
                    <thead>
                      <tr>
                        <td class="left" style="width: 250px"><?php echo $entry_ro_variant_name; ?></td>
                        <td class="left" ><?php echo $entry_ro_options; ?></td>
                        <td style="width: 170px"></td>
                      </tr>
                    </thead>
  
                  </table>
                  
                  <a onclick="add_new_variant();" class="button"><?php echo $entry_ro_add_variant; ?></a>
                  <br><br>
                  
                </div>
                
                
              </td>
            </tr>
            
          </table>
         
          <input type="hidden" name="related_options[related_options_version]" value="<?php echo $modules['related_options_version'].""; ?>">
      
        </div>
        
        
        <div id="tab-additional">
     
          <table class="form">          
            
            <tr>
              <td>
                <?php echo $entry_spec_model; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_model]" value="1" <?php  if(isset($modules['spec_model']) && $modules['spec_model']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_model_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_spec_sku; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_sku]" value="1" <?php  if(isset($modules['spec_sku']) && $modules['spec_sku']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_sku_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_spec_upc; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_upc]" value="1" <?php  if(isset($modules['spec_upc']) && $modules['spec_upc']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_upc_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_spec_location; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_location]" value="1" <?php  if(isset($modules['spec_location']) && $modules['spec_location']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_location_help; ?></span>
              </td>
            </tr>
            
            
            <tr>
              <td>
                <?php echo $entry_spec_weight; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_weight]" value="1" <?php  if(isset($modules['spec_weight']) && $modules['spec_weight']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_weight_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_spec_price; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_price]" value="1" <?php  if(isset($modules['spec_price']) && $modules['spec_price']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_price_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_spec_price_discount; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_price_discount]" value="1" <?php  if(isset($modules['spec_price_discount']) && $modules['spec_price_discount']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_price_discount_help; ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo $entry_spec_price_special; ?>:
              </td>
              <td>
                <input type="checkbox" name="related_options[spec_price_special]" value="1" <?php  if(isset($modules['spec_price_special']) && $modules['spec_price_special']) echo "checked"; ?> >
              </td>
              <td>
                <span class="help"><?php echo $entry_spec_price_special_help; ?></span>
              </td>
            </tr>
            
            <tr>
              <td>
                <?php echo $entry_ro_description; ?>:
              </td>
              <td>
                <select name="related_options[ro_description]">
                  <option value="0" <?php  if(!isset($modules['ro_description']) || (int)$modules['ro_description']==0) echo "selected";?>><?php echo $ro_description_not; ?></option>
                  <option value="1" <?php  if(isset($modules['ro_description']) && (int)$modules['ro_description']==1) echo "selected";?>><?php echo $ro_description_yes; ?></option>
                  <option value="2" <?php  if(isset($modules['ro_description']) && (int)$modules['ro_description']==2) echo "selected";?>><?php echo $ro_description_replace; ?></option>
                  <option value="3" <?php  if(isset($modules['ro_description']) && (int)$modules['ro_description']==3) echo "selected";?>><?php echo $ro_description_add; ?></option>
                </select>
              </td>
              <td>
                <span class="help"><?php echo $entry_ro_description_help; ?></span>
              </td>
            </tr>
            
          </table>  
      
        </div>
      </form>
      
      <div id="tab-export">
        <p><?php echo $entry_export_description; ?></p>
        <br>
        <form id="form_export" action="<?php echo $action_export; ?>" method="post" target="export_frame">
        <b><?php echo $entry_export_fields; ?></b><br><br>
        <?php
          $export_fields = array( "product_id"
                                 ,"relatedoptions_id"
                                 ,"product_model"
                                 ,"relatedoptions_model"
                                 ,"relatedoptions_sku"
                                 ,"relatedoptions_upc"
                                 ,"relatedoptions_location"
                                 ,"option_id"
                                 ,"option_name"
                                 ,"option_value_id"
                                 ,"option_value_name"
                                 ,"weight"
                                 ,"weight_prefix"
                                 ,"quantity"
                                 ,"price");
          
          foreach ($export_fields as $field) {
            echo "<input type='checkbox' name='export[".$field."]' id='export_".$field."' ".((isset($export[$field]) && $export[$field])?("checked"):(""))." value='1'><label for='export_".$field."'>".$field."</label><br>";
          }
        
        ?>
        <br><br>
        <?php if ($PHPExcelExists) { ?>
        <a class="button" onclick="$('#form_export').submit();"><?php echo $entry_export_get_file; ?></a>
        <?php } else { echo "<font style='color:red'>".$entry_PHPExcel_not_found.$PHPExcelPath."</font>"; } ?>
        </form>
        
        <!-- style="display: none" -->
        <iframe name="export_frame" src="" id="export_frame" style="display: none">
        </iframe>
        
      </div>
      
      <div id="tab-import">
        <p><?php echo $entry_import_description; ?></p>
        <br>
        <?php if ($PHPExcelExists) { ?>
        <input type="checkbox" name="import_delete_before" value="1" id="import_delete_before"><label for="import_delete_before"><?php echo $entry_import_delete_before; ?></label><br><br>
        <a id="button-upload" class="button"><?php echo $button_upload; ?></a>
        <span class="help"><?php echo $button_upload_help ?></span>
        <?php } else { echo "<font style='color:red'>".$entry_PHPExcel_not_found.$PHPExcelPath."</font>"; } ?>
        
        
        <br>
        <div id="import_result">
          
        </div>
        <br>
        <div id="import_result_text">
          
        </div>
      </div>
      
      <div id="tab-about">
        <p><?php echo $entry_about_description; ?></p>
      </div>
      
      <br>
      <br>
      <br>
      <span class="help">
        <?php echo $entry_ro_version.": ".$this->data['modules']['related_options_version']; ?> | <?php echo $text_ro_support; ?>
      </span>
      <br><span class="help" style="font-size: 9px"><?php echo $module_copyright; ?></span>
      
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script>
<script type="text/javascript"><!--
new AjaxUpload('#button-upload', {
  action: 'index.php?route=module/related_options/import&token=<?php echo $token; ?>',
  name: 'file',
  autoSubmit: true,
  responseType: 'text',
  onSubmit: function(file, extension) {
    $('#button-upload').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
    
    this.setData( {import_delete_before: ($("#import_delete_before").is(':checked') ? 1 : 0)} );
    
  },
  onComplete: function(file, result) {
    
    $('.loading').remove();
    
    $('#import_result_text').html("<?php echo $entry_server_response; ?>: "+result);

    json = jQuery.parseJSON(result);
    if (json['error']) {
      $('#import_result_text').html('Error: '+json['error']);
    } else {
      $('#import_result_text').html('<?php echo $entry_import_result; ?>: '+json['products']+'/'+json['relatedoptions']);
    }
  }
});
//--></script>

<script type="text/javascript">
  
  var variant_cnt = 0;
  var options_cnt = 0;
  var all_options = [];
  
  <?php
   foreach($options as $option_id => $option_name) {
    echo "all_options['".$option_id."']=\"".$option_name."\";";
   }
  ?>
  
  function add_option(elem_num, option_id) {
    
    var str_add = "";
    
    str_add += "<div id='variant_option"+options_cnt+"'>";
    str_add += "<select name='variants["+elem_num+"][options]["+options_cnt+"]' style=\"width: 180px;\">";
    
    for (var i = 0, length = all_options.length; i < length; i++) {
      if (i in all_options) {
        str_add += '<option value="'+i+'" '+((option_id==i)?("selected"):(""))+' >'+all_options[i]+'</option>';  
      }
    }
    
    str_add += "";
    str_add += "";
    str_add += "";
    str_add += "</select>";
    str_add += "<a style='margin-left:20px;' onclick=\"$('#variant_option"+options_cnt+"').remove();\"  title='<?php echo $entry_ro_delete_option; ?>'>XX</a></div>";
    
    options_cnt++;
    
    $('#variant_options'+elem_num).append("<tr><td style='border: 0px;'>"+str_add+"</td></tr>");
  }
  
  function add_new_variant() {
    add_variant('', '', '');
  }
  
  function add_variant(variant_id, variant_name, variant_options) {
    
    var str_add = "";
    str_add += "<tr id='variant"+variant_cnt+"'>";
    str_add += "<td style='vertical-align: top; padding: 10px;'>";
    str_add += '<input name="variants['+variant_cnt+'][name]" size=\'40\' value="'+variant_name+'">';
    str_add += "<input type='hidden' name='variants["+variant_cnt+"][id]' value='"+variant_id+"'>";
    str_add += "<div style=' text-align: right; padding: 7px;'><a onclick=\"add_option("+variant_cnt+",0);\" ><?php echo $entry_ro_add_option; ?></a></div>";
    str_add += "</td>";
    str_add += "<td style='vertical-align: top; padding: 10px;'>";
    str_add += "<table id='variant_options"+variant_cnt+"' style='border-spacing: 0px;'>";
    str_add += "</table>";
    str_add += "";
    str_add += "</td>";
    str_add += "<td class='right'><a onclick=\"$('#variant"+variant_cnt+"').remove();\" class='button'><?php echo $entry_ro_delete_variant; ?></a></td>";
    str_add += "";
    str_add += "</tr>";
    
    $('#variants_list').append(str_add);
    
    if (variant_options) {
      for (var i = 0, length = variant_options.length; i < length; i++) {
        if (i in variant_options) {
          add_option(variant_cnt, variant_options[i]);  
        }
      }
    }
    
    
    variant_cnt++;
    
  }
  
  
  function show_options_variants() {
    $('#options_variants')[0].style.display=$('#use_variants')[0].checked?'':'none'
  }
  
  $(document).ready(  function () {
    show_options_variants();
    
    <?php
      
      foreach ($variants_options as $vo_id => $vo_data) {
        
        $str_arr = "";
        foreach ($vo_data['options'] as $option_id => $option_name) {
          $str_arr .= ",".$option_id;
        }
        if ($str_arr != "") $str_arr = substr($str_arr, 1);
        echo "add_variant(".$vo_id.", \"".$vo_data['name']."\", [".$str_arr."]);";
        
      }
      
    ?>
    
  } );
  //                  $(document).ready( function () { show_options_variants(); } ');
  
</script>


<?php echo $footer; ?>