<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Conversacion_model extends Base_model
	{
		function select_with_query( $content )
		{
			$query = $this->db->query( $content );
			return $query;
		}

	}
?>