<?php

//  Live Price / Динамическое обновление цены - живая цена
//  Support: support@liveopencart.com / Поддержка: opencart@19th19th.ru

class ControllerModuleLivePrice extends Controller {
	
	
	protected function index() {
		
		/*
		$this->language->load('module/liveprice');
		
		
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('module/liveprice');
		$this->data['liveprice_installed'] = $this->model_module_liveprice->installed();
		$this->data['product_id'] = $this->request->get['product_id'];
		$this->data['lp_theme_name'] = $this->config->get('config_template');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/liveprice.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/liveprice.tpl';
		} else {
			$this->template = 'default/template/module/liveprice.tpl';
		}
		
		$this->render();
		*/
	}
	
	
	public function get_price() {
		
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			exit;
		}
		
		if (isset($this->request->get['quantity'])) {
			$quantity = (int)$this->request->get['quantity'];
		} else {
			$quantity = 0;
		}
		
		if (isset($this->request->post['option'])) {
			$options = $this->request->post['option'];
		} else {
			$options = array();
		}
		
		$this->load->model('module/liveprice');
		$prices = array();
		$product_data = array();
		$options_data = array();
		$this->model_module_liveprice->getProductPriceWithHtml($product_id, $quantity, $options, $prices, $product_data, $options_data, true );
		
		// return only required data
		
		$prices = array('htmls'=>$prices['htmls'], 'ct'=>$prices['ct']);
		
		if (isset($this->request->get['rnd'])) {
			$prices['rnd'] = $this->request->get['rnd'];
		}
		
		
		//print_r($prices);
			
		echo json_encode($prices);
		exit;
		
	}
	
	
}
?>