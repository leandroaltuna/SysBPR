<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Conversacion extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->load->model('conversacion_model');
	}

	function index($cod_categoria = null, $cod_consulta = null)
	{
		$cod_categoria = ($cod_categoria == null) ? 0 : $cod_categoria;
		$cod_consulta = ($cod_consulta == null) ? 0 : $cod_consulta;
		
		$this->parameters['title'] = 'Conversacion';
		$this->parameters['description'] = 'Historial de la consulta';
		$this->parameters['main_content'] = 'conversacion';
		$this->parameters['categoria'] = $cod_categoria;
		$this->parameters['consulta'] = $cod_consulta;
		$this->parameters['user'] = $this->ion_auth->user()->row();

		$condicional = array( 'group_id' => $cod_categoria, 'cod_consulta' => $cod_consulta );
		$this->parameters['cabecera'] = $this->conversacion_model->select_data('Consulta', $condicional)->row();

		$join = 'Consulta_Detalle.username = users.username';
		$sorted = 'nro_detalle asc';
		$this->parameters['contenido'] = $this->conversacion_model->select_data_join( 'Consulta_Detalle', 'users', $join, $condicional, $sorted )->result();

		$this->load->view('frontend/template', $this->parameters);
	}

	function mensajes()
	{
		$user = $this->ion_auth->user()->row();

		$cod_consulta = $this->input->post('cod_consulta');
		$cod_categoria = $this->input->post('group_id');

		$this->condicional = array( 'group_id' => $cod_categoria, 'cod_consulta' => $cod_consulta );

		$number = $this->conversacion_model->count_result( $this->condicional, 'Consulta_Detalle' );

		$nro_detalle = $number + 1;

		$this->table_consulta_detalle = $this->conversacion_model->get_fields('Consulta_Detalle');

		$this->array_fields = array( 'username', 'nro_detalle', 'tipo', 'fecha' );

		$this->data_detail['username'] = $user->username;
		$this->data_detail['nro_detalle'] = $nro_detalle;
		$this->data_detail['tipo'] = $user->type;
		$this->data_detail['fecha'] = date('d/m/Y H:i:s');

		foreach ($this->table_consulta_detalle as $key => $name_field)
		{
			if ( !in_array( $name_field, $this->array_fields ) )
			{
				$this->data_detail[$name_field] = ($this->input->post($name_field) == '') ? null : $this->input->post($name_field);
			}
		}

		$this->result = $this->conversacion_model->insert_data( $this->data_detail, 'Consulta_Detalle' );


		if ( $this->result > 0 ) 
		{
			$this->message = "Se envio tu mensaje!";
			$this->estado = 1;
		}
		else
		{
			$this->message = "Se ha producido un error, recargue, verifique y vuelvalo a intentar.";
			$this->estado = 0;
		}

		$this->parameters['msg'] = $this->message;
		$this->parameters['estado'] = $this->estado;

		$data['datos'] = $this->parameters;
		$this->load->view('frontend/json/json_view', $data);
	}

}

?>