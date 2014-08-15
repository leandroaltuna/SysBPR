<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Conversacion_model extends Base_model
	{
		function select_data_join( $table1, $table2, $join, $conditional, $sorted )
		{
			$this->db->from( $table1 );
			$this->db->join( $table2, $join );
			$this->db->where( $conditional );
			$this->db->order_by( $sorted );

			$query = $this->db->get();
			return $query;
		}
	}
?>