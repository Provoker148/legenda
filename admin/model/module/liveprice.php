<?php

//  Live Price / Динамическое обновление цены - живая цена
//  Support: support@liveopencart.com / Поддержка: opencart@19th19th.ru

class ModelModuleLivePrice extends Model {

  public function installed() {
    
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'module' AND `code` = 'liveprice'");
    
    return $query->num_rows;
  }


}

?>