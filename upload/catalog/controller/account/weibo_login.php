<?php 
class ControllerAccountWeiboLogin extends Controller {
	private $error = array();
	
	public function index() {

		if($this->config->get('weibo_login_status') !== '1') {
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/weibo_login');
		$weibo_uid = '';
		if ( $this->request->server['REQUEST_METHOD'] == 'GET')  {

			if(isset($_REQUEST['code'])){

				require_once(DIR_SYSTEM.'weiboSDK/oauth2.class.php');

				$appkey = $this->config->get('weibo_login_appkey');
				$appsecret = $this->config->get('weibo_login_secret');

				$o = new SaeTOAuthV2($appkey, $appsecret);
				
				$keys = array();
				$keys['code'] = $_REQUEST['code'];
				$keys['redirect_uri'] = $this->url->link('account/weibo_login');

				try {			
					$token = $o->getAccessToken('code', $keys) ;
					$c = new SaeTClientV2($appkey, $appsecret, $token['access_token']); 
					$uid_get = $c->get_uid();
					$weibo_uid = $uid_get['uid'];
				} catch (OAuthException $e) {

				}
			} else {				
				$this->response->redirect($this->url->link('account/login', '', 'SSL'));
			}
				
    	} else {
    		// POST
    		$weibo_uid = $this->request->post['weibo_uid'];
		}

		if (empty($weibo_uid)) {
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (!$this->model_account_weibo_login->getUidRecord($weibo_uid)) {
			// New customer
			$this->model_account_weibo_login->addCustomer($weibo_uid);
		}

    	if ($this->model_account_weibo_login->getUidRecord($weibo_uid)) {
			unset($this->session->data['guest']);
			
			$customerInfo = $this->model_account_weibo_login->getCustomerInfoByUid($weibo_uid);
			
			$this->session->data['customer_id'] = $customerInfo['customer_id'];

			$this->customer->loginThridPart($customerInfo);
			
	  		$this->response->redirect($this->url->link('account/account'));
    	}
  	}
}
?>