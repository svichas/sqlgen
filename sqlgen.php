<?php 

use Cluster\Core\Model\Model;
use Cluster\Modules\QueryBuilder\Core\SQLconstructor;

class sqlgen {

	protected $sql_table      = "";
	protected $sql_type       = "";
	protected $sql_where      = "";
	protected $sql_limit      = "";
	protected $sql_order      = "";
	protected $sql_select     = [];
	protected $sql_bindValues = [];
	protected $sql_insert     = [];
	protected $sql_update     = [];


	public function setTable($tableName = "") {
		$this->sql_table = $tableName;
		return $this;
	}


	public function where($where_sql="") {
		$this->sql_where = $where_sql;
		return $this;
	}

	public function bindValue($placeholder="", $value="") {

		$this->sql_bindValues[$placeholder] = $value;

		return $this;
	}

	public function select($select = "") {

		$this->sql_type = "SELECT";

		$this->sql_select[] = $select;

		return $this;

	}

	public function insert($values=[]) {
		$this->sql_type = "INSERT";
		$this->sql_insert = $values;
		return $this;
	}

	public function update($update ="") {
		$this->sql_type = "UPDATE";
		$this->sql_update[] = $update;
		return $this;
	}

	public function order($order="") {
		$this->sql_order = $order;
		return $this;
	}
	
	public function limit($limit="") {
		$this->sql_limit = $limit;
		return $this;
	}

	public function delete() {
		$this->sql_type = "DELETE";
		return $this;
	}

	/*
	public function execute() {

		$sql = $this->constructSQL();

		if ($this->sql_type == "INSERT") return true;

		$query = $this->prepare($sql);
		if ($query->execute($this->bindValue)) {
			if ($query->rowCount()) {
				return $query->fetchAll();
			} else {
				return false;
			}
		} else {
			return false;
		}

		//reset variables
		$this->resetVars();

	}
	*/

	public function get() {
		$sql = $this->constructSQL();
		return $sql;
	}

	public function getBindValues() {
		return $this->sql_bindValues;
	}


	protected function constructSQL() {

		$sql = "";

		switch (strtoupper($this->sql_type)) {
			case 'SELECT':

				$sql = SQLconstructor::constructSELECT($this->sql_table, $this->sql_where, $this->sql_order, $this->sql_limit, $this->sql_select);

				break;

			case 'INSERT':

				$sql = SQLconstructor::constructINSERT($this->sql_table, $this->sql_insert);

				break;

			case 'DELETE':

				$sql = SQLconstructor::constructDELETE($this->sql_table, $this->sql_where, $this->sql_order, $this->sql_limit);

				break;
			case 'UPDATE':
				$sql = SQLconstructor::constructUPDATE($this->sql_table, $this->sql_where, $this->sql_update, $this->sql_order, $this->sql_limit);

				break;
		}


		return $sql;
	}

	protected function resetVars() {
		$this->sql_table      = "";
		$this->sql_type       = "";
		$this->sql_where      = "";
		$this->sql_limit      = "";
		$this->sql_order      = "";
		$this->sql_select     = [];
		$this->sql_bindValues = [];
		$this->sql_insert     = [];
		$this->sql_update     = [];
	}



}