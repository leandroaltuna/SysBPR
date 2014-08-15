<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// $this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$this->load->model('contactos_model');
	}

	function index()
	{
		$this->parameters['title'] = 'Escritorio';
		$this->parameters['description'] = 'Panel de Control';
		$this->parameters['main_content'] = 'contactos';

		$user = $this->ion_auth->user()->row();
		$this->parameters['user'] = $user;

		$data = $this->ion_auth->get_users_groups($user->id)->result();
		$number_issues = array();

		foreach ($data as $fila) 
		{
			$condition = array('group_id' => $fila->id);
			$number = $this->contactos_model->count_result( $condition, 'Consulta' );
			array_push( $number_issues, array('number' => $number) );
		}

		$this->parameters['contactos'] = $data;
		$this->parameters['issues'] = $number_issues;

		$this->load->view('frontend/template', $this->parameters);
	}

}

?>