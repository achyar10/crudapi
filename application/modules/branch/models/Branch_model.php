<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	function get($params = array()) {

    if (isset($params['id'])) {
      $this->db->where('branches.branch_id', $params['id']);
    }

    if (isset($params['merchant_id'])) {
      $this->db->where('branches.merchant_merchant_id', $params['merchant_id']);
    }

    if (isset($params['merchant_code'])) {
      $this->db->where('branches.merchant_merchant_code', $params['merchant_code']);
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
      $this->db->order_by('branch_last_update', 'desc');
    }

    $this->db->select('*');
    $this->db->join('merchants', 'merchants.merchant_id = branches.merchant_merchant_id', 'left');

    $res = $this->db->get('branches');

    if (isset($params['id'])) {
      return $res->row_array();
    } else {
      return $res->result_array();
    }
  }

  function add($data = array()) {

    if (isset($data['branch_id'])) {
      $this->db->set('branch_id', $data['branch_id']);
    }

    if (isset($data['branch_null'])) {
      $this->db->set('branch_name', $data['branch_name']);
    }

    if (isset($data['branch_name'])) {
      $this->db->set('branch_name', $data['branch_name']);
    }

    if (isset($data['branch_tlp'])) {
      $this->db->set('branch_tlp', $data['branch_tlp']);
    }

    if (isset($data['branch_address'])) {
      $this->db->set('branch_address', $data['branch_address']);
    }

    if (isset($data['merchant_merchant_id'])) {
      $this->db->set('merchant_merchant_id', $data['merchant_merchant_id']);
    }

    if (isset($data['merchant_merchant_code'])) {
      $this->db->set('merchant_merchant_code', $data['merchant_merchant_code']);
    }

    if (isset($data['branch_input_date'])) {
      $this->db->set('branch_input_date', $data['branch_input_date']);
    }

    if (isset($data['branch_last_update'])) {
      $this->db->set('branch_last_update', $data['branch_last_update']);
    }

    if (isset($data['branch_id'])) {
      $this->db->where('branch_id', $data['branch_id']);
      $this->db->update('branches');
      $id = $data['branch_id'];
    } else {
      $this->db->insert('branches');
      $id = $this->db->insert_id();
    }

    $status = $this->db->affected_rows();
    return ($status == 0) ? FALSE : $id;
  }

  function delete($id) {
    $this->db->where('branch_id', $id);
    $this->db->delete('branches');
  }

}

/* End of file branch_model.php */
/* Location: ./application/modules/branch/models/branch_model.php */