<?php 

namespace Cluster\Modules\QueryBuilder\Core;

class SQLconstructor {

	public static function constructSELECT($sql_table="", $sql_where="", $sql_order="",$sql_limit="", $sql_select=[]) {

		//construct select
		$sql_select = implode(", ", $sql_select);
		$sql_select = rtrim($sql_select, ",");
		$sql_select = ltrim($sql_select, ",");
		
		//cconstruct limit 
		$limit = "";
		if (!empty($sql_limit)) {
			$limit = " LIMIT {$sql_limit}";
		}

		//cconstruct order 
		$order = "";
		if (!empty($sql_order)) {
			$order = " ORDER BY {$sql_order}";
		}


		$sql_base = "SELECT {$sql_select} FROM {$sql_table} WHERE {$sql_where}{$order}{$limit};";

		return $sql_base;


	}

	public static function constructUPDATE($sql_table="", $sql_where="", $sql_update=[], $sql_order="",$sql_limit="") {

		//cconstruct limit 
		$limit = "";
		if (!empty($sql_limit)) {
			$limit = " LIMIT {$sql_limit}";
		}

		//cconstruct order 
		$order = "";
		if (!empty($sql_order)) {
			$order = " ORDER BY {$sql_order}";
		}

		//construct update
		$update = "";
		if (count($sql_update)) {
			$update = implode(", ", $sql_update);
			$update = "SET ". $update;
		}

		$sql_base = "UPDATE {$sql_table} {$update} WHERE {$sql_where}{$order}{$limit};";

		return $sql_base;
	}

	public static function constructINSERT($sql_table="",$sql_insert=[]) {

		$values_placeholder = "";
		$values_order       = "";

		$i = 1;
		foreach($sql_insert as $key => $value) {

			$values_placeholder .= ":{$key}";
			$values_order       .= "{$value}";
			
			if ($i != count($values)) {
				$values_order .= ", ";
				$values_placeholder .= ", ";
			}

			$i+=1;
		}

		$values_order = "({$values_order})";


		$sql_query = "INSERT INTO `{$sql_table}` {$values_order} VALUES ({$values_placeholder});";
		
		return $sql_query;


	}

	public static function constructDELETE($sql_table="", $sql_where="", $sql_order="",$sql_limit="") {

		//cconstruct limit 
		$limit = "";
		if (!empty($sql_limit)) {
			$limit = " LIMIT {$sql_limit}";
		}

		//cconstruct order 
		$order = "";
		if (!empty($sql_order)) {
			$order = " ORDER BY {$sql_order}";
		}


		$sql_base = "DELETE FROM {$sql_table} WHERE {$sql_where}{$order}{$limit};";

		return $sql_base;


	}


}