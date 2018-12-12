<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	function get($params = array()) {

		if(isset($params['id'])) {
			$this->db->where('banks.bank_id', $params['id']);
		}

		if(isset($params['date'])) {
			$this->db->where('bank_input_date', $params['date']);
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
			$this->db->order_by('banks.bank_input_date', 'desc');
		}

		$this->db->select('*');
		$res = $this->db->get('banks');

		if(isset($params['id'])) {
			return $res->row_array();
		} else {
			return $res->result_array();
		}

	}

	function add($data = array()) {

		if(isset($data['bank_id'])) {
			$this->db->set('bank_id', $data['bank_id']);
		}

		if(isset($data['bank_vendor'])) {
			$this->db->set('bank_vendor', $data['bank_vendor']);
		}

		if(isset($data['bank_account'])) {
			$this->db->set('bank_account', $data['bank_account']);
		}

		if(isset($data['bank_name'])) {
			$this->db->set('bank_name', $data['bank_name']);
		}

		if(isset($data['bank_input_date'])) {
			$this->db->set('bank_input_date', $data['bank_input_date']);
		}

		if(isset($data['bank_last_update'])) {
			$this->db->set('bank_last_update', $data['bank_last_update']);
		}

		if(isset($data['bank_id'])) {
			$this->db->where('bank_id', $data['bank_id']);
			$this->db->update('banks');
			$id = $data['bank_id'];
		} else {
			$this->db->insert('banks');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

	function delete($id) {
		$this->db->where('bank_id', $id);
		$this->db->delete('banks');
	}

}

/* End of file M_bank.php */
/* Location: ./application/models/M_bank.php */