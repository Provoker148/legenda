<?php 
class ControllerModulePopupCartExtended extends Controller {
	
	public function index() {
		//$this->language->load('module/cart');
		$this->language->load('module/popupcart_extended');
		
		$this->data['addtocart_logic'] = $this->config->get('popupcart_extended_module_addtocart_logic');
		$this->data['click_on_cart'] = $this->config->get('popupcart_extended_module_click_on_cart');
		$text_head = $this->config->get('popupcart_extended_module_head');
		$text_related_heading = $this->config->get('popupcart_extended_module_related_heading');
		$text_shopping = $this->config->get('popupcart_extended_module_button_shopping');
		$text_cart = $this->config->get('popupcart_extended_module_button_cart');
		$text_checkout = $this->config->get('popupcart_extended_module_button_checkout');
		$text_incart = $this->config->get('popupcart_extended_module_button_incart');
		$text_incart_with_options = $this->config->get('popupcart_extended_module_button_incart_with_options');
		
		$this->data['related'] = $this->config->get('popupcart_extended_module_related_show');
		$this->data['button_shopping_show'] = $this->config->get('popupcart_extended_module_button_shopping_show');
		$this->data['button_cart_show'] = $this->config->get('popupcart_extended_module_button_cart_show');
		$this->data['manufacturer_show'] = $this->config->get('popupcart_extended_module_manufacturer_show');
		$this->data['button_incart_logic'] = $this->config->get('popupcart_extended_module_button_incart_logic');
		
		$l_code = $this->session->data['language'];
		
		$this->data['head'] = $text_head[$l_code];
		$this->data['button_shopping'] = $text_shopping[$l_code];
		$this->data['button_cart'] = $text_cart[$l_code];
		$this->data['button_checkout'] = $text_checkout[$l_code];
		$this->data['button_incart'] = $text_incart[$l_code];
		$this->data['button_incart_with_options'] = $text_incart_with_options[$l_code];
		$this->data['text_related'] = $text_related_heading[$l_code];
		
		$this->data['button_cart_default'] = $this->language->get('button_cart');
		$this->data['text_foto'] = $this->language->get('text_foto');
		$this->data['text_name'] = $this->language->get('text_name');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['add_to_cart'] = $this->language->get('add_to_cart');
		
		$this->data['in_stock'] = $this->language->get('text_in_stock');
		$this->data['left'] = $this->language->get('text_left');
		$this->data['left1'] = $this->language->get('text_left1');
		$this->data['just'] = $this->language->get('text_just');
		$this->data['pcs'] = $this->language->get('text_pcs');
		
      	if (isset($this->request->get['remove'])) {
          	$this->cart->remove($this->request->get['remove']);
			
			unset($this->session->data['vouchers'][$this->request->get['remove']]);
      	}	
		
		$this->document->addScript('catalog/view/javascript/popupcart_ext/popupcart_ext.js?ver=1.5');
		$this->document->addScript('catalog/view/javascript/popupcart_ext/owl.carousel.min.js');
		$this->document->addStyle('catalog/view/javascript/popupcart_ext/popupcart_ext.css');
		$this->document->addStyle('catalog/view/javascript/popupcart_ext/owl.carousel.css');
		
		$this->document->addScript('catalog/view/javascript/popupcart_ext/jquery.total-storage.min.js');
			
		// Totals
		$this->load->model('setting/extension');
		
		$total_data = array();					
		$total = 0;
		$taxes = $this->cart->getTaxes();
		
		// Display prices
		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
				
				$sort_order = array(); 
			  
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
	
				array_multisort($sort_order, SORT_ASC, $total_data);			
			}		
		}
		
		$this->data['totals'] = $total_data;
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		//$this->data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
		$this->data['total_summ'] = $this->currency->format($total);
		$this->data['text_empty'] = $this->language->get('text_empty');
		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');
		
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$this->data['products'] = array();
		
		$getProducts = array_reverse($this->cart->getProducts());
			
		foreach ($getProducts as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], 64, 64);
			} else {
				$image = '';
			}
							
			$option_data = array();
			
			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['option_value'];	
				} else {
					$filename = $this->encryption->decrypt($option['option_value']);
					
					$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
				}				
				
				$option_data[] = array(								   
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
			
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
			} else {
				$total = false;
			}
													
			$this->data['products'][] = array(
				'key'      => $product['key'],
				'id'      => $product['product_id'],
				'thumb'    => $image,
				'name'     => $product['name'],
				'model'    => $product['model'], 
				'manufacturer'     => $product['manufacturer'],
				'option'   => $option_data,
				'quantity' => $product['quantity'],
				'stock'    => $this->config->get('config_stock_checkout'),
				'minimum'  => $product['minimum'],
				'maximum'  => $product['maximum'],
				'price'    => $price,	
				'total'    => $total,	
				'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id'])		
			);
			
			//$this->data['products_related'] = array();
			
			$results = $this->model_catalog_product->getProductRelated($product['product_id']);	
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 100, 100);
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
							
				$this->data['products_related'][] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}	
			
		}
		
		// Gift Voucher
		$this->data['vouchers'] = array();
		
		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$this->data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'])
				);
			}
		}
					
		$this->data['cart'] = $this->url->link('checkout/cart');				
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/popupcart_extended.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/popupcart_extended.tpl';
		} else {
			$this->template = 'default/template/module/popupcart_extended.tpl';
		}
				
		$this->response->setOutput($this->render());		
	}
}
?>