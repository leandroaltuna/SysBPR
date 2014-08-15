<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Asuntos_model extends Base_model
	{
	
		function sorted_data_selection( $table, $condition, $sorted )
		{
			$this->db->where( $condition );
			$this->db->order_by( $sorted );
			$query = $this->db->get( $table );
			return $query;
		}
	}
?>