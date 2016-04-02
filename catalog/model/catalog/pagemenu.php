<?php
class ModelCatalogPagemenu extends Model {
	public function getInformation($pagemenu_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "pagemenu i LEFT JOIN " . DB_PREFIX . "pagemenu_description id ON (i.pagemenu_id = id.pagemenu_id) LEFT JOIN " . DB_PREFIX . "pagemenu_to_store i2s ON (i.pagemenu_id = i2s.pagemenu_id) WHERE i.pagemenu_id = '" . (int)$pagemenu_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");
	
		return $query->row;
	}
	
	public function getInformations() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pagemenu i LEFT JOIN " . DB_PREFIX . "pagemenu_description id ON (i.pagemenu_id = id.pagemenu_id) LEFT JOIN " . DB_PREFIX . "pagemenu_to_store i2s ON (i.pagemenu_id = i2s.pagemenu_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");
		
		return $query->rows;
	}
	
	public function getInformationLayoutId($pagemenu_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pagemenu_to_layout WHERE pagemenu_id = '" . (int)$pagemenu_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return false;
		}
	}	
}
?>