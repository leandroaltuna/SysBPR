<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Asuntos extends CI_Controller {

	private $master_table = 'Consulta';
	private $detail_table = 'Consulta_Detalle';
	private $conditional = '';

	private $group = array();
	private $user = array();
	private $parameters = array();


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
		$this->user = $this->ion_auth->user()->row();
	}

	function assign_header_variables( $cod_categoria, $main_content )
	{
		$this->group = $this->ion_auth->group($cod_categoria)->row();

		$this->parameters['title'] = 'Consultas de '.$this->group->name;
		$this->parameters['description'] = 'Temas de Conversacion';
		$this->parameters['main_content'] = $main_content;
	}

	function index($cod_categoria = null)
	{
		$cod_categoria = ($cod_categoria == null) ? 0 : $cod_categoria;

		$this->assign_header_variables( $cod_categoria, 'asuntos');

		$this->parameters['categoria'] = $this->group->id;
		
		$this->parameters['user'] = $this->user;
		$type = $this->user->type;

		if ( $type == 0 ) // usuario
		{
			$this->conditional = 'user_id = '.$this->user->id.' and group_id = '.$this->group->id;
		}
		else if ( $type == 1 ) // consultor
		{
			$this->conditional = 'group_id = '.$this->group->id;
		}

		$sorted = 'estado desc';

		$this->parameters['contenido'] = $this->asuntos_model->sorted_data_selection( $this->master_table, $this->conditional, $sorted )->result();
		$this->parameters['contenido_adicional'] = array();

		if ( $type == 0 )
		{
			$this->conditional = 'user_id <> '.$this->user->id.' and group_id = '.$this->group->id;
			$this->parameters['contenido_adicional'] = $this->asuntos_model->sorted_data_selection( $this->master_table, $this->conditional, $sorted )->result();
		}

		$this->load->view('frontend/template', $this->parameters);
	}

	function nuevo_asunto($cod_categoria = null)
	{
		$cod_categoria = ($cod_categoria == null) ? 0 : $cod_categoria;

		$this->assign_header_variables( $cod_categoria, 'nuevo_asunto' );
		
		$this->parameters['categoria'] = $this->group->id;
		$this->parameters['user'] = $this->user;

		$this->load->view('frontend/template', $this->parameters);
	}

	function create_chat()
	{
		$cod_categoria = $this->input->post('group_id');

		// $this->user = $this->ion_auth->user()->row();
		$this->group = $this->ion_auth->group($cod_categoria)->row();

		$this->conditional = 'group_id = '.$this->group->id;
		$number = $this->asuntos_model->count_result( $this->conditional, $this->master_table );

		$new_cod_consulta = $number + 1;

		$this->master_table_fields = $this->asuntos_model->get_fields( $this->master_table );
		$this->fields_array = array( 'user_id', 'cod_consulta', 'estado', 'initial' );

		$this->master_data['user_id'] = $this->user->id;
		$this->master_data['cod_consulta'] = $new_cod_consulta;
		$this->master_data['initial'] = $this->group->initial;
		$this->master_data['estado'] = 1;

		foreach ($this->master_table_fields as $key => $field_name)
		{
			if ( !in_array( $field_name, $this->fields_array ) )
			{
				$this->master_data[$field_name] = ($this->input->post($field_name) == '') ? null : $this->input->post($field_name);
			}
		}
		$this->result = $this->asuntos_model->insert_data( $this->master_data, $this->master_table );


		$this->detail_data['user_id'] = $this->user->id;
		$this->detail_data['cod_consulta'] = $new_cod_consulta;
		$this->detail_data['nro_detalle'] = 1;
		$this->detail_data['tipo'] = $this->user->type;// usuario 0 y consultor 1
		$this->detail_data['fecha'] = date('Y/m/d H:i:s');

		$this->detail_table_fields = $this->asuntos_model->get_fields( $this->detail_table );
		$this->fields_array = array( 'user_id', 'cod_consulta', 'nro_detalle', 'tipo', 'fecha' );

		foreach ($this->detail_table_fields as $key => $field_name)
		{
			if ( !in_array( $field_name, $this->fields_array ) )
			{
				$this->detail_data[$field_name] = ( $this->input->post($field_name) == '' ) ? null : $this->input->post($field_name);
			}
		}
		$this->result = $this->asuntos_model->insert_data( $this->detail_data, $this->detail_table );

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

		$fecha_cierre = date('Y/m/d');
		$update_data = array( 'estado' => 0, 'fecha_cierre' => $fecha_cierre );
		$this->conditional = array( 'group_id' => $cod_categoria, 'cod_consulta' => $cod_consulta );

		$this->result = $this->asuntos_model->update_data( $update_data, $this->master_table, $this->conditional );

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