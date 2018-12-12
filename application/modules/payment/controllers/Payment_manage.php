<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_manage extends CI_Controller {

	public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('register/Register_model', 'payment/Payment_model'));

  }

	public function index($offset = NULL) {
    $this->load->library('pagination');
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
        // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['status'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 5;
    $params['offset'] = $offset;
    $data['payment'] = $this->Payment_model->get($params);

    $config['per_page'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/payment/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Payment_model->get($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Payment';
    $data['main'] = 'payment/payment_list';
    $this->load->view('manage/layout', $data);
  }

  public function view($id = NULL) {
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['title'] = 'Payment Detail';
      $data['main'] = 'payment/payment_view';
      $this->load->view('manage/layout', $data);
  }

  function approve($id = NULL) {
		$pay = $this->Payment_model->get(array('id'=>$id));
		$machine = $this->Register_model->get(array('merchant'=>$pay['merchant_merchant_code']));
		$date = date('Y-m-d');
		$date = date('Y-m-d', strtotime($date));
		$tempo = $machine[0]['register_due_date'];
		$tempo = date('Y-m-d', strtotime($tempo));
		$this->Payment_model->add(array(
			'payment_id' => $id,
			'payment_status' => 2
		));

		$params['merchant_merchant_id'] = $pay['merchant_merchant_id'];
		$params['merchant_merchant_code'] = $pay['merchant_merchant_code'];

		if ($tempo > $date) {
			$params['register_input_date'] = $tempo;
			$params['register_due_date'] = date('Y-m-d', strtotime('+'.$pay['payment_month'].' month', strtotime($tempo)));
		} else {
			$params['register_input_date'] = $date;
			$params['register_due_date'] = date('Y-m-d', strtotime('+'.$pay['payment_month'].' month', strtotime($date)));
		}

		$this->Register_model->update_due($params);
		$this->session->set_flashdata('success', 'Approve Payment success');
    redirect('manage/payment');
	}

	function reject($id = NULL) {
		$pay = $this->Payment_model->get(array('id'=>$id));
		
		$this->Payment_model->add(array(
			'payment_id' => $id,
			'payment_status' => 3
		));

		$this->session->set_flashdata('success', 'Approve Payment success');
		redirect('manage/payment');
	}

}

/* End of file Payment_manage.php */
/* Location: ./application/modules/payment/controllers/Payment_manage.php */