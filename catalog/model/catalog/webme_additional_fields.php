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
		
		$sql = "SELECT * FROM `" . DB_PREFIX . "w_additional_fields` WHERE `product_id` = '".(int)$product_id."' AND `status`='1' ORDER BY `field_id` ASC";
		$query = $this->db->query($sql);
		
		$fieldsData = $query->rows;
		
		return ( $fieldsData );
	}
	
}
?>