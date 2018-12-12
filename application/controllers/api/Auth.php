<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/User_model');
	}

	public function index_get() {
		$res = array('message' => 'Nothing here');

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($res));
	}

	public function index_post() {
		$res = array('message' => 'Nothing here');

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($res));
	}

	function login_post() {
		$email = $this->post('email');
		$password = $this->post('password');

		try {

			if(empty($email)) {
				throw new Exception('Email not empty');
			}

			if(empty($password)) {
				throw new Exception('Password not empty');
			}

			$usr = $this->User_model->get_user(array('user_email'=>$email))->row_array();

			$pwd_hash = password_verify($usr['user_password'], $password);

			$user = $this->User_model->get_user(array('user_email'=>$email, 'user_password'=>$pwd_hash))->row_array();

			if(count($user) == 0) {
				throw new Exception('user not found');
			}

			$this->response(REST_Controller::Success_($user));

		} catch(Exception $e) {
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function reg_post() {
		$email = $this->post('email');
		$password = $this->post('password');
		$fullname = $this->post('full_name');
		$cdate = date('Y-m-d H:i:s');

		try {

			if(empty($email)) {
				throw new Exception('Email not empty');
			}

			if(empty($password)) {
				throw new Exception('Password not empty');
			}

			if(empty($fullname)) {
				throw new Exception('Full Name not empty');
			}

			$user = $this->User_model->get_user(array('user_email'=>$email))->row_array();

			if($email == $user['user_email']) {
				throw new Exception('Email Already Exist');
			}

			$params['user_email'] = $email;
			$params['user_password'] = password_hash($password,PASSWORD_DEFAULT);
			$params['user_full_name'] = $fullname;
			$params['user_input_date'] = $cdate;

			$this->User_model->insert($params);
			$this->response(REST_Controller::Success_($params));

		} catch(Exception $e) {
			$this->response(REST_Controller::Exception_($e));
		}
	}

	function list_user_get() {

		try {

			$user = $this->User_model->get_user()->result_array();

			$this->response(REST_Controller::Success_($user));

		} catch(Exception $e) {
			$this->response(REST_Controller::Exception_($e));
		}
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/api/Auth.php */