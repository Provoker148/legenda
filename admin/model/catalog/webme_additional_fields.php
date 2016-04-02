<?php
class ModelCatalogWebmeAdditionalFields extends Model {
	
	public function checkInstall() {
		$sql = "
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."w_additional_fields` (
					`field_id` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`field_name` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					`field_value` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					`product_id` INT( 11 ) NOT NULL ,
					`status` ENUM( '0', '1' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1',
					`date_added` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
					)
				ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci
				";
		$query = $this->db->query($sql);
	}
	
	public function waf_getFields($product_id) {
		$fieldsData = array();
		
		$sql = "SELECT * FROM `" . DB_PREFIX . "w_additional_fields` WHERE `product_id` = '".(int)$product_id."' ORDER BY `field_id` ASC";
		$query = $this->db->query($sql);
		
		$fieldsData = $query->rows;
		
		return ( $fieldsData );
	}
	
	
	public function waf_add($product_id, $field_name, $field_value, $status=0, $waf_id=0) {
		
		$waf_pos = strpos($waf_id, "new");
		
		if ($waf_id < 1) {
			$sql = "INSERT INTO ";
		} else {
			$sql = "UPDATE ";
		}
		
		//print_r($waf_id);
		
		if ($waf_pos !== false) {
			$set_field_id = "`field_id` = NULL, ";
			$where_field_id = "";
		} else {
			$set_field_id = "";
			$where_field_id = " WHERE `field_id` = '".(int)$waf_id."'";
		}
		
		$sql .= "`" . DB_PREFIX . "w_additional_fields` SET `product_id` = '" . (int)$product_id . "', ".$set_field_id." `field_name` = '".$this->db->escape($field_name)."', `field_value` = '".$this->db->escape($field_value)."', `status` = '".(int)$status."' ".$where_field_id."";
		$query = $this->db->query($sql);
		
		//print_r($sql);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function waf_delete($product_id, $waf_id=0) {
		
		if ($waf_id < 1 || $product_id < 1) {
			return false;
		}
		
		$sql = "DELETE FROM `" . DB_PREFIX . "w_additional_fields` WHERE `product_id` = '" . (int)$product_id . "' AND `field_id` = '".(int)$waf_id."'";
		if ($this->db->query($sql)) {
			return true;
		} else {
			return false;
		}
		
	}
	
}
?>