<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

class Employees extends REST_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->database();
		// Load model
		$this->load->model('Employees_model');
	}

	/**
	 * @param null $id
	 */
	public function index_get($id = null) {
		// TODO implement method
		if ($id != NULL) {
			$data = $this->db->get_where(
				'employees',
				['id' => $id]
			)->row_array();

			if ($data === NULL) {
				return $this->response([
					'status' => FALSE,
					'message' => 'No such employees with id = ' . $id . ' found'
				], REST_Controller::HTTP_NOT_FOUND);
			}
		} else {
			$data = $this->db->get('employees')->result();
		}

		return $this->response($data, REST_Controller::HTTP_OK);
	}

	public function index_post() {
		// TODO implement method
		$this->load->library('form_validation');
		$this->form_validation->set_rules("first_name", "First Name", "required");
		$this->form_validation->set_rules("last_name", "Last Name", "required");
		$this->form_validation->set_rules("position_name", "Position Name", "required");
		$this->form_validation->set_rules("email", "Email", "valid_email");
		$this->form_validation->set_rules("telephone_number", "Telephone", "numeric");
		if ($this->form_validation->run()) {
			$input = $this->db->escape($this->input->post());
			$this->db->insert('employees', $input);

			return $this->response(["message" => "OK", "rows_inserted" => 1], REST_Controller::HTTP_OK);
		} else {
			$res = [
				'error'    => TRUE,
				'first_name_error' => form_error('first_name'),
				'last_name_error' => form_error('last_name'),
				'position_name_error' => form_error('position_name'),
				'email_error' => form_error('email'),
				'telephone_number_error' => form_error('telephone_number')
			];

			return $this->response($res, REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	/**
	 * @param null $id
	 */
	public function delete_get($id = null) {
		// TODO implement method
		if ($id != NULL) {
			$data = $this->db->get_where(
				'employees',
				['id' => $id]
			)->row_array();

			if ($data === NULL)
			{
				return $this->response([
					'status' => false,
					'message' => 'No such employees with id = ' . $id . ' found'
				], REST_Controller::HTTP_NOT_FOUND);
			}
			else
			{
				try
				{
					$data = $this->db->delete(
						'employees',
						['id' => $id]
					);
				}
				catch (Exception $e)
				{
					return $this->response([
						'status' => FALSE,
						'message' => $e->getMessage()
					], REST_Controller::HTTP_BAD_REQUEST);
				}

				$data = [
					'status' => TRUE,
					'message' => 'delete success'
				];
			}
		} else {
			return $this->response([
				'status' => FALSE,
				'message' => 'id must be send'
			], REST_Controller::HTTP_BAD_REQUEST);
		}

		return $this->response($data, REST_Controller::HTTP_OK);
	}
}
