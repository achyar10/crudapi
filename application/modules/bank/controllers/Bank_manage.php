<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_manage extends CI_Controller {

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
    $this->load->model(array('bank/Bank_model'));

  }

  public function index($offset = NULL) {
    $this->load->library('pagination');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
        // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['bank_name'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 5;
    $params['offset'] = $offset;
    $data['bank'] = $this->Bank_model->get($params);

    $config['per_page'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/bank/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Bank_model->get($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'BANK';
    $data['main'] = 'bank/bank_list';
    $this->load->view('manage/layout', $data);
  }

  public function add($id = NULL) {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('bank_vendor', 'Name of Bank', 'trim|required|xss_clean');
    $this->form_validation->set_rules('bank_account', 'Number Account', 'trim|required|xss_clean');
    $this->form_validation->set_rules('bank_name', 'Name of Account', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Add' : 'Edit';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('bank_id')) {
        $params['bank_id'] = $id;
        $params['bank_last_update'] = date('Y-m-d H:i:s');
      } 
      $params['bank_input_date'] = date('Y-m-d H:i:s');
      $params['bank_vendor'] = $this->input->post('bank_vendor');
      $params['bank_account'] = $this->input->post('bank_account');
      $params['bank_name'] = $this->input->post('bank_name');

      $this->Bank_model->add($params);

      $this->session->set_flashdata('success', $data['operation'] . ' bank success');
      redirect('manage/bank');
    } else {
      if ($this->input->post('bank_id')) {
        redirect('manage/bank/edit/' . $this->input->post('bank_id'));
      }

            // Edit mode
      if (!is_null($id)) {
        $object = $this->Bank_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/bank');
        } else {
          $data['bank'] = $object;
        }
      }

      $data['title'] = $data['operation'] . ' Bank';
      $data['main'] = 'bank/bank_add';
      $this->load->view('manage/layout', $data);
    }
  }

    // Delete to database
  public function delete($id = NULL) {
   if ($this->session->userdata('uroleid')!= SUPERADMIN){
    redirect('manage');
  }
  if ($_POST) {
    $this->Bank_model->delete($id);

    $this->session->set_flashdata('success', 'delete Bank success');
    redirect('manage/bank');
  } elseif (!$_POST) {
    $this->session->set_flashdata('delete', 'Delete');
    redirect('manage/bank/edit/' . $id);
  }
}

}

/* End of file bank_manage.php */
/* Location: ./application/modules/bank/controllers/bank_manage.php */