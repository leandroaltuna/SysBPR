<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Conversacion extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$this->load->model('conversacion_model');

		$this->master_table = 'Consulta';
		$this->detail_table = 'Consulta_Detalle';
	}

	function assign_header_variables( $cod_categoria, $main_content )
	{
		$this->group = $this->ion_auth->group($cod_categoria)->row();
		$this->user = $this->ion_auth->user()->row();

		$this->parameters['title'] = 'Conversacion';
		$this->parameters['description'] = 'Historial de la consulta';
		$this->parameters['main_content'] = $main_content;
	}

	function index($cod_categoria = null, $cod_consulta = null)
	{
		$cod_categoria = ($cod_categoria == null) ? 0 : $cod_categoria;
		$cod_consulta = ($cod_consulta == null) ? 0 : $cod_consulta;

		$this->assign_header_variables( $cod_categoria, 'conversacion');
		
		$this->parameters['categoria'] = $this->group->id;
		$this->parameters['consulta'] = $cod_consulta;
		$this->parameters['user'] = $this->user;

		$this->conditional = array( 'group_id' => $this->group->id, 'cod_consulta' => $cod_consulta );
		$this->parameters['cabecera'] = $this->conversacion_model->select_data( $this->master_table, $this->conditional )->row();

		$this->load->view('frontend/template', $this->parameters);
	}

	function view_chat()
	{
		$cod_categoria = $this->input->post('group_id');
		$cod_consulta = $this->input->post('cod_consulta');

		$this->selected = "Consulta_Detalle.username, Consulta_Detalle.cod_consulta, Consulta_Detalle.nro_detalle, Consulta_Detalle.group_id,Consulta_Detalle.mensaje, Consulta_Detalle.tipo, ( RTRIM(CONVERT(char, Consulta_Detalle.fecha,103)) + ' ' + RTRIM(CONVERT(char, Consulta_Detalle.fecha,108))) as fecha, users.type, users.first_name, users.last_name, users.image, ISNULL((SELECT (users.first_name + ' ' + users.last_name) as name_consultor FROM users WHERE users.username = Consulta_Detalle.username_consultor ), '') as name_consultor, ISNULL((SELECT users.image FROM users WHERE users.username = Consulta_Detalle.username_consultor ), '') as image_consultor";
		$this->conditional = 'group_id = '.$cod_categoria.' and cod_consulta = '.$cod_consulta;
		$this->join = 'Consulta_Detalle.username = users.username';
		$this->sorted = 'nro_detalle asc';

		$this->query = "SELECT ".$this->selected." FROM Consulta_Detalle JOIN users ON ".$this->join." WHERE ".$this->conditional." ORDER BY ".$this->sorted;
	
		$this->parameters['contenido'] = $this->conversacion_model->select_with_query( $this->query )->result();

		$data['datos'] = $this->parameters;
		$this->load->view('frontend/json/json_view', $data);
	}

	function mensajes()
	{
		$this->user = $this->ion_auth->user()->row();

		$cod_consulta = $this->input->post('cod_consulta');
		$cod_categoria = $this->input->post('group_id');

		$this->conditional = array( 'group_id' => $cod_categoria, 'cod_consulta' => $cod_consulta );

		$this->result = $this->conversacion_model->select_data( $this->master_table, $this->conditional )->row();
		$username_consulta = $this->result->username;

		$number = $this->conversacion_model->count_result( $this->conditional, $this->detail_table );
		$nro_detalle = $number + 1;

		$this->detail_table_fields = $this->conversacion_model->get_fields( $this->detail_table );
		$this->fields_array = array( 'username', 'nro_detalle', 'tipo', 'username_consultor', 'fecha' );

		$this->detail_data['username'] = $username_consulta;
		$this->detail_data['nro_detalle'] = $nro_detalle;
		$this->detail_data['tipo'] = $this->user->type;
		$this->detail_data['username_consultor'] = ( $this->user->type == 1 ) ? $this->user->username : null;
		$this->detail_data['fecha'] = date('Y/m/d H:i:s');

		foreach ($this->detail_table_fields as $key => $field_name)
		{
			if ( !in_array( $field_name, $this->fields_array ) )
			{
				$this->detail_data[$field_name] = ($this->input->post($field_name) == '') ? null : $this->input->post($field_name);
			}
		}
		$this->result = $this->conversacion_model->insert_data( $this->detail_data, $this->detail_table );


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

	function new_message()
	{
		$this->find_issues = array();
		$this->group_in = array();

		$this->user = $this->ion_auth->user()->row();
		$this->user_groups = $this->ion_auth->get_users_groups($this->user->id)->result();

		// obtengo los grupos a los que pertenece el usuario
		foreach ($this->user_groups as $row)
		{
			array_push( $this->group_in, $row->id );
		}
		// end //

		// consulto si existe algun tema nuevo de conversacion, este caso solo es para los consultores.
		if ( $this->user->type == 1 )
		{
			$this->selected = 'username, cod_consulta, group_id, MAX(nro_detalle) as nro_detalle';
			$this->conditional_field = 'group_id';
			$this->group = array('group_id', 'cod_consulta', 'username');

			$this->query = "SELECT ".$this->selected." FROM Consulta_Detalle WHERE ".$this->conditional_field." IN (".implode(',', $this->group_in).") GROUP BY ".implode(',', $this->group);

			$this->first_messages = $this->conversacion_model->select_with_query( $this->query )->result();
	
			foreach ($this->first_messages as $row)
			{
				if ( $row->nro_detalle == 1 )
				{
					// adjunto la clave primaria de los nuevos mensajes
					array_push( $this->find_issues, array( 'username' => $row->username, 'cod_consulta' => $row->cod_consulta, 'group_id' => $row->group_id ) );
				}
			}
		}
		// end //

		// consulto si existe repuestas a alguna conversacion //
		$this->selected = 'username, cod_consulta, group_id, MAX(nro_detalle) as nro_detalle ';
		if ( $this->user->type == 0 )
		{
			// si es un usuario la condicional es por username //
			$this->conditional = 'username = '.$this->user->username.' and tipo = '.$this->user->type;
		}
		elseif ( $this->user->type == 1 )
		{
			// si es un consultor la condicional es por usernam_consultor //
			$this->conditional = 'username_consultor = '.$this->user->username.' and tipo = '.$this->user->type;
		}
		elseif ( $this->user->type == 2 )
		{
			// si es un administrador la condicional es por usernam_consultor //
			$this->conditional = 'username_consultor = '.$this->user->username.' and tipo = '.$this->user->type;
		}
		$this->group = array('group_id', 'cod_consulta', 'username');

		// obtengo los ultimos nro_detalle de mi usuario //
		$this->query = "SELECT ".$this->selected." FROM Consulta_Detalle WHERE ".$this->conditional." GROUP BY ".implode(',', $this->group);
		$this->detail_number_max = $this->conversacion_model->select_with_query( $this->query )->result();

		foreach ($this->detail_number_max as $row)
		{
			// obtengo la clave primaria de las conversciones mayores a mis ultimos nro_detalle //
			$this->selected = 'CD.username, CD.cod_consulta, CD.group_id';
			$this->conditional = "CD.username = '".$row->username."' and CD.cod_consulta = ".$row->cod_consulta." and CD.group_id = ".$row->group_id." and CD.nro_detalle > ".$row->nro_detalle." and C.estado = 1";
			$this->group = array('CD.group_id', 'CD.cod_consulta', 'CD.username');

			$this->query = "SELECT ".$this->selected." FROM Consulta_Detalle CD JOIN Consulta C ON CD.username = C.username and CD.cod_consulta = C.cod_consulta and CD.group_id = C.group_id WHERE ".$this->conditional."  GROUP BY ".implode(',', $this->group);
			
			$this->result = $this->conversacion_model->select_with_query( $this->query )->row();

			if ( count($this->result) > 0 )
			{
				// adjuntos la clave primaria de los ultimos mensajes //
				array_push( $this->find_issues, array( 'username' => $this->result->username, 'cod_consulta' => $this->result->cod_consulta, 'group_id' => $this->result->group_id ) );
			}
		}
		// end //


		$content = array();
		$number_alert = 0;
		// valido que existan nuevos o ultimos mensajes //
		if ( count($this->find_issues) > 0 )
		{
			for ($i=0; $i < count($this->find_issues); $i++)
			{
				// obtengo el asunto y el grupo de los ultimos mensajes //
				$this->conditional = "username = '".$this->find_issues[$i]['username']."' and cod_consulta = ".$this->find_issues[$i]['cod_consulta']." and group_id = ".$this->find_issues[$i]['group_id'];
				$this->selected = 'Consulta.*, groups.name';
				$this->join = 'Consulta.group_id = groups.id';
				$this->sorted = 'groups.id asc';
				
				$this->query = "SELECT ".$this->selected." FROM Consulta JOIN groups ON ".$this->join." WHERE ".$this->conditional." ORDER BY ".$this->sorted;
				$this->result = $this->conversacion_model->select_with_query( $this->query )->row();

				array_push($content, $this->result );
				$number_alert++;
			}
		}
		// end //

		$this->parameters['contenido'] = $content;
		$this->parameters['alert'] = $number_alert;
		// $this->parameters['image'] = $this->user->image;
		$data['datos'] = $this->parameters;
		$this->load->view('frontend/json/json_view', $data);

	}

}

?>