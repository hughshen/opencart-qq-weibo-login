<?php

class ControllerToolWeiboLogin extends Controller {
	private $error = array(); 
	
	public function index() {

		$this->load->language('tool/weibo_login');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_setting_setting->editSetting('weibo_login', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('tool/weibo_login', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['table'] = false;
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_form'] = $this->language->get('text_form');
		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_appkey'] = $this->language->get('entry_appkey'); 
		$data['entry_secret'] = $this->language->get('entry_secret');
		
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

		if (isset($this->error['secret'])) {
			$data['error_secret'] = $this->error['secret'];
		} else {
			$data['error_secret'] = '';
		}

		$this->document->setTitle($this->language->get('heading_title'));

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);
		
		$data['action'] = $this->url->link('tool/weibo_login', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		
		
		if (isset($this->request->post['weibo_login_appkey'])) {
			$data['weibo_appkey'] = $this->request->post['weibo_login_appkey'];
		} else {
			$data['weibo_appkey'] = $this->config->get('weibo_login_appkey');
		}
		
		if (isset($this->request->post['weibo_login_secret'])) {
			$data['weibo_secret'] = $this->request->post['weibo_login_secret'];
		} else {
			$data['weibo_secret'] = $this->config->get('weibo_login_secret');
		}

		if (isset($this->request->post['weibo_login_status'])) {
			$data['status'] = $this->request->post['weibo_login_status'];
		} else {
			$data['status'] = $this->config->get('weibo_login_status');
		}
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('tool/weibo_login.tpl', $data));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/weibo_login')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['weibo_login_appkey']) {
			$this->error['appkey'] = $this->language->get('error_appkey');
		}

		if (!$this->request->post['weibo_login_secret']) {
			$this->error['secret'] = $this->language->get('error_secret');
		}
		
		return !$this->error;
	}
}
?>