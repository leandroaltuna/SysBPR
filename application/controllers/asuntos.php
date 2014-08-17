<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Asuntos extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->helper('url');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$this->load->model('asuntos_model');
	}

	function index($cod_categoria = null)
	{
		$cod_categoria = ($cod_categoria == null) ? 0 : $cod_categoria;
		$group = $this->ion_auth->group($cod_categoria)->row();

		$this->parameters['title'] = 'Consultas de '.$group->name;
		$this->parameters['description'] = 'Temas de Conversacion';
		$this->parameters['main_content'] = 'asuntos';
		$this->parameters['categoria'] = $cod_categoria;

		$user = $this->ion_auth->user()->row();
		$this->parameters['user'] = $user;
		$user_type = $user->type;

		if ( $user_type == 0) // usuario
		{
			$condicional = array( 'username' => $user->username, 'group_id' => $cod_categoria );
		}
		else if ( $user_type == 1 ) // consultor
		{
			$condicional = array( 'group_id' => $cod_categoria );
		}

		$sorted = 'estado desc';

		$this->parameters['contenido'] = $this->asuntos_model->sorted_data_selection( 'Consulta', $condicional, $sorted )->result();

		$this->load->view('frontend/template', $this->parameters);
	}

	function nuevo_asunto($cod_categoria = null)
	{
		$cod_categoria = ($cod_categoria == null) ? 0 : $cod_categoria;
		$group = $this->ion_auth->group($cod_categoria)->row();
		
		$this->parameters['title'] = 'Consultas de '.$group->name;
		$this->parameters['description'] = 'Tema de Conversacion';
		$this->parameters['main_content'] = 'nuevo_asunto';
		$this->parameters['categoria'] = $cod_categoria;
		$this->parameters['user'] = $this->ion_auth->user()->row();

		$this->load->view('frontend/template', $this->parameters);
	}

	function create_chat()
	{
		$cod_categoria = $this->input->post('group_id');
		$user = $this->ion_auth->user()->row();

		$this->condicional = array( 'group_id' => $cod_categoria);

		$number = $this->asuntos_model->count_result( $this->condicional, 'Consulta' );

		$cod_consulta = $number + 1;

		$this->table_consulta = $this->asuntos_model->get_fields('Consulta');

		$this->array_fields = array( 'username', 'cod_consulta', 'estado' );

		$this->data_master['username'] = $user->username;
		$this->data_master['cod_consulta'] = $cod_consulta;
		$this->data_master['estado'] = 1;

		foreach ($this->table_consulta as $key => $name_field)
		{
			if ( !in_array( $name_field, $this->array_fields ) )
			{
				$this->data_master[$name_field] = ($this->input->post($name_field) == '') ? null : $this->input->post($name_field);
			}
		}

		$this->result = $this->asuntos_model->insert_data( $this->data_master, 'Consulta' );


		$this->data_detail['username'] = $user->username;
		$this->data_detail['cod_consulta'] = $cod_consulta;
		$this->data_detail['nro_detalle'] = 1;
		$this->data_detail['tipo'] = $user->type;// usuario 0 y consultor 1
		// $this->data_detail['fecha'] = date('Y/m/d H:i:s');
		$this->data_detail['fecha'] = date('d/m/Y H:i:s');

		$this->table_consulta_detalle = $this->asuntos_model->get_fields('Consulta_Detalle');
		$this->array_fields = array( 'username', 'cod_consulta', 'nro_detalle', 'tipo', 'fecha' );

		foreach ($this->table_consulta_detalle as $key => $name_field)
		{
			if ( !in_array( $name_field, $this->array_fields ) )
			{
				$this->data_detail[$name_field] = ($this->input->post($name_field) == '') ? null : $this->input->post($name_field);
			}
		}


		$this->result = $this->asuntos_model->insert_data( $this->data_detail, 'Consulta_Detalle' );

		if ( $this->result > 0 ) 
		{
			$this->message = "Se envio tu mensaje!";
		}
		else
		{
			$this->message = "Se ha producido un error, recargue, verifique y vuelvalo a intentar.";
		}

		$this->parameters['msg'] = $this->message;

		$data['datos'] = $this->parameters;
		$this->load->view('frontend/json/json_view', $data);

	}

	function close_chat()
	{
		$cod_categoria = $this->input->post('group_id');
		$cod_consulta = $this->input->post('cod_consulta');
		// $fecha_cierre = date('Y/m/d');
		$fecha_cierre = date('d/m/Y');

		$data_update = array( 'estado' => 0, 'fecha_cierre' => $fecha_cierre );
		$condicional = array( 'group_id' => $cod_categoria, 'cod_consulta' => $cod_consulta );

		$this->result = $this->asuntos_model->update_data( $data_update, 'Consulta', $condicional );

		if ( $this->result > 0 ) 
		{
			$this->message = "Se cerro la Conversacion!";
		}
		else
		{
			$this->message = "Se ha producido un error, recargue, verifique y vuelvalo a intentar.";
		}

		$this->parameters['msg'] = $this->message;

		$data['datos'] = $this->parameters;
		$this->load->view('frontend/json/json_view', $data);

	}

}

?>