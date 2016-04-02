<?php

//  Live Price / Динамическое обновление цены - живая цена
//  Support: support@liveopencart.com / Поддержка: opencart@19th19th.ru

class ControllerModuleLivePrice extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/liveprice');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$this->model_setting_setting->editSetting('liveprice', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/liveprice', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_edit_position'] = $this->language->get('text_edit_position');
		$this->data['module_info'] = $this->language->get('module_info');
		$this->data['module_description'] = $this->language->get('module_description');
		$this->data['module_copyright'] = $this->language->get('module_copyright');
		
		$this->data['entry_discount_quantity'] = $this->language->get('entry_discount_quantity');
		$this->data['text_discount_quantity_0'] = $this->language->get('text_discount_quantity_0');
		$this->data['text_discount_quantity_1'] = $this->language->get('text_discount_quantity_1');
		$this->data['text_discount_quantity_2'] = $this->language->get('text_discount_quantity_2');
		$this->data['text_relatedoptions_notify'] = $this->language->get('text_relatedoptions_notify');
		$this->data['entry_multiplied_price'] = $this->language->get('entry_multiplied_price');
		
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['entry_we_recommend'] = $this->language->get('entry_we_recommend');
		$this->data['entry_show_we_recommend'] = $this->language->get('entry_show_we_recommend');
		$this->data['text_we_recommend'] = $this->language->get('text_we_recommend');
		
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
      $this->data['success'] = $this->session->data['success'];
      unset($this->session->data['success']);
    } 

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_module'),
		'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);
	
		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('module/liveprice', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('module/liveprice', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();
		
		if (isset($this->request->post['liveprice_module'])) {
			$this->data['modules'] = $this->request->post['liveprice_module'];
		} elseif ($this->config->get('liveprice_module')) { 
			$this->data['modules'] = $this->config->get('liveprice_module');
		}
		
		if (isset($this->request->post['liveprice_settings'])) {
			$this->data['liveprice_settings'] = $this->request->post['liveprice_settings'];
		} elseif ($this->config->get('liveprice_settings')) { 
			$this->data['liveprice_settings'] = $this->config->get('liveprice_settings');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
						
		$this->template = 'module/liveprice.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	// получаем стандартные настройки отображения модуля (при установке)
	private function standardSettings($post=false) {
		if (!$post || is_array($post)) {
			$post = array();
		}
		/*
		$post['liveprice_module'] = Array ( 0 => Array ( 	'layout_id' => 2
																										,	'position' => 'content_bottom'
																										, 'status' => 1
																										, 'sort_order' => 0
																										) );
		*/
		return $post;
	}
	
	public function install() {
		
		$post = $this->standardSettings();
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('liveprice', $post);
		
	}
	
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/liveprice')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>