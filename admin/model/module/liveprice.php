<?php

//  Live Price / ������������ ���������� ���� - ����� ����
//  Support: support@liveopencart.com / ���������: opencart@19th19th.ru

class ModelModuleLivePrice extends Model {

  public function installed() {
    
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'module' AND `code` = 'liveprice'");
    
    return $query->num_rows;
  }


}

?>