<?php
class ControllerProductWebmeAdditionalFields extends Controller {
	public function index() {
		
		$this->load->language('product/webme_additional_fields');
		$this->load->model('catalog/webme_additional_fields');
		
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		/* create db-table if not exists */
		$this->model_catalog_webme_additional_fields->checkInstall();
		
		$this->data['product_id'] = $product_id;
		$w_additional_fields = array();
		$w_additional_fields = $this->model_catalog_webme_additional_fields->waf_getFields($product_id);
		
		$this->data['w_additional_fields'] = $w_additional_fields;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/webme_additional_fields.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/webme_additional_fields.tpl';
		} else {
			$this->template = 'default/template/product/webme_additional_fields.tpl';
		}
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
}
?>