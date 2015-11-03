<?php 
class ControllerAccountQQLogin extends Controller {
	private $error = array();
	
	public function index() {
		
		if ((!$this->request->server['REQUEST_METHOD'] == 'POST') || 
			empty($this->request->post['openid']) || 
				$this->config->get('qq_login_status') !== '1') {
	  		$this->response->redirect($this->url->link('account/login', '', 'SSL'));
    	}
	 
		$this->load->model('account/qq_login');

		if (!$this->model_account_qq_login->getOpenidRecord($this->request->post['openid'])) {
			// New customer
			$this->model_account_qq_login->addCustomer($this->request->post['openid']);
		}

    	if ($this->model_account_qq_login->getOpenidRecord($this->request->post['openid'])) {
			unset($this->session->data['guest']);
			
			$customerInfo = $this->model_account_qq_login->getCustomerInfoByOpenid($this->request->post['openid']);
			
			$this->session->data['customer_id'] = $customerInfo['customer_id'];

			$this->customer->loginThridPart($customerInfo);
			
	  		$this->response->redirect($this->url->link('account/account'));
    	}
  	}
}
?>