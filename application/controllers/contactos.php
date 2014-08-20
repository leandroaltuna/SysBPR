<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$this->load->model('contactos_model');

		$this->master_table = 'Consulta';
	}

	function index()
	{
		$this->parameters['title'] = 'Escritorio';
		$this->parameters['description'] = 'Panel de Control';
		$this->parameters['main_content'] = 'contactos';

		$this->user = $this->ion_auth->user()->row();
		$this->parameters['user'] = $this->user;

		$this->user_groups = $this->ion_auth->get_users_groups($this->user->id)->result();
		$this->number_issues = array();

		foreach ($this->user_groups as $row) 
		{
			$this->conditional = array('group_id' => $row->id);
			$number = $this->contactos_model->count_result( $this->conditional, $this->master_table );
			array_push( $this->number_issues, array('number' => $number) );
		}

		$this->parameters['contactos'] = $this->user_groups;
		$this->parameters['issues'] = $this->number_issues;

		$this->load->view('frontend/template', $this->parameters);
	}

}

?>