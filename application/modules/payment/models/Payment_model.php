<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {

public function __construct()
{
	parent::__construct();
}
	
function get($params=array()){

	if(isset($params['id']))
    {
      $this->db->where('payments.payment_id', $params['id']);
    }

    if(isset($params['merchant_code']))
    {
      $this->db->where('payments.merchant_code', $params['merchant_code']);
    }

    if(isset($params['status']))
    {
      $this->db->where('payments.payment_status', $params['status']);
    }

    if(isset($params['payment_input_date']))
    {
      $this->db->where('payment_input_date', $params['payment_input_date']);
    }


    if(isset($params['group']))
    {

      $this->db->group_by('payments.payment_id'); 

    }

    if(isset($params['limit']))
    {
      if(!isset($params['offset']))
      {
        $params['offset'] = NULL;
      }

      $this->db->limit($params['limit'], $params['offset']);
    }

    if(isset($params['order_by']))
    {
      $this->db->order_by($params['order_by'], 'desc');
    }
    else
    {
      $this->db->order_by('payment_input_date', 'desc');
    }

    $this->db->select('payment_id, payment_month, payment_total, payment_proof, payment_name, payment_account, payment_status, payment_input_date, payment_last_update');
    $this->db->select('payments.merchant_merchant_id, payments.merchant_merchant_code, merchant_name');
    $this->db->select('payments.bank_bank_id, bank_vendor, bank_account, bank_name');
    $this->db->select('payments.rent_rent_id, rent_type, rent_price');
    $this->db->select('register_input_date, register_due_date');

    $this->db->join('merchants', 'merchants.merchant_id = payments.merchant_merchant_id', 'left');
    $this->db->join('registers', 'registers.merchant_merchant_id = payments.merchant_merchant_id', 'left');
    $this->db->join('banks', 'banks.bank_id = payments.bank_bank_id', 'left');
    $this->db->join('rents', 'rents.rent_id = payments.rent_rent_id', 'left');

    $res = $this->db->get('payments');

    if(isset($params['id']))
    {
      return $res->row_array();
    } else {
      return $res->result_array();
    }
  }

  function get_bank($params=array()){

  	if(isset($params['id']))
    {
      $this->db->where('banks.bank_id', $params['id']);
    }

    if(isset($params['order_by']))
    {
      $this->db->order_by($params['order_by'], 'desc');
    }
    else
    {
      $this->db->order_by('bank_name', 'asc');
    }

    $this->db->select('*');

    $res = $this->db->get('banks');

    if(isset($params['id'])){
    	return $res->row_array();
    } else {
    	return $res->result_array();
    }
  }

  function get_rent($params=array()){

  	if(isset($params['id']))
    {
      $this->db->where('rents.rent_id', $params['id']);
    }

    if(isset($params['order_by']))
    {
      $this->db->order_by($params['order_by'], 'desc');
    }
    else
    {
      $this->db->order_by('rent_type', 'asc');
    }

    $this->db->select('*');

    $res = $this->db->get('rents');

    if(isset($params['id'])){
    	return $res->row_array();
    } else {
    	return $res->result_array();
    }
  }

  function add($data = array()) {

		if (isset($data['payment_id'])) {
			$this->db->set('payment_id', $data['payment_id']);
		}

		if (isset($data['merchant_merchant_code'])) {
			$this->db->set('merchant_merchant_code', $data['merchant_merchant_code']);
		}

    if (isset($data['merchant_merchant_id'])) {
      $this->db->set('merchant_merchant_id', $data['merchant_merchant_id']);
    }

		if (isset($data['payment_month'])) {
			$this->db->set('payment_month', $data['payment_month']);
		}

		if (isset($data['payment_total'])) {
			$this->db->set('payment_total', $data['payment_total']);
		}

		if (isset($data['bank_bank_id'])) {
			$this->db->set('bank_bank_id', $data['bank_bank_id']);
		}

		if (isset($data['rent_rent_id'])) {
			$this->db->set('rent_rent_id', $data['rent_rent_id']);
		}

		if (isset($data['payment_proof'])) {
			$this->db->set('payment_proof', $data['payment_proof']);
		}

		if (isset($data['payment_name'])) {
			$this->db->set('payment_name', $data['payment_name']);
		}

		if (isset($data['payment_account'])) {
			$this->db->set('payment_account', $data['payment_account']);
		}

		if (isset($data['payment_status'])) {
			$this->db->set('payment_status', $data['payment_status']);
		}

		if (isset($data['payment_input_date'])) {
			$this->db->set('payment_input_date', $data['payment_input_date']);
		}

    if (isset($data['payment_last_update'])) {
      $this->db->set('payment_last_update', $data['payment_last_update']);
    }

		if (isset($data['payment_id'])) {
			$this->db->where('payment_id', $data['payment_id']);
			$this->db->update('payments');
			$id = $data['payment_id'];
		} else {
			$this->db->insert('payments');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

}

/* End of file Payment_model.php */
/* Location: ./application/models/Payment_model.php */