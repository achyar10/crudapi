<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_manage extends CI_Controller {

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
    $data['branch'] = $this->Branch_model->get($params);

    $config['per_page'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/branch/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Branch_model->get($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Branch';
    $data['main'] = 'branch/branch_list';
    $this->load->view('manage/layout', $data);
  }

  public function add($id = NULL) {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('branch_name', 'Merchant Name', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Add' : 'Edit';

    if ($_POST AND $this->form_validation->run() == TRUE) {
      $merchant = $this->Merchant_model->get(array('id' => $this->input->post('merchant_merchant_id')));
      if ($this->input->post('branch_id')) {
        $params['branch_id'] = $id;
        $params['branch_last_update'] = date('Y-m-d H:i:s');
      } 
      $params['branch_input_date'] = date('Y-m-d H:i:s');
      $params['branch_name'] = $this->input->post('branch_name');
      $params['merchant_merchant_id'] = $this->input->post('merchant_merchant_id');
      $params['merchant_merchant_code'] = $merchant['merchant_code'];
      $params['branch_tlp'] = $this->input->post('branch_tlp');
      $params['branch_address'] = $this->input->post('branch_address');

      $this->Branch_model->add($params);

      $this->session->set_flashdata('success', $data['operation'] . ' Branch success');
      redirect('manage/branch');
    } else {
      if ($this->input->post('branch_id')) {
        redirect('manage/branch/edit/' . $this->input->post('branch_id'));
      }

            // Edit mode
      if (!is_null($id)) {
        $object = $this->Branch_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/branch');
        } else {
          $data['branch'] = $object;
        }
      }

      $data['title'] = $data['operation'] . ' Branch';
      $data['main'] = 'branch/branch_add';
      $this->load->view('manage/layout', $data);
    }
  }

    // View data detail
  public function view($id = NULL) {

    if ($_POST) {
      $merchant = $this->Merchant_model->get(array('id' => $id));
      $params['user_merchant_input_date'] = date('Y-m-d H:i:s');
      $params['user_merchant_password'] = sha1($this->input->post('user_merchant_password'));
      $params['user_merchant_email'] = $this->input->post('user_merchant_email');
      $params['merchant_merchant_id'] = $id;
      $params['merchant_merchant_code'] = $merchant['merchant_code'];
      $params['branch_branch_id'] = $this->input->post('branch_branch_id');
      $params['user_merchant_status'] = $this->input->post('user_merchant_status');
      $params['user_merchant_full_name'] = $this->input->post('user_merchant_full_name');

      $this->User_merchant_model->add($params);

      $this->session->set_flashdata('success', 'Add User Merchant success');
      redirect('manage/merchant/view/'.$id);

    } else {
      $data['merchant'] = $this->Merchant_model->get(array('id' => $id));
      $data['branch'] = $this->Branch_model->get(array('merchant_id' => $id));
      $data['user_merchant'] = $this->User_merchant_model->get(array('merchant_id' => $id));
      $data['title'] = 'Merchant Detail';
      $data['main'] = 'merchant/merchant_view';
      $this->load->view('manage/layout', $data);
    }
  }


  public function edit_user($id = NULL, $user_merchant = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('user_merchant_full_name', 'User Full Name', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible fade show"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');

    $merchant = $this->Merchant_model->get(array('id' => $id));

    if ($_POST AND $this->form_validation->run() == TRUE) {

      $params['user_merchant_id'] = $user_merchant;
      $params['merchant_merchant_id'] = $id;
      $params['user_merchant_email'] = $this->input->post('user_merchant_email');
      $params['user_merchant_last_update'] = date('Y-m-d H:i:s');
      $params['merchant_merchant_code'] = $merchant['merchant_code'];
      $params['branch_branch_id'] = $this->input->post('branch_branch_id');
      $params['user_merchant_status'] = $this->input->post('user_merchant_status');
      $params['user_merchant_full_name'] = $this->input->post('user_merchant_full_name');

      $this->User_merchant_model->add($params);
      $this->session->set_flashdata('success', 'Edit User Merchant success');
      redirect('manage/merchant/view/'.$id);

    } else {
      $data['user_merchant'] = $this->User_merchant_model->get(array('id' => $user_merchant));
      $data['title'] ='Edit User Merchant';
      $data['main'] = 'merchant/user_merchant_edit';
      $this->load->view('manage/layout', $data);
    }
  }


    // Delete to database
  public function delete($id = NULL) {
   if ($this->session->userdata('uroleid')!= SUPERADMIN){
    redirect('manage');
  }
  if ($_POST) {
    $this->Merchant_model->delete($id);

    $this->session->set_flashdata('success', 'delete User success');
    redirect('manage/merchant');
  } elseif (!$_POST) {
    $this->session->set_flashdata('delete', 'Delete');
    redirect('manage/merchant/edit/' . $id);
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
    redirect('manage/merchant/view/'.$id);
  } else {
    if ($this->User_merchant_model->get(array('id' => $user_merchant)) == NULL) {
      redirect('manage/merchant/view/'.$id);
    }
    $data['user_merchant'] = $this->User_merchant_model->get(array('id' => $user_merchant));
    $data['title'] = 'Reset Password';
    $data['main'] = 'merchant/user_merchant_rpw';
    $this->load->view('manage/layout', $data);
  }
}

}

/* End of file Merchant_manage.php */
/* Location: ./application/modules/merchant/controllers/Merchant_manage.php */