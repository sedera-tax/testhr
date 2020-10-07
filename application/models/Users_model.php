<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
	function getUsernames()
	{
		$this->db->select('username');
		$records = $this->db->get('users');
		$users = $records->result_array();
		return $users;
	}

	function getUserDetails($postData=array())
	{
		$response = array();

		if (isset($postData['username']))
		{
			// Select record
			$this->db->select('*');
			$this->db->where('username', $postData['username']);
			$records = $this->db->get('users');
			$response = $records->result_array();
		}

		return $response;
	}
}
