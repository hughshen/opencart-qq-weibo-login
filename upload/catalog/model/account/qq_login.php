<?php
class ModelAccountQQLogin extends Model {
	public function getOpenidRecord ($openid, $customer_id = false) {
		if ($customer_id){
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "qq_login WHERE customer_id = '" . (int)$customer_id . "'");
		} else {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "qq_login WHERE openid = '" . $this->db->escape($openid) . "'");
		}
		return $query->row['total'];
	}
	
	public function addCustomer ($openid) {

		$customer_group_id = $this->config->get('config_customer_group_id');

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', fax = '', custom_field = '', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', newsletter = '0', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");

		$customer_id = $this->db->getLastId();
			
      	$this->db->query("INSERT INTO " . DB_PREFIX . "qq_login SET customer_id = '" . (int)$customer_id . "', openid = '" . $openid . "'");
	}

	public function getCustomerInfoByOpenid ($openid) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "qq_login WHERE openid = '" . $this->db->escape($openid) . "'");
		
		return $query->row;
	}
}
?>