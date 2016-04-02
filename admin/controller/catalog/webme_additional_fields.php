<?php
class ControllerCatalogWebmeAdditionalFields extends Controller {
	public function index() {
		
		$this->load->language('catalog/webme_additional_fields');
		$this->load->model('catalog/webme_additional_fields');
		
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		/*
		$this->data['entry_w_additional_fields_name'] = $this->language->get('entry_w_additional_fields_name');
		$this->data['entry_w_additional_fields_value'] = $this->language->get('entry_w_additional_fields_value');
		$this->data['entry_w_additional_fields_status'] = $this->language->get('entry_w_additional_fields_status');
		$this->data['entry_w_additional_fields_actions'] = $this->language->get('entry_w_additional_fields_actions');
		*/
		
		$this->data['entry_w_additional_fields'] = $this->language->get('entry_w_additional_fields');
		$this->data['entry_w_additional_fields_add'] = $this->language->get('entry_w_additional_fields_add');
		$this->data['entry_w_additional_fields_no_fields'] = $this->language->get('entry_w_additional_fields_no_fields');
		
		$this->data['entry_w_additional_fields_edit'] = $this->language->get('entry_w_additional_fields_edit');
		$this->data['entry_w_additional_fields_delete'] = $this->language->get('entry_w_additional_fields_delete');
		$this->data['entry_w_additional_fields_remove'] = $this->language->get('entry_w_additional_fields_remove');
		$this->data['entry_w_additional_fields_save'] = $this->language->get('entry_w_additional_fields_save');
		
		$this->data['entry_w_additional_fields_'] = $this->language->get('entry_w_additional_fields_');
		$this->data['entry_'] = $this->language->get('entry_');
		
		$this->data['column_field_name'] = $this->language->get('column_field_name');
		$this->data['column_field_value'] = $this->language->get('column_field_value');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_actions'] = $this->language->get('column_actions');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['text_waf_confirm_delete'] = $this->language->get('text_waf_confirm_delete');
		
		$this->data['text_'] = $this->language->get('text_');
		
		
		$this->data['error_'] = $this->language->get('error_');
		$this->data['error_w_additional_fields_name'] = $this->language->get('error_w_additional_fields_name');
		$this->data['error_w_additional_fields_value'] = $this->language->get('error_w_additional_fields_value');
		
		$this->data['token'] = $this->session->data['token'];
		
		/* create db-table if not exists */
		$this->model_catalog_webme_additional_fields->checkinstall();
		
		$this->data['product_id'] = $product_id;
		$w_additional_fields = array();
		$w_additional_fields = $this->model_catalog_webme_additional_fields->waf_getFields($product_id);
		
		$this->data['w_additional_fields'] = $w_additional_fields;
		
		
		$this->template = 'catalog/webme_additional_fields.tpl';
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	
	public function waf_add() {
		$output = "";
		if (isset($this->request->get['product_id'])) {
		
			$this->load->language('catalog/webme_additional_fields');
			$this->load->model('catalog/webme_additional_fields');
			
			//print_r($this->request->get['city_id']);
			//$output = $this->request->post;
			//print_r($output);
			//print "<br />";
			
			$field_name = $this->request->post['waf_name'];
			$field_value = $this->request->post['waf_value'];
			$status = $this->request->post['waf_status'];
			$waf_id = $this->request->post['waf_id'];
			
			if (!$this->model_catalog_webme_additional_fields->waf_add($this->request->get['product_id'], $field_name, $field_value, $status, $waf_id)) {
				$output .= $this->language->get('waf_added_error');
			} else {
				$output .= $this->language->get('waf_added_ok');
			}
			
		}
		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
	
	public function waf_delete() {
		
		$output = "";
		if (isset($this->request->get['product_id']) && isset($this->request->post['waf_id'])) {
			
			$this->load->language('catalog/webme_additional_fields');
			$this->load->model('catalog/webme_additional_fields');
			
			$waf_id = $this->request->post['waf_id'];
			
			if (!$this->model_catalog_webme_additional_fields->waf_delete($this->request->get['product_id'], $waf_id)) {
				$output .= $this->language->get('waf_deleted_error');
			} else {
				$output .= $this->language->get('waf_deleted_ok');
				//"Deleted successfully";
			}
		}
		$this->response->setOutput($output, $this->config->get('config_compression'));
	}
	
}
?>