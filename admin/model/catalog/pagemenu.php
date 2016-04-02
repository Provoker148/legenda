<?php
class ModelCatalogPagemenu extends Model {
	public function addInformation($data) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pagemenu SET sort_order = '" . (int)$data['sort_order'] . "', top = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', status = '" . (int)$data['status'] . "'");

		$pagemenu_id = $this->db->getLastId(); 

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "pagemenu_description SET pagemenu_id = '" . (int)$pagemenu_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pagemenu_to_store SET pagemenu_id = '" . (int)$pagemenu_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout) {
				if ($layout) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "pagemenu_to_layout SET pagemenu_id = '" . (int)$pagemenu_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'pagemenu_id=" . (int)$pagemenu_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('pagemenu');
	}

	public function editInformation($pagemenu_id, $data) {
						$this->db->query("UPDATE " . DB_PREFIX . "pagemenu SET sort_order = '" . (int)$data['sort_order'] . "', top = '" . (isset($data['top']) ? (int)$data['top'] : 0) . "', status = '" . (int)$data['status'] . "' WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "pagemenu_description WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		foreach ($data['information_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "pagemenu_description SET pagemenu_id = '" . (int)$pagemenu_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "pagemenu_to_store WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		if (isset($data['information_store'])) {
			foreach ($data['information_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "pagemenu_to_store SET pagemenu_id = '" . (int)$pagemenu_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "pagemenu_to_layout WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		if (isset($data['information_layout'])) {
			foreach ($data['information_layout'] as $store_id => $layout) {
				if ($layout['layout_id']) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "pagemenu_to_layout SET pagemenu_id = '" . (int)$pagemenu_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout['layout_id'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'pagemenu_id=" . (int)$pagemenu_id. "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'pagemenu_id=" . (int)$pagemenu_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('pagemenu');
	}

	public function deleteInformation($pagemenu_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "pagemenu WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "pagemenu_description WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "pagemenu_to_store WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "pagemenu_to_layout WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'pagemenu_id=" . (int)$pagemenu_id . "'");

		$this->cache->delete('information');
	}	

	public function getInformation($pagemenu_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'pagemenu_id=" . (int)$pagemenu_id . "') AS keyword FROM " . DB_PREFIX . "pagemenu WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		return $query->row;
	}

	public function getInformations($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "pagemenu i LEFT JOIN " . DB_PREFIX . "pagemenu_description id ON (i.pagemenu_id = id.pagemenu_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'id.title',
				'i.sort_order'
			);		

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY id.title";	
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}		

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$information_data = $this->cache->get('pagemenu.' . (int)$this->config->get('config_language_id'));

			if (!$information_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pagemenu i LEFT JOIN " . DB_PREFIX . "pagemenu_description id ON (i.pagemenu_id = id.pagemenu_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$information_data = $query->rows;

				$this->cache->set('pagemenu.' . (int)$this->config->get('config_language_id'), $information_data);
			}	

			return $information_data;			
		}
	}

	public function getInformationDescriptions($pagemenu_id) {
		$information_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pagemenu_description WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		foreach ($query->rows as $result) {
			$information_description_data[$result['language_id']] = array(
				'title'       => $result['title'],
				'description' => $result['description']
			);
		}

		return $information_description_data;
	}

	public function getInformationStores($pagemenu_id) {
		$information_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pagemenu_to_store WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		foreach ($query->rows as $result) {
			$information_store_data[] = $result['store_id'];
		}

		return $information_store_data;
	}

	public function getInformationLayouts($pagemenu_id) {
		$information_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pagemenu_to_layout WHERE pagemenu_id = '" . (int)$pagemenu_id . "'");

		foreach ($query->rows as $result) {
			$information_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $information_layout_data;
	}

	public function getTotalInformations() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pagemenu");

		return $query->row['total'];
	}	

	public function getTotalInformationsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pagemenu_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}	
}
?>