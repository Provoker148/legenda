<?php

//  Live Price / Динамическое обновление цены - живая цена
//  Support: support@liveopencart.com / Поддержка: opencart@19th19th.ru

class ModelModuleLivePrice extends Model {

  var $options_selects = array('select','radio','image','block','color');

  public function installed() {
    
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'module' AND `code` = 'liveprice'");
    
    return $query->num_rows;
  }

  private function arrayDeleteEmpty($arr) {
    
    $new_arr = array();
    foreach ($arr as $key => $val) {
      if ($val) {
        $new_arr[$key] = $val;
      }
    }
    
    return $new_arr;
  }


  private function calculateOptionPrice($price, $options, $options_types, $options_values, $get_full_data=false, $quantity=0, &$option_data=array(), &$option_points=0, &$option_weight=0, &$stock=true) {
    
    $option_price = 0;
    
    // надо вынести в функцию
    foreach ($options as $product_option_id => $option_value) {
      
      if (!isset($options_types[$product_option_id])) {
        continue;
      }
      
      $options_array = array();
      if ( in_array($options_types[$product_option_id]['type'], $this->options_selects) ) {
        $options_array = array($option_value);
      } elseif ( $options_types[$product_option_id]['type'] == 'checkbox' && is_array($options_array) ) {
        $options_array = $option_value;
      }
      
      if ( (in_array($options_types[$product_option_id]['type'], $this->options_selects) || $options_types[$product_option_id]['type'] == 'checkbox')
          && isset($options_values[$product_option_id]) ) {
        
        $povs = $options_values[$product_option_id];
        
        foreach ($options_array as $product_option_value_id) {
          
          if ( isset($povs[$product_option_value_id]) ) {
            
            $pov = $povs[$product_option_value_id];
            
            if ($pov['price_prefix'] == '+') {
              $option_price += $pov['price'];
              
            } elseif ($pov['price_prefix'] == '-') {
              $option_price -= $pov['price'];
              
            } elseif ($pov['price_prefix'] == '*') {
              $current_price = $price+$option_price;
              $option_price = round($current_price*$pov['price'],2)-$price;
              
            } elseif ($pov['price_prefix'] == '/' && $pov['price']!=0) {
              $current_price = $price+$option_price;
              $option_price = round($current_price/$pov['price'],2)-$price;
              
            } elseif ($pov['price_prefix'] == '=') {
              $current_price = $price+$option_price;
              $option_price = $pov['price']-$current_price; 
              
            } elseif ($pov['price_prefix'] == '=') {
              $current_price = $price+$option_price;
              $option_price = $pov['price']-$current_price;
            }

            if ($get_full_data) {
            
              if ($pov['points_prefix'] == '+') {
                $option_points += $pov['points'];
              } elseif ($pov['points_prefix'] == '-') {
                $option_points -= $pov['points'];
              }
                            
              if ($pov['weight_prefix'] == '+') {
                $option_weight += $pov['weight'];
              } elseif ($pov['weight_prefix'] == '-') {
                $option_weight -= $pov['weight'];
              }
              
              if ($pov['subtract'] && (!$pov['quantity'] || ($pov['quantity'] < $quantity))) {
                $stock = false;
              }
              
              $option_data[] = array(
                'product_option_id'       => $product_option_id,
                'product_option_value_id' => $product_option_value_id,
                'option_id'               => $options_types[$product_option_id]['option_id'],
                'option_value_id'         => $pov['option_value_id'],
                'name'                    => $options_types[$product_option_id]['name'],
                'option_value'            => $pov['name'],
                'type'                    => $options_types[$product_option_id]['type'],
                'quantity'                => $pov['quantity'],
                'subtract'                => $pov['subtract'],
                'price'                   => $pov['price'],
                'price_prefix'            => $pov['price_prefix'],
                'points'                  => $pov['points'],
                'points_prefix'           => $pov['points_prefix'],
                'weight'                  => $pov['weight'],
                'weight_prefix'           => $pov['weight_prefix']
              );
            }
          }
        }
      } elseif ( in_array($options_types[$product_option_id]['type'], array('text','textarea','file','date','datetime','time') ) ) {
        
        if ($get_full_data) {
        
          $option_data[] = array(
            'product_option_id'       => $product_option_id,
            'product_option_value_id' => '',
            'option_id'               => $options_types[$product_option_id]['option_id'],
            'option_value_id'         => '',
            'name'                    => $options_types[$product_option_id]['name'],
            'option_value'            => $option_value,
            'type'                    => $options_types[$product_option_id]['type'],
            'quantity'                => '',
            'subtract'                => '',
            'price'                   => '',
            'price_prefix'            => '',
            'points'                  => '',
            'points_prefix'           => '',								
            'weight'                  => '',
            'weight_prefix'           => ''
          );
          
        }
      }
      
    }
    
    return $option_price;
    
  }


  // PARAMS:
  // $product_id,
  // $current_quantity ( use 0 for cart )
  // $options = array( $product_option_id => $product_option_value_id )
  // RESULTS:
  // &$prices=array(), &$product_data=array(), &$options_data=array()
  
  public function getProductPrice($product_id, $current_quantity=0, $options=array(), &$prices=array(), &$product_data=array(), &$options_data=array(), $multiplied_price=false ) {
    
    $lp_settings = $this->config->get('liveprice_settings');
    
    if (isset($lp_settings['discount_quantity']) && $lp_settings['discount_quantity']==2) {
      $this->load->model('module/related_options');
      $ro_installed = $this->model_module_related_options->installed();
			if ($ro_installed) {
				$ro_price_data = $this->model_module_related_options->get_related_options_set_by_poids($product_id, $options, true);
      }
    }
    
    
    $options = $this->arrayDeleteEmpty($options);
    
    $product_data = array();
    $option_data = array();
    $prices = array(  // without taxes
                      'product_price' => 0            // product price
                    , 'price_old' => 0                // product price with discount, but without special
                    , 'price_old_opt' => 0            // product price with discount, but without special, and with options
                    , 'special' => 0                  // product special price
                    , 'special_opt' => 0              // product special price with options
                    , 'price' => 0                    // product price with discount and special (special ignore discount)
                    , 'price_opt' => 0                // product price with discount and special (special ignore discount) with options
                    , 'option_price' => 0             // option price modificator
                    , 'option_price_special' => 0     // option price modificator for specials
                    //, 'discounts' => array()
                    
                      // with taxes and formatted
                    , 'f_product_price' => 0            // product price
                    , 'f_price_old' => 0                // product price with discount, but without special
                    , 'f_price_old_opt' => 0                // product price with discount, but without special
                    , 'f_special' => 0                  // product special price
                    , 'f_special_opt' => 0                  // product special price
                    , 'f_price' => 0                    // product price with discount and special (special ignore discount)
                    , 'f_price_opt' => 0                    // product price with discount and special (special ignore discount)
                    , 'f_option_price' => 0             // option price modificator
                    //, 'f_discounts' => array()
                    
                    
                    // without taxes and formatted
                    , 'f_product_price_notax' => 0            // product price
                    , 'f_price_old_notax' => 0                // product price with discount, but without special
                    , 'f_price_old_opt_notax' => 0                // product price with discount, but without special
                    , 'f_special_notax' => 0                  // product special price
                    , 'f_special_opt_notax' => 0                  // product special price
                    , 'f_price_notax' => 0                    // product price with discount and special (special ignore discount)
                    , 'f_price_opt_notax' => 0                    // product price with discount and special (special ignore discount)
                    , 'f_option_price_notax' => 0             // option price modificator
                    //, 'f_discounts_notax' => array()
                    
                    , 'config_tax' => $this->config->get('config_tax')
                    , 'points' => 0
                    
                    );
    
    
    $quantity = $current_quantity;
    foreach ($this->session->data['cart'] as $key => $cart_quantity) {
      
      $cart_product = explode(':', $key);
      $cart_product_id = $cart_product[0];
      
      if ($cart_product_id == $product_id) {

        // Options
        if (isset($cart_product[1])) {
          $cart_options = unserialize(base64_decode($cart_product[1]));
        } else {
          $cart_options = array();
        }
      
        if ( isset($lp_settings['discount_quantity']) && $lp_settings['discount_quantity']==1 ) { // by options
          
          if ($options == $cart_options) {
            $quantity = $quantity + $cart_quantity;
          }
          
        } elseif ( isset($lp_settings['discount_quantity']) && $lp_settings['discount_quantity']==2 ) { // by related options combination
          
          if ( isset($ro_price_data) && $ro_price_data ) {
            $ro_price_data_cart = $this->model_module_related_options->get_related_options_set_by_poids($product_id, $cart_options, true);
            if ( $ro_price_data_cart && $ro_price_data_cart['relatedoptions_id'] == $ro_price_data['relatedoptions_id'] ) {
              $quantity = $quantity + $cart_quantity;
            }
          }
          
        } else { // by product
          $quantity = $quantity + $cart_quantity;
        }
      } 
    }
    $quantity = max($quantity, 1);
    
    $stock = true;

    $product_query = $this->db->query(" SELECT *
                                        FROM " . DB_PREFIX . "product p
                                          LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                                        WHERE p.product_id = '" . (int)$product_id . "'
                                          AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
                                          AND p.date_available <= NOW()
                                          AND p.status = '1'");
    
    //print 'pid='.$product_id.'<br>/n';
    
    if ($product_query->num_rows) {
      
      //print 'pid='.$product_id.'<br>/n';
      
      //print_r($options);
      
      $option_price = 0;
      $option_points = 0;
      $option_weight = 0;
      
      // << соберем все данным по опциями в массивы для повторного использования
      
      $options_types = array();
      $options_values = array();
      
      $product_option_ids = array();
      $product_option_value_ids = array();
      foreach ($options as $product_option_id => $option_value) {
        if (!in_array($product_option_id, $product_option_ids) && $product_option_id) {
          $product_option_ids[] = (int)$product_option_id;
        }
      }
      
      if ( count($product_option_ids) != 0 ) {
        
        $options_query = $this->db->query(" SELECT po.product_option_id, po.option_id, od.name, o.type
                                            FROM " . DB_PREFIX . "product_option po
                                              LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id)
                                              LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id)
                                            WHERE po.product_option_id IN (" . implode(",", $product_option_ids) . ")
                                              AND po.product_id = '" . (int)$product_id . "'
                                              AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
        foreach ($options_query->rows as $row) {
          $options_types[$row['product_option_id']] = $row;
        }
      
        foreach ($options as $product_option_id => $option_value) {
          if ( in_array($options_types[$product_option_id]['type'], $this->options_selects) ) {
            if (!in_array((int)$option_value, $product_option_value_ids) && $option_value) {
              $product_option_value_ids[] = (int)$option_value;
            }
          } elseif ($options_types[$product_option_id]['type'] == 'checkbox' && is_array($option_value)) {
            foreach ($option_value as $product_option_value_id) {
              if (!in_array((int)$product_option_value_id, $product_option_value_ids) && $product_option_value_id) {
                $product_option_value_ids[] = (int)$product_option_value_id;
              }
            }
          }
        }
        
        if ( count($product_option_ids) != 0 && count($product_option_value_ids) != 0 ) {
          $option_value_query = $this->db->query("SELECT  pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.product_option_id
                                                        , pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix, pov.product_option_value_id
                                                  FROM " . DB_PREFIX . "product_option_value pov
                                                    LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id)
                                                    LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id)
                                                  WHERE pov.product_option_value_id IN (" . implode(",", $product_option_value_ids) . ")
                                                    AND pov.product_option_id IN (" . implode(",", $product_option_ids) . ")
                                                    AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
          foreach ($option_value_query->rows as $row) {
            if (!isset($options_values[$row['product_option_id']])) {
              $options_values[$row['product_option_id']] = array();
            }
            $options_values[$row['product_option_id']][$row['product_option_value_id']] = $row;
          }
        }
      }
      // >> соберем все данным по опциями в массивы для повторного использования
      
      $option_price = $this->calculateOptionPrice($product_query->row['price'], $options, $options_types, $options_values, true, $quantity, $option_data, $option_points, $option_weight, $stock);
      
      
      
      $prices['option_price'] = $option_price;
    
      if ($this->customer->isLogged()) {
        $customer_group_id = $this->customer->getCustomerGroupId();
      } else {
        $customer_group_id = $this->config->get('config_customer_group_id');
      }
      
      $price = $product_query->row['price'];
      
      $prices['product_price'] = $price;
      
      // Product Discounts
      $discount_quantity = $quantity;

      
      $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount
                                                  WHERE product_id = '" . (int)$product_id . "'
                                                    AND customer_group_id = '" . (int)$customer_group_id . "'
                                                    AND quantity <= '" . (int)$discount_quantity . "'
                                                    AND ((date_start = '0000-00-00' OR date_start < NOW())
                                                    AND (date_end = '0000-00-00' OR date_end > NOW()))
                                                  ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
      
      if ($product_discount_query->num_rows) {
        $price = $product_discount_query->row['price'];
        
        // new options price prefixes can give another option_price value for discount price, so - recalc 
        $option_price = $this->calculateOptionPrice($price, $options, $options_types, $options_values);
        $prices['option_price'] = $option_price;
      }
      
      
      // Product Specials
      $product_special_query = $this->db->query(" SELECT price FROM " . DB_PREFIX . "product_special
                                                  WHERE product_id = '" . (int)$product_id . "'
                                                    AND customer_group_id = '" . (int)$customer_group_id . "'
                                                    AND ((date_start = '0000-00-00' OR date_start < NOW())
                                                    AND (date_end = '0000-00-00' OR date_end > NOW()))
                                                  ORDER BY priority ASC, price ASC LIMIT 1");
    
      $price_old = $price;
      $prices['price_old'] = $price_old;
    
      if ($product_special_query->num_rows) {
        $price = $product_special_query->row['price'];
        
        // new options price prefixes can give another option_price value for special price, so - recalc
        $option_price_special = $this->calculateOptionPrice($price, $options, $options_types, $options_values);
        $option_price = $option_price_special;
        $prices['option_price'] = $option_price;
        $prices['option_price_special'] = $option_price_special;
        
        $prices['special'] = $product_special_query->row['price'];
      }
      $prices['price'] = $price;
      
  
      // Reward Points
      $product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward
                                                WHERE product_id = '" . (int)$product_id . "'
                                                  AND customer_group_id = '" . (int)$customer_group_id . "'");
      
      if ($product_reward_query->num_rows) {	
        $reward = $product_reward_query->row['points'];
      } else {
        $reward = 0;
      }
      
      // Downloads		
      $download_data = array();     		
      
      $download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d
                                            LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id)
                                            LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id)
                                          WHERE p2d.product_id = '" . (int)$product_id . "'
                                            AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
    
      foreach ($download_query->rows as $download) {
        $download_data[] = array(
          'download_id' => $download['download_id'],
          'name'        => $download['name'],
          'filename'    => $download['filename'],
          'mask'        => $download['mask'],
          'remaining'   => $download['remaining']
        );
      }
      
      // Stock
      if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
        $stock = false;
      }
      
      
      
      // некоторая избыточность в подготовке данных
      $product_data = array(
        //'key'             => $key,
        'product_id'      => $product_query->row['product_id'],
        'name'            => $product_query->row['name'],
        'model'           => $product_query->row['model'],
        'shipping'        => $product_query->row['shipping'],
        'image'           => $product_query->row['image'],
        'option'          => $option_data,
        'download'        => $download_data,
        'quantity'        => $quantity,
        'minimum'         => $product_query->row['minimum'],
        'subtract'        => $product_query->row['subtract'],
        'stock'           => $stock,
        'price'           => ($price + $option_price),
        'total'           => ($price + $option_price) * $quantity,
        'reward'          => $reward * $quantity,
        'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
        'tax_class_id'    => $product_query->row['tax_class_id'],
        'weight'          => ($product_query->row['weight'] + $option_weight) * $quantity,
        'weight_class_id' => $product_query->row['weight_class_id'],
        'length'          => $product_query->row['length'],
        'width'           => $product_query->row['width'],
        'height'          => $product_query->row['height'],
        'length_class_id' => $product_query->row['length_class_id']					
      );
      
      $price_multiplier = 1;
      if ($multiplied_price && isset($lp_settings['multiplied_price']) && $lp_settings['multiplied_price']) {
        $price_multiplier = MAX(1, $current_quantity);
        //мультипликатор только для форматных цен
        /*
        $prices['product_price']        = $prices['product_price']*$current_quantity;
        $prices['price_old']            = $prices['price_old']*$current_quantity;
        $prices['price_old_opt']        = $prices['price_old_opt']*$current_quantity;
        $prices['special']              = $prices['special']*$current_quantity;
        $prices['special_opt']          = $prices['special_opt']*$current_quantity;
        $prices['price']                = $prices['price']*$current_quantity;
        $prices['price_opt']            = $prices['price_opt']*$current_quantity;
        $prices['option_price']         = $prices['option_price']*$current_quantity;
        $prices['option_price_special'] = $prices['option_price_special']*$current_quantity;
        */
      }
      
      //$prices['points']                 = $product_data['points'];
      $prices['points']                 = ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $price_multiplier : 0);
      
      $prices['price_old_opt']          = $prices['price_old'] + $prices['option_price'];
      $prices['special_opt']            = $prices['special'] + $prices['option_price_special'];
      // special options modificator if there's special, standard price modificator if there's no special
      $prices['price_opt']              = $prices['price'] + $option_price;
      //$prices['price_opt']              = $prices['price'] + $prices['option_price'];
      $prices['f_product_price_notax']  = $this->currency->format($prices['product_price']);
      $prices['f_price_old_notax']      = $this->currency->format($prices['price_old']);
      $prices['f_price_old_opt_notax']  = $this->currency->format($prices['price_old_opt']);
      $prices['f_special_notax']        = $this->currency->format($prices['special']);
      $prices['f_special_opt_notax']    = $this->currency->format($prices['special_opt']);
      $prices['f_price_notax']          = $this->currency->format($prices['price']);
      $prices['f_price_opt_notax']      = $this->currency->format($prices['price_opt']);
      $prices['f_option_price_notax']   = $this->currency->format($prices['option_price']);
      $prices['f_product_price']        = $this->currency->format($price_multiplier*$this->tax->calculate($prices['product_price'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      $prices['f_price_old']            = $this->currency->format($price_multiplier*$this->tax->calculate($prices['price_old'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      $prices['f_price_old_opt']        = $this->currency->format($price_multiplier*$this->tax->calculate($prices['price_old_opt'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      $prices['f_special']              = $this->currency->format($price_multiplier*$this->tax->calculate($prices['special'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      $prices['f_special_opt']          = $this->currency->format($price_multiplier*$this->tax->calculate($prices['special_opt'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      $prices['f_price']                = $this->currency->format($price_multiplier*$this->tax->calculate($prices['price'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      $prices['f_price_opt']            = $this->currency->format($price_multiplier*$this->tax->calculate($prices['price_opt'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      $prices['f_option_price']         = $this->currency->format($price_multiplier*$this->tax->calculate($prices['option_price'], $product_query->row['tax_class_id'], $this->config->get('config_tax')));
      
      // required for html generation, placed here for better related options compatibility
      $this->load->model('catalog/product');
      $discounts = $this->model_catalog_product->getProductDiscounts($product_id);
      $prices['discounts'] = array(); 
      foreach ($discounts as $discount) {
        $option_price_discount = $this->calculateOptionPrice($discount['price'], $options, $options_types, $options_values);
        $prices['discounts'][] = array(
          'quantity' => $discount['quantity'],
          'price'    => $this->currency->format($this->tax->calculate($discount['price']+$option_price_discount, $product_data['tax_class_id'], $this->config->get('config_tax')))
        );
      }
      
      return $price + $option_price;
    
    }

    return 0;
    
  }
  
  public function getProductPriceWithHtml($product_id, $current_quantity=0, $options=array(), &$prices=array(), &$product_data=array(), &$options_data=array(), $multiplied_price=false ) {
    
    $this->getProductPrice($product_id, $current_quantity, $options, $prices, $product_data, $options_data, $multiplied_price );
    
    $simple_prices = array(   'price'       =>  $prices['f_price_old_opt']
                            , 'special'     =>  ($prices['special']?$prices['f_special_opt']:$prices['special'])
                            , 'points'      =>  $prices['points']
                            , 'tax'         =>  ($prices['config_tax']?$prices['f_price_opt_notax']:$prices['config_tax'])
                            , 'discounts'   =>  $prices['discounts']
                            , 'points'      =>  $prices['points']
                            , 'reward'      =>  $product_data['reward']
                            , 'minimum'     =>  $product_data['minimum']
                            , 'quantity'       =>  $product_data['quantity']
                            
                            , 'price_val'   =>  $prices['price_old_opt']
                            , 'special_val' =>  $prices['special']
                            );
    
    $prices['htmls'] = $this->getPriceHtmls($simple_prices);
    $prices['ct'] = $this->config->get('config_template');
    
  }
  
  function getPriceHtmls($prices) {
    
    $this->language->load('product/product');
    $text_price     = $this->language->get('text_price');
    $text_tax       = $this->language->get('text_tax');
    $text_discount  = $this->language->get('text_discount');
    $text_points    = $this->language->get('text_points');
    $text_reward    = $this->language->get('text_reward');
    $text_minimum   = $this->language->get('text_minimum');
    
    $price = $prices['price'];
    $special = $prices['special'];
    $tax = $prices['tax'];
    $points = $prices['points'];
    $discounts = $prices['discounts'];
    $quantity = $prices['quantity'];
    
    $html = "";
    $html_d = "";
    $html1 = "";
    $html2 = "";
    
    if ($this->config->get('config_template') == 'moneymaker') {
    
      $html .= '<span class="price-ldot">&bull;</span> ';
      if (!$prices['special']) {
        $html .= $prices['price'];
      } else {
        $html .= '<span class="price-new">'.$prices['special'].'</span> <span class="price-old"><small>'. $prices['price'].'</small></span>';
      }
      $html .= ' <span class="price-rdot">&bull;</span>';
      
      if ($prices['minimum'] > 1||$prices['reward']||$prices['tax']||$prices['points']||$prices['discounts']) {
        if ($prices['minimum'] > 1) {
          $html_d .= '<li>'.$text_minimum.'</li>';
        }
        if ($prices['reward']) {
          $html_d .= '<li>'.$text_reward.' '.$prices['reward'].'</li>';
        }
        if ($prices['price']) {
          if ($prices['tax']) {
            $html_d .= '<li>'.$text_tax.' '.$prices['tax'].'</li>';
          }
          if ($prices['points']) {
            $html_d .= '<li>'.$text_points.' '.$prices['points'].'</li>';
          }
          if ($prices['discounts']) {
            foreach ($prices['discounts'] as $discount) {
              $html_d .= '<li>'.sprintf($text_discount, $discount['quantity'], $discount['price']).'</li>';
            }
          }
        }
      }
      
    } elseif ($this->config->get('config_template') == 'polianna') {
      
      $html = '';
      if (!$prices['special']) {
        $html.= $prices['price'];
      } else {
        $html.= ' <span class="price-old">'.$prices['price'].'</span> <span class="price-new">'.$prices['special'].'</span>'."\n";
        $saving = round((($prices['price_val'] - $prices['special_val'])/($prices['price_val'] + 0.01))*100, 0);	
        $html.= ' <div class="savemoney">- '.$saving.'%</div>'."\n";
      }
      $html.= '<br />';
      //if ($tax) {
      if ($prices['tax']) {
        $html.= ' <div class="price-tax">'.$text_tax.' '.$prices['tax'].'</div>'."\n";
      }
      
      if ($prices['points']) {
        $html.= ' <div class="reward">'.$text_points.' '.$prices['points'].'</div>'."\n";
      }
      
      if ($prices['discounts']) {
        $html.= ' <div class="discount">';
        foreach ($prices['discounts'] as $discount) {
          $html.= sprintf($text_discount, $discount['quantity'], $discount['price']).'<br />';
        }
        $html.= '</div>';
      }
      
    } elseif ($this->config->get('config_template') == 'bigshop') {
      
      $html = $text_price.' ';
      if (!$special) {
        $html.= '<div class="price-tag">';
        $html.= $price;
        $html.= '</div>';
      } else {
        $html.= '<span class="price-old">'.$price.'</span> <div class="price-tag"><span class="price-new">'.$special.'</span></div>';
      }
      $html.= '<br />';
      if ($tax) {
        $html.= '<span class="price-tax">'.$text_tax.' '.$tax.'</span><br />';
      }
      if ($points) {
        $html.= '<span class="reward"><small>'.$text_points.' '.$points.'</small></span><br />';
      }
      if ($discounts) {
        $html.= '<br />';
        $html.= '<div class="discount">';
          foreach ($discounts as $discount) {
            $html.= sprintf($text_discount, $discount['quantity'], $discount['price']);
            $html.= '<br />';
          }
        $html.= '</div>';
      }
      $html.= '<br />';
      //$html.= '<br />';
      
    } elseif ($this->config->get('config_template') == 'univer') {
    
      if (!$special) {
        $html.= $price;
      } else {
        $html.= '<span class="price-old">'.$price.'</span> <span class="price-new">'.$special.'</span>';
        if (isset($saving)) {
          $html.= ' <div  class="savemoney">- <?php echo $saving; ?>%</div>';
        }
      }
      $html.= '<br />';
      if ($tax) {
        $html.= '<span class="price-tax">'.$text_tax.' '.$tax.'</span><br />';
      }
      if ($points) {
        $html.= '<span class="reward"><small>'.$text_points.' '.$points.'</small></span><br />';
      }
      if ($discounts) {
        $html.= '<br />';
        $html.= '<div class="discount">';
          foreach ($discounts as $discount) {
           $html.= sprintf($text_discount, $discount['quantity'], $discount['price']).'<br />';
          }
        $html.= '</div>';
      }
      
    } elseif ($this->config->get('config_template') == 'shoppica2') {
      
      if ($quantity <= 0) {
        
        $this->load->model('catalog/product');
        $product_info = $this->model_catalog_product->getProduct($product_id);
        
				$stock_status = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$stock_status = $quantity;
			} else {
				$stock_status = $this->language->get('text_instock');
			}
      
      $this->language->load('shoppica2/global.lang');
      
      if (!$special) {
        $html1 .= '<p class="s_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
        $html1 .= '  <link itemprop="availability" content="'.str_replace(' ', '', strip_tags($stock_status)).'" />';
        $html1 .= '  <span itemprop="price">';
        $html1 .= $price;
        $html1 .= '  </span>';
        $html1 .= '</p>';
      } else {
        $html1 .= '<p class="s_price s_promo_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
        $html1 .= '  <link itemprop="availability" content="'.strtolower(str_replace(' ', '_', strip_tags($stock_status))).'" />';
        $html1 .= '  <span class="s_old_price">'.$price.'</span>';
        $html1 .= '  <span itemprop="price">';
        $html1 .= $special;
        $html1 .= '  </span>';
        $html1 .= '</p>';
      }
      if ($tax) {
        $html1 .= '<p class="s_price_tax">'.$text_tax.' '.$tax.'</p>';
      }
      if ($points) {
        $html1 .= '<p class="s_reward_points"><small>'.$text_points.' '.$points.'</small></p>';
      }
      
      if ($price && $discounts) {
        $html2 .= '<h3>'.$this->language->get('text_product_discount').'</h3>';
        $html2 .= '<table width="100%" class="s_table" border="0" cellpadding="0" cellspacing="0">';
        $html2 .= '  <tr>';
        $html2 .= '    <th>'.$this->language->get('text_product_order_quantity').'</th>';
        $html2 .= '    <th>'.$this->language->get('text_product_price_per_item').'</th>';
        $html2 .= '  </tr>';
        foreach ($discounts as $discount) {
          $html2 .= '<tr>';
          $html2 .= '  <td>'.sprintf($this->language->get('text_product_discount_items'), $discount['quantity']).'</td>';
          $html2 .= '  <td>'.$discount['price'].'</td>';
          $html2 .= '</tr>';
        }
        $html2 .= '</table>';
      }
      
    } else {
    
      $html = $text_price.' ';
      if (!$prices['special']) {
        $html.= $prices['price'];
      } else {
        $html.= '<span class="price-old">'.$prices['price'].'</span> <span class="price-new">'.$prices['special'].'</span>';
      }
      $html.= '<br />';
      //if ($tax) {
      if ($prices['tax']) {
        $html.= '<span class="price-tax">'.$text_tax.' '.$prices['tax'].'</span><br />';
      }
      
      if ($prices['points']) {
        $html.= '<span class="reward"><small>'.$text_points.' '.$prices['points'].'</small></span><br />';
      }
      
      if ($prices['discounts']) {
        $html.= '<br /><div class="discount">';
        foreach ($prices['discounts'] as $discount) {
          $html.= sprintf($text_discount, $discount['quantity'], $discount['price']).'<br />';
        }
        $html.= '</div>';
      }
    }
    
    
    return array('html'=>$html, 'html_d'=>$html_d, 'html1'=>$html1, 'html2'=>$html2);
  }


}

?>