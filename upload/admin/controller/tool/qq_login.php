<?php

class ControllerToolQQLogin extends Controller {
	private $error = array(); 
	
	public function index() {

		$this->load->language('tool/qq_login');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('qq_login', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('tool/qq_login', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['table'] = false;
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_form'] = $this->language->get('text_form');
		
		$data['entry_status'] = $this->language->get('entry_status'); 
		$data['entry_appid'] = $this->language->get('entry_appid');
		$data['entry_appkey'] = $this->language->get('entry_appkey'); 
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		} else {
			$data['success'] = '';
		}
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['appkey'])) {
			$data['error_appkey'] = $this->error['appkey'];
		} else {
			$data['error_appkey'] = '';
		}

		if (isset($this->error['appid'])) {
			$data['error_appid'] = $this->error['appid'];
		} else {
			$data['error_appid'] = '';
		}

		$this->document->setTitle($this->language->get('heading_title'));

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
		$data['action'] = $this->url->link('tool/qq_login', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['qq_login_appid'])) {
			$data['qq_appid'] = $this->request->post['qq_login_appid'];
		} else {
			$data['qq_appid'] = $this->config->get('qq_login_appid');
		}
		
		if (isset($this->request->post['qq_login_appkey'])) {
			$data['qq_appkey'] = $this->request->post['qq_login_appkey'];
		} else {
			$data['qq_appkey'] = $this->config->get('qq_login_appkey');
		}

		if (isset($this->request->post['qq_login_status'])) {
			$data['status'] = $this->request->post['qq_login_status'];
		} else {
			$data['status'] = $this->config->get('qq_login_status');
		}
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('tool/qq_login.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/qq_login')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['qq_login_appid']) {
			$this->error['appid'] = $this->language->get('error_appid');
		}

		if (!$this->request->post['qq_login_appkey']) {
			$this->error['appkey'] = $this->language->get('error_appkey');
		}
		
		return !$this->error;
	}
}
?>