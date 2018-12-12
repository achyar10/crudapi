<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rent_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	function get($params = array()) {

		if(isset($params['id'])) {
			$this->db->where('rents.rent_id', $params['id']);
		}

		if(isset($params['type'])) {
			$this->db->where('rent_type', $params['type']);
		}

		if(isset($params['date'])) {
			$this->db->where('rent_input_date', $params['date']);
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
			$this->db->order_by('rents.rent_input_date', 'desc');
		}

		$this->db->select('*');
		$res = $this->db->get('rents');

		if(isset($params['id'])) {
			return $res->row_array();
		} else {
			return $res->result_array();
		}

	}

	function add($data = array()) {

		if(isset($data['rent_id'])) {
			$this->db->set('rent_id', $data['rent_id']);
		}

		if(isset($data['rent_type'])) {
			$this->db->set('rent_type', $data['rent_type']);
		}

		if(isset($data['rent_price'])) {
			$this->db->set('rent_price', $data['rent_price']);
		}

		if(isset($data['rent_input_date'])) {
			$this->db->set('rent_input_date', $data['rent_input_date']);
		}

		if(isset($data['rent_last_update'])) {
			$this->db->set('rent_last_update', $data['rent_last_update']);
		}

		if(isset($data['rent_id'])) {
			$this->db->where('rent_id', $data['rent_id']);
			$this->db->update('rents');
			$id = $data['rent_id'];
		} else {
			$this->db->insert('rents');
			$id = $this->db->insert_id();
		}

		$status = $this->db->affected_rows();
		return ($status == 0) ? FALSE : $id;
	}

	function delete($id) {
		$this->db->where('rent_id', $id);
		$this->db->delete('rents');
	}

}

/* End of file M_rent.php */
/* Location: ./application/models/M_rent.php */