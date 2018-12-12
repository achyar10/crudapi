<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_merchant extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('logged_merchant') == NULL) {
			header("Location:" . site_url('merchant/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
		}
		
		$this->load->model(array('merchant/Merchant_model', 'branch/Branch_model', 'user_merchant/User_merchant_model'));
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
		$params['merchant_id'] = $this->session->userdata('merchant_id');
		$data['branch'] = $this->Branch_model->get($params);

		$config['per_page'] = 5;
		$config['uri_segment'] = 4;
		$config['base_url'] = site_url('merchant/branch/index');
		$config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config['total_rows'] = count($this->Branch_model->get($paramsPage));
		$this->pagination->initialize($config);

		$data['title'] = 'Branch';
		$data['main'] = 'branch/branch_list_merchant';
		$this->load->view('merchant/layout', $data);
	}

	public function add($id = NULL) {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
		$data['operation'] = is_null($id) ? 'Add' : 'Edit';

		if ($_POST AND $this->form_validation->run() == TRUE) {
			if ($this->input->post('branch_id')) {
				$params['branch_id'] = $id;
				$params['branch_last_update'] = date('Y-m-d H:i:s');
			} 
			$params['branch_input_date'] = date('Y-m-d H:i:s');
			$params['branch_name'] = $this->input->post('branch_name');
			$params['merchant_merchant_id'] = $this->session->userdata('merchant_id');
			$params['merchant_merchant_code'] = $this->session->userdata('merchant_code');
			$params['branch_tlp'] = $this->input->post('branch_tlp');
			$params['branch_address'] = $this->input->post('branch_address');

			$this->Branch_model->add($params);

			$this->session->set_flashdata('success', $data['operation'] . ' Branch success');
			redirect('merchant/branch');
		} else {
			if ($this->input->post('branch_id')) {
				redirect('merchant/branch/edit/' . $this->input->post('branch_id'));
			}

            // Edit mode
			if (!is_null($id)) {
				$object = $this->Branch_model->get(array('id' => $id));
				if ($object == NULL) {
					redirect('merchant/branch');
				} else {
					$data['branch'] = $object;
				}
			}

			$data['title'] = $data['operation'] . ' Branch';
			$data['main'] = 'branch/branch_add_merchant';
			$this->load->view('merchant/layout', $data);
		}
	}

	public function view($id = NULL) { 

		if ($this->input->post('userAdd') == 'user') {

			$params['user_merchant_input_date'] = date('Y-m-d H:i:s');
			$params['user_merchant_password'] = sha1($this->input->post('user_merchant_password'));
			$params['user_merchant_email'] = $this->input->post('user_merchant_email');
			$params['merchant_merchant_id'] = $this->session->userdata('merchant_id');
			$params['merchant_merchant_code'] = $this->session->userdata('merchant_code');
			
			$params['branch_branch_id'] = $id;
			$params['user_merchant_status'] = $this->input->post('user_merchant_status');
			$params['user_merchant_full_name'] = $this->input->post('user_merchant_full_name');

			$this->User_merchant_model->add($params);

			$this->session->set_flashdata('success', 'Add User Branch success');
			redirect('merchant/branch/view/'.$id);

		} else {
			$data['branch'] = $this->Branch_model->get(array('id' => $id));
			$data['user_merchant'] = $this->User_merchant_model->get(array('branch_id' => $id));
			$data['title'] = 'Branch Detail';
			$data['main'] = 'branch/branch_view_merchant';
			$this->load->view('merchant/layout', $data);
		}
	}

	public function edit_user($id = NULL, $user_branch = NULL) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_merchant_full_name', 'User Full Name', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

		if ($_POST AND $this->form_validation->run() == TRUE) {

			$params['user_merchant_id'] = $user_branch;
			$params['user_merchant_email'] = $this->input->post('user_merchant_email');
			$params['user_merchant_last_update'] = date('Y-m-d H:i:s');
			$params['user_merchant_status'] = $this->input->post('user_merchant_status');
			$params['user_merchant_full_name'] = $this->input->post('user_merchant_full_name');

			$this->User_merchant_model->add($params);
			$this->session->set_flashdata('success', 'Edit User Branch success');
			redirect('merchant/branch/view/'.$id);

		} else {
			$data['user_merchant'] = $this->User_merchant_model->get(array('id' => $user_branch));
			$data['title'] ='Edit User Merchant';
			$data['main'] = 'branch/user_branch_edit';
			$this->load->view('merchant/layout', $data);
		}
	}


    // Delete to database
	public function delete($id = NULL) {
		if ($_POST) {
			$this->Merchant_model->delete($id);

			$this->session->set_flashdata('success', 'delete User success');
			redirect('merchant/branch');
		} elseif (!$_POST) {
			$this->session->set_flashdata('delete', 'Delete');
			redirect('merchant/branch/edit/' . $id);
		}
	}

	function rpw($id = NULL, $user_merchant = NULL) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_merchant_password', 'Password', 'trim|required|xss_clean|min_length[6]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean|min_length[6]|matches[user_merchant_password]');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
		if ($_POST AND $this->form_validation->run() == TRUE) {
			$user_merchant = $this->input->post('user_merchant_id');
			$params['user_merchant_password'] = sha1($this->input->post('user_merchant_password'));
			$status = $this->User_merchant_model->change_password($user_merchant, $params);

			$this->session->set_flashdata('success', 'Reset Password success');
			redirect('merchant/branch/view/'.$id);
		} else {
			if ($this->User_merchant_model->get(array('id' => $user_merchant)) == NULL) {
				redirect('merchant/branch/view/'.$id);
			}
			$data['user_merchant'] = $this->User_merchant_model->get(array('id' => $user_merchant));
			$data['title'] = 'Reset Password';
			$data['main'] = 'branch/user_branch_rpw';
			$this->load->view('merchant/layout', $data);
		}
	}

}

/* End of file Branch_merchant.php */
/* Location: ./application/modules/branch/controllers/Branch_merchant.php */