<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rent_manage extends CI_Controller {

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
    $this->load->model(array('rent/Rent_model'));

  }

  public function index($offset = NULL) {
    $this->load->library('pagination');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
        // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['rent_name'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 5;
    $params['offset'] = $offset;
    $data['rent'] = $this->Rent_model->get($params);

    $config['per_page'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/rent/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Rent_model->get($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Type Product';
    $data['main'] = 'rent/rent_list';
    $this->load->view('manage/layout', $data);
  }

  public function add($id = NULL) {
    $this->load->library('form_validation');

    $this->form_validation->set_rules('rent_type', 'Type Product', 'trim|required|xss_clean');
    $this->form_validation->set_rules('rent_price', 'Price Product', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Add' : 'Edit';

    if ($_POST AND $this->form_validation->run() == TRUE) {

      if ($this->input->post('rent_id')) {
        $params['rent_id'] = $id;
        $params['rent_last_update'] = date('Y-m-d H:i:s');
      } 
      $params['rent_input_date'] = date('Y-m-d H:i:s');
      $params['rent_type'] = $this->input->post('rent_type');
      $params['rent_price'] = $this->input->post('rent_price');

      $this->Rent_model->add($params);

      $this->session->set_flashdata('success', $data['operation'] . ' rent success');
      redirect('manage/rent');
    } else {
      if ($this->input->post('rent_id')) {
        redirect('manage/rent/edit/' . $this->input->post('rent_id'));
      }

            // Edit mode
      if (!is_null($id)) {
        $object = $this->Rent_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/rent');
        } else {
          $data['rent'] = $object;
        }
      }

      $data['title'] = $data['operation'] . 'Type Product';
      $data['main'] = 'rent/rent_add';
      $this->load->view('manage/layout', $data);
    }
  }

    // Delete to database
  public function delete($id = NULL) {
   if ($this->session->userdata('uroleid')!= SUPERADMIN){
    redirect('manage');
  }
  if ($_POST) {
    $this->Rent_model->delete($id);

    $this->session->set_flashdata('success', 'delete Type Product success');
    redirect('manage/rent');
  } elseif (!$_POST) {
    $this->session->set_flashdata('delete', 'Delete');
    redirect('manage/rent/edit/' . $id);
  }
}

}

/* End of file rent_manage.php */
/* Location: ./application/modules/rent/controllers/rent_manage.php */