<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Conversacion_model extends Base_model
	{
		function select_data_join( $selected, $table1, $table2, $join, $conditional, $sorted )
		{
			$this->db->select( $selected );
			$this->db->from( $table1 );
			$this->db->join( $table2, $join );
			$this->db->where( $conditional );
			$this->db->order_by( $sorted );

			$query = $this->db->get();
			return $query;
		}

		function select_first_message( $selected, $table, $field, $conditional, $group )
		{
			$this->db->select( $selected );
			$this->db->from( $table );
			$this->db->where_in( $field, $conditional );
			$this->db->group_by( $group );

			$query = $this->db->get();
			return $query;
		}

	}
?>