<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_merchant extends CI_Controller {

	public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('merchant/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $list_access = array(SUPERADMIN);
    if (!in_array($this->session->userdata('uroleid'),$list_access)) {
      redirect('merchant');
    }
    $this->load->model(array('register/Register_model'));
    $this->load->helper('string');
  }

	public function index($offset = NULL) {
		$this->load->library('pagination');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();

    $paramsPage = $params;
    $params['limit'] = 5;
    $params['offset'] = $offset;
    $params['merchant_id'] = $this->session->userdata('merchant_id');
    $data['register'] = $this->Register_model->get($params);

    $config['per_page'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('merchant/register/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Register_model->get($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Lisence Machine';
    $data['main'] = 'register/register_list_merchant';
    $this->load->view('merchant/layout', $data);
	}

}

/* End of file Register_merchant.php */
/* Location: ./application/modules/register/controllers/Register_merchant.php */