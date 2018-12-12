<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    // Get From Databases 
	function get($params = array()) {

		if (isset($params['id'])) {
			$this->db->where('registers.register_id', $params['id']);
		}

		if (isset($params['merchant_code'])) {
			$this->db->where('registers.merchant_merchant_code', $params['merchant_code']);
		}

		if (isset($params['merchant_id'])) {
			$this->db->where('registers.merchant_merchant_id', $params['merchant_id']);
		}

		if (isset($params['status'])) {
			$this->db->where('register_status', $params['status']);
		}


		if (isset($params['limit'])) {
			if (!isset($params['offset'])) {
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		if (isset($params['order_by'])) {
			$this->db->order_by($params['order_by'], 'desc');
		} else {
			$this->db->order_by('registers.register_date', 'desc');
		}

		$this->db->select('*');

		$this->db->join('merchants', 'merchants.merchant_id = registers.merchant_merchant_id', 'left');

		$res = $this->db->get('registers');

		if (isset($params['id'])) {
			return $res->row_array();
		} else {
			return $res->result_array();
		}
	}

	function get_merchant($params = array()) {

		if (isset($params['id'])) {
			$this->db->where('merchants.merchant_id', $params['id']);
		}

		if (isset($params['merchant'])) {
			$this->db->where('merchants.merchant_code', $params['merchant']);
		}


		if (isset($params['limit'])) {
			if (!isset($params['offset'])) {
				$params['offset'] = NULL;
			}

			$this->db->limit($params['limit'], $params['offset']);
		}

		if (isset($params['order_by'])) {
			$this->db->order_by($params['order_by'], 'desc');
		} else {
			$this->db->order_by('merchants.merchant_id', 'desc');
		}

		$this->db->select('*');

		$res = $this->db->get('merchants');

		if (isset($params['id'])) {
			return $res->row_array();
		} else {
			return $res->result_array();
		}
	}


	function add($data = array()) {

		if (isset($data['register_id'])) {
			$this->db->set('register_id', $data['register_id']);
		}

		if (isset($data['register_code'])) {
			$this->db->set('register_code', $data['register_code']);
		}

		if (isset($data['register_pin'])) {
			$this->db->set('register_pin', $data['register_pin']);
		}

		if (isset($data['register_date'])) {
			$this->db->set('register_date', $data['register_date']);
		}

		if (isset($data['register_input_date'])) {
			$this->db->set('register_input_date', $data['register_input_date']);
		}

		if (isset($data['register_due_date'])) {
			$this->db->set('register_due_date', $data['register_due_date']);
		}

		if (isset($data['register_product_name'])) {
			$this->db->set('register_product_name', $data['register_product_name']);
		}

		if (isset($data['register_imei'])) {
			$this->db->set('register_imei', $data['register_imei']);
		}

		if (isset($data['register_serial'])) {
			$this->db->set('register_serial', $data['register_serial']);
		}

		if (isset($data['register_status'])) {
			$this->db->set('register_status', $data['register_status']);
		}

		if (isset($data['merchant_merchant_id'])) {
			$this->db->set('merchant_merchant_id', $data['merchant_merchant_id']);
		}

		if (isset($data['merchant_merchant_code'])) {
			$this->db->set('merchant_merchant_code', $data['merchant_merchant_code']);
		}

		if (isset($data['register_id'])) {
			$this->db->where('register_id', $data['register_id']);
			$this->db->update('registers');
			$id = $data['register_id'];
		} else {
			$this->db->insert('registers');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

	function update_due($data = array()) {

		if (isset($data['merchant_merchant_id'])) {
			$this->db->set('merchant_merchant_id', $data['merchant_merchant_id']);
		}

		if (isset($data['merchant_merchant_code'])) {
			$this->db->set('merchant_merchant_code', $data['merchant_merchant_code']);
		}

		if (isset($data['register_input_date'])) {
			$this->db->set('register_input_date', $data['register_input_date']);
		}

		if (isset($data['register_due_date'])) {
			$this->db->set('register_due_date', $data['register_due_date']);
		}

		$this->db->where('merchant_merchant_id', $data['merchant_merchant_id']);
		$this->db->update('registers');
		$merchant = $data['merchant_merchant_id'];

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $merchant;
	}

	function delete($id) {
		$this->db->where('register_id', $id);
		$this->db->delete('registers');
	}

}


/* End of file M_machine.php */
/* Location: ./application/models/M_machine.php */