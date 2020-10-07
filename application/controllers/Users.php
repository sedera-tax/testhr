<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load Model
		$this->load->model('Users_model');

		// Load base_url
		$this->load->helper('url');
	}

	public function index()
	{
		$users = $this->Users_model->getUsernames();

		$data['users'] = $users;

		$this->load->view('users/view',$data);
	}

	public function userDetails()
	{
		// POST data
		$postData = $this->input->post();

		// get data
		$data = $this->Users_model->getUserDetails($postData);

		echo json_encode($data);
	}
}
