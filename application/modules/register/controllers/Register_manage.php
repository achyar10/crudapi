<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_manage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged') == NULL) {
			header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
		$list_access = array(SUPERADMIN);
		if (!in_array($this->session->userdata('uroleid'),$list_access)) {
			redirect('manage');
		}
		$this->load->model(array('merchant/Merchant_model', 'register/Register_model'));
		$this->load->helper('string');
	}

	public function index($offset = NULL) {
		$this->load->library('pagination');
		$f = $this->input->get(NULL, TRUE);

		$data['f'] = $f;

		$params = array();
        // Nip
		if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
			$params['merchant_name'] = $f['n'];
		}

		$paramsPage = $params;
		$params['limit'] = 5;
		$params['offset'] = $offset;
		$data['register'] = $this->Register_model->get($params);

		$config['per_page'] = 5;
		$config['uri_segment'] = 4;
		$config['base_url'] = site_url('manage/register/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['total_rows'] = count($this->Register_model->get($paramsPage));
		$this->pagination->initialize($config);

		$data['title'] = 'Register Machine';
		$data['main'] = 'register/register_list';
		$this->load->view('manage/layout', $data);
	}

	public function add($id = NULL) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('register_pin', 'PIN', 'trim|required|xss_clean|min_length[5]');
		$this->form_validation->set_rules('pinconf', 'Confirmation Pin', 'trim|required|xss_clean|min_length[5]|matches[register_pin]');
		$this->form_validation->set_rules('merchant_merchant_id', 'Merchant', 'trim|required|xss_clean');
		$this->form_validation->set_message('pinconf', 'Password dan Confirmation password not match');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

		if ($_POST AND $this->form_validation->run() == TRUE) {
			$merchant = $this->Merchant_model->get(array('id'=>$this->input->post('merchant_merchant_id')));
			$params['register_code'] = random_string('alnum', 16);
			$params['register_pin'] = md5(sha1(md5(sha1(md5(($this->input->post('register_pin')))))));
			$params['merchant_merchant_id'] = $this->input->post('merchant_merchant_id');
			$params['merchant_merchant_code'] = $merchant['merchant_code'];
			$params['register_status'] = 0;  
			$params['register_date'] = date('Y-m-d H:i:s'); 

			$this->Register_model->add($params);

			$this->session->set_flashdata('success', 'Register Machine success');
			redirect('manage/register');
		} else {

			$data['merchant'] = $this->Merchant_model->get();
			$data['title'] 		= 'Register Machine'; 
			$data['main'] 	= 'register/register_add';
			$this->load->view('manage/layout', $data);
		}
	}

	function unused() {
		if ($_POST == TRUE){
			$params['register_id'] = $this->input->post('register_id');
			$params['register_status'] = 0;
			$params['register_product_name'] = '';
			$params['register_imei'] = '';
			$params['register_serial'] = '';

			$this->Register_model->add($params);
			$this->session->set_flashdata('success', 'Unused Status success');
			redirect('manage/register');
		}
	}

}

/* End of file Register_manage.php */
/* Location: ./application/modules/register/controllers/Register_manage.php */