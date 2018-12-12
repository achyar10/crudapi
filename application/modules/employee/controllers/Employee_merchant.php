<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_merchant extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_merchant') == NULL) {
			header("Location:" . site_url('merchant/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}

		$this->load->model(array('employee/Employee_model', 'branch/Branch_model'));
	}

	public function index($offset = NULL) {
		$this->load->library('pagination');
		$f = $this->input->get(NULL, TRUE);

		$data['f'] = $f;

		$params = array();
        // Nip
		if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
			$params['employee_name'] = $f['n'];
		}

		$paramsPage = $params;
		$params['limit'] = 5;
		$params['offset'] = $offset;
		$data['employee'] = $this->Employee_model->get($params);

		$config['per_page'] = 5;
		$config['uri_segment'] = 4;
		$config['base_url'] = site_url('merchant/employee/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['total_rows'] = count($this->Employee_model->get($paramsPage));
		$this->pagination->initialize($config);

		$data['title'] = 'Employee';
		$data['main'] = 'employee/employee_list';
		$this->load->view('merchant/layout', $data);
	}

	public function add($id = NULL) {
		$this->load->library('form_validation');

		if (!$this->input->post('employee_id')) {
			$this->form_validation->set_rules('employee_email', 'Email', 'trim|required|xss_clean|is_unique[employees.employee_email]');
			$this->form_validation->set_rules('employee_nip', 'NIP', 'trim|required|xss_clean|is_unique[employees.employee_nip]');
		}

		$this->form_validation->set_rules('employee_full_name', 'Full Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('branch_id', 'Select Branch', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
		$data['operation'] = is_null($id) ? 'Add' : 'Edit';

		if ($_POST AND $this->form_validation->run() == TRUE) {

			if ($this->input->post('employee_id')) {
				$params['employee_id'] = $id;
				$params['employee_last_update'] = date('Y-m-d H:i:s');
			} else {
				$params['employee_input_date'] = date('Y-m-d H:i:s');
				$params['employee_email'] = $this->input->post('employee_email');
				$params['employee_nip'] = $this->input->post('employee_nip');
			}

			$params['branch_branch_id'] = $this->input->post('branch_id');
			$params['merchant_merchant_id'] = $this->session->userdata('merchant_id');
			$params['merchant_merchant_code'] = $this->session->userdata('merchant_code');
			$params['employee_full_name'] = $this->input->post('employee_full_name');
			$params['employee_pob'] = $this->input->post('employee_pob');
			$params['employee_dob'] = $this->input->post('employee_dob');

			$date = str_replace('-', '', $this->input->post('employee_dob'));
			$params['employee_password'] = password_hash(date('dmy', strtotime($date)), PASSWORD_DEFAULT);

			$params['employee_tlp'] = $this->input->post('employee_tlp');
			$params['employee_address'] = $this->input->post('employee_address');
			$params['employee_country'] = $this->input->post('employee_country');
			$params['employee_ktp'] = $this->input->post('employee_ktp');
			$params['employee_npwp'] = $this->input->post('employee_npwp');
			$params['employee_status'] = $this->input->post('employee_status');

			$status = $this->Employee_model->add($params);
			$generate = date('Ymdhis');
			if (!empty($_FILES['employee_photo']['name'])) {
        $paramsupdate['employee_photo'] = $this->do_upload($name = 'employee_photo', $fileName= $generate);
      } 

      $paramsupdate['employee_id'] = $status;
      $this->Employee_model->add($paramsupdate);

			$this->session->set_flashdata('success', $data['operation'] . ' Employee success');
			redirect('merchant/employee');
		} else {
			if ($this->input->post('employee_id')) {
				redirect('merchant/employee/edit/' . $this->input->post('employee_id'));
			}

            // Edit mode
			if (!is_null($id)) {
				$object = $this->Employee_model->get(array('id' => $id));
				if ($object == NULL) {
					redirect('merchant/employee');
				} else {
					$data['employee'] = $object;
				}
			}

			$data['branch'] = $this->Branch_model->get(array('merchant_id'=>$this->session->userdata('merchant_id'), 'id'=> $this->session->userdata('branch_id')));
			$data['title'] = $data['operation'] . ' Employee';
			$data['main'] = 'employee/employee_add';
			$this->load->view('merchant/layout', $data);
		}
	}

	function do_upload($name=NULL, $fileName=NULL) {
    $this->load->library('upload');

    $config['upload_path'] = FCPATH . 'uploads/employee/';

    /* create directory if not exist */
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }

    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '2024';
    $config['file_name'] = $fileName;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($name)) {
      $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
      redirect(uri_string());
    }

    $upload_data = $this->upload->data();

    return $upload_data['file_name'];
  }

}

/* End of file Employee_merchant.php */
/* Location: ./application/modules/employee/controllers/Employee_merchant.php */