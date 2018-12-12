<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_merchant_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('user_merchants.user_merchant_id', $params['id']);
        }
        if (isset($params['email'])) {
            $this->db->where('user_merchant_email', $params['email']);
        }
        if (isset($params['password'])) {
            $this->db->where('user_merchant_password', $params['password']);
        }
        if (isset($params['fullname'])) {
            $this->db->where('user_merchant_full_name', $params['fullname']);
        }

        if (isset($params['status'])) {
            $this->db->where('user_merchant_status', $params['status']);
        }

        if (isset($params['merchant_code'])) {
            $this->db->where('merchant_merchant_code', $params['merchant_code']);
        }

        if (isset($params['merchant_id'])) {
            $this->db->where('merchant_merchant_id', $params['merchant_id']);
        }

        if (isset($params['branch_id'])) {
            $this->db->where('branch_branch_id', $params['branch_id']);
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
            $this->db->order_by('user_merchant_last_update', 'desc');
        }

        $this->db->select('*');

        $this->db->join('merchants', 'merchants.merchant_id = user_merchants.merchant_merchant_id', 'left');

        $res = $this->db->get('user_merchants');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function add($data = array()) {

        if (isset($data['user_merchant_id'])) {
            $this->db->set('user_merchant_id', $data['user_merchant_id']);
        }

        if (isset($data['user_merchant_password'])) {
            $this->db->set('user_merchant_password', $data['user_merchant_password']);
        }

        if (isset($data['user_merchant_full_name'])) {
            $this->db->set('user_merchant_full_name', $data['user_merchant_full_name']);
        }

        if (isset($data['user_merchant_email'])) {
            $this->db->set('user_merchant_email', $data['user_merchant_email']);
        }

        if (isset($data['user_merchant_input_date'])) {
            $this->db->set('user_merchant_input_date', $data['user_merchant_input_date']);
        }

        if (isset($data['user_merchant_last_login'])) {
            $this->db->set('user_merchant_last_login', $data['user_merchant_last_login']);
        }

        if (isset($data['user_merchant_last_update'])) {
            $this->db->set('user_merchant_last_update', $data['user_merchant_last_update']);
        }

        if (isset($data['user_merchant_status'])) {
            $this->db->set('user_merchant_status', $data['user_merchant_status']);
        }

        if (isset($data['user_merchant_token'])) {
            $this->db->set('user_merchant_token', $data['user_merchant_token']);
        }

        if (isset($data['merchant_merchant_id'])) {
            $this->db->set('merchant_merchant_id', $data['merchant_merchant_id']);
        }

        if (isset($data['merchant_merchant_code'])) {
            $this->db->set('merchant_merchant_code', $data['merchant_merchant_code']);
        }

        if (isset($data['branch_branch_id'])) {
          $this->db->set('branch_branch_id', $data['branch_branch_id']);
        }

        if (isset($data['branch_set_null'])) {
          $this->db->set('branch_branch_id', NULL);
        }

        if (isset($data['user_merchant_id'])) {
            $this->db->where('user_merchant_id', $data['user_merchant_id']);
            $this->db->update('user_merchants');
            $id = $data['user_merchant_id'];
        } else {
            $this->db->insert('user_merchants');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('user_merchant_id', $id);
        $this->db->delete('user_merchants');
    }

    function change_password($id, $params) {
        $this->db->where('user_merchant_id', $id);
        $this->db->update('user_merchants', $params);
    }

    // function user_merchant_login($email, $password){
    //     $this->db->select('user_merchant_id, user_merchant_email, user_merchant_full_name, user_merchant_status, user_merchant_image');
    //     $this->db->select('user_merchant.merchant_merchant_id, merchant_name');
    //     $this->db->select('user_merchant.branch_branch_id, branch_name, branch_address, branch_phone');
    //     $this->db->join('merchant', 'merchant.merchant_id = user_merchant.merchant_merchant_id', 'left');
    //     $this->db->join('branch', 'branch.branch_id = user_merchant.branch_branch_id', 'left');
    //     $this->db->where('user_merchant_email',$email);
    //     $this->db->where('user_merchant_password',$password);
    //     $res = $this->db->get('user_merchant');
    //     return $res->row_array();
    // }

}
