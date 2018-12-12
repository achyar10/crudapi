<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {

        if (isset($params['id'])) {
            $this->db->where('employees.employee_id', $params['id']);
        }
        if (isset($params['email'])) {
            $this->db->where('employee_email', $params['email']);
        }
        if (isset($params['password'])) {
            $this->db->where('employee_password', $params['password']);
        }
        if (isset($params['fullname'])) {
            $this->db->where('employee_full_name', $params['fullname']);
        }

        if (isset($params['status'])) {
            $this->db->where('employee_status', $params['status']);
        }

        if (isset($params['merchant_code'])) {
            $this->db->where('employees.merchant_merchant_code', $params['merchant_code']);
        }

        if (isset($params['merchant_id'])) {
            $this->db->where('employees.merchant_merchant_id', $params['merchant_id']);
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
            $this->db->order_by('employee_last_update', 'desc');
        }

        $this->db->select('*');

        $this->db->join('merchants', 'merchants.merchant_id = employees.merchant_merchant_id', 'left');
        $this->db->join('branches', 'branches.branch_id = employees.branch_branch_id', 'left');

        $res = $this->db->get('employees');

        if (isset($params['id'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }

    function add($data = array()) {

        if (isset($data['employee_id'])) {
            $this->db->set('employee_id', $data['employee_id']);
        }

        if (isset($data['employee_nip'])) {
            $this->db->set('employee_nip', $data['employee_nip']);
        }

        if (isset($data['employee_password'])) {
            $this->db->set('employee_password', $data['employee_password']);
        }

        if (isset($data['employee_full_name'])) {
            $this->db->set('employee_full_name', $data['employee_full_name']);
        }

        if (isset($data['employee_email'])) {
            $this->db->set('employee_email', $data['employee_email']);
        }

        if (isset($data['employee_pob'])) {
            $this->db->set('employee_pob', $data['employee_pob']);
        }

        if (isset($data['employee_dob'])) {
            $this->db->set('employee_dob', $data['employee_dob']);
        }

        if (isset($data['employee_tlp'])) {
            $this->db->set('employee_tlp', $data['employee_tlp']);
        }

        if (isset($data['employee_address'])) {
            $this->db->set('employee_address', $data['employee_address']);
        }

        if (isset($data['employee_country'])) {
            $this->db->set('employee_country', $data['employee_country']);
        }

        if (isset($data['employee_photo'])) {
            $this->db->set('employee_photo', $data['employee_photo']);
        }

        if (isset($data['employee_ktp'])) {
            $this->db->set('employee_ktp', $data['employee_ktp']);
        }

        if (isset($data['employee_npwp'])) {
            $this->db->set('employee_npwp', $data['employee_npwp']);
        }

        if (isset($data['employee_input_date'])) {
            $this->db->set('employee_input_date', $data['employee_input_date']);
        }

        if (isset($data['employee_last_login'])) {
            $this->db->set('employee_last_login', $data['employee_last_login']);
        }

        if (isset($data['employee_last_update'])) {
            $this->db->set('employee_last_update', $data['employee_last_update']);
        }

        if (isset($data['employee_status'])) {
            $this->db->set('employee_status', $data['employee_status']);
        }

        if (isset($data['employee_token'])) {
            $this->db->set('employee_token', $data['employee_token']);
        }

        if (isset($data['branch_branch_id'])) {
            $this->db->set('branch_branch_id', $data['branch_branch_id']);
        }

        if (isset($data['merchant_merchant_id'])) {
            $this->db->set('merchant_merchant_id', $data['merchant_merchant_id']);
        }

        if (isset($data['merchant_merchant_code'])) {
            $this->db->set('merchant_merchant_code', $data['merchant_merchant_code']);
        }

        if (isset($data['employee_id'])) {
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->update('employees');
            $id = $data['employee_id'];
        } else {
            $this->db->insert('employees');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function delete($id) {
        $this->db->where('employee_id', $id);
        $this->db->delete('employees');
    }

    function change_password($id, $params) {
        $this->db->where('employee_id', $id);
        $this->db->update('employees', $params);
    }

    // function employee_login($email, $password){
    //     $this->db->select('employee_id, employee_email, employee_full_name, employee_status, employee_image');
    //     $this->db->select('employee.merchant_merchant_id, merchant_name');
    //     $this->db->select('employee.branch_branch_id, branch_name, branch_address, branch_phone');
    //     $this->db->join('merchant', 'merchant.merchant_id = employee.merchant_merchant_id', 'left');
    //     $this->db->join('branch', 'branch.branch_id = employee.branch_branch_id', 'left');
    //     $this->db->where('employee_email',$email);
    //     $this->db->where('employee_password',$password);
    //     $res = $this->db->get('employee');
    //     return $res->row_array();
    // }

}
