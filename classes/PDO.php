<?php

// This class handles database connection and queries using PDO.
class PDOmysql {
	private $conn;
	// Try connecting to the database.
	function __construct($database = 'jukebox', $user = 'root', $password= ''){
		try {
			$this->conn = new PDO('mysql:host=localhost;dbname=' . $database, $user, $password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo 'Unable to connect to database';
			echo 'ERROR: ' . $e->getMessage();
			die();
		}
	}

	// Select single column from a table
	function select($table, $field, $where = ''){
		if ($where == ''){
			$sql = 'SELECT ' . $field . ' FROM ' . $table;
		} else {
			$sql = 'SELECT ' . $field . ' FROM ' . $table . ' WHERE ' . $where;
		}
		//echo $sql;
		$stmt = $this->conn->prepare($sql);
		if ($stmt){
			$stmt->execute();
			$rows = array();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				array_push($rows, $row);
			}
		}
		if (isset($rows)){
			return $rows;
		} else {
			return false;
		}
		$stmt = null;
	}

	// Select all columns function
	function select_all($table, $where = ''){
		if ($where == ''){
			$sql = 'SELECT * FROM ' . $table;
		} else {
			$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $where;
		}
		$stmt = $this->conn->prepare($sql);
		$exec = $stmt->execute();
		if ($exec){
			$rows = array();
			while ($row = $stmt->fetch()){
				array_push($rows, $row);
			}
		}
		if (isset($rows)){
			return $rows;
		} else {
			return false;
		}
		$stmt = null;
	}

	// Check if value already exists in database
	function select_value_exists($table, $value, $field){
		$sql = 'SELECT COUNT(*) FROM ' . $table . ' WHERE ' . $field . ' = :value';
		$stmt = $this->conn->prepare($sql);
		if($stmt){
			$stmt->execute(array(':value' => $value));
			$result = $stmt->fetch(PDO::FETCH_NUM);
			if($result[0] > 0){
				$stmt = null;
				return true;
			} else {
				return false;
			}
		}
	}

	// All-purpose insert function for multiple fields and values
	function insert($table, $fields, $values){
		$fieldsSQL = '';
		if (is_array($fields)){ // multiple fields
			foreach($fields as $key => $field){
				if ($key == 0){ // first item
					$fieldsSQL .= $field;
				} else { // follow every other field with comma
					$fieldsSQL .= ', ' . $field;
				}
			}
		} else { // only one field
			$fieldsSQL .= $fields;
		}

		$valuesSQL = '';
		if (is_array($values)){ // multiple values
			foreach($values as $key => $value){
				if ($key == 0){ // first item
					$valuesSQL .= '?';
				} else { // follow every other value with comma
					$valuesSQL .= ', ?';
				}
			}
		} else { // only one value
			$valuesSQL .= ':value';
		}

		$sql = 'INSERT INTO ' . $table . ' (' . $fieldsSQL . ') VALUES (' . $valuesSQL . ')';
		$stmt = $this->conn->prepare($sql);

		if ($stmt){
			if (is_array($values)){
				$stmt->execute($values);
			} else {
				$stmt->execute(array(':value' => $values));
			}
		}
		$stmt = null;
	}

	// All-purpose multiple field update function, thank you Dustin Cochrane
	function update($table, $fields, $values, $where){
		$buildSQL = '';
		if (is_array($fields)){ // multiple fields
			foreach($fields as $key => $field){
				if ($key == 0){ // first item
					$buildSQL .= $field.' = ?';
				} else { // follow every other field with a comma
					$buildSQL .= ', '.$field.' = ?';
				}
			}
		} else { // only one field
			$buildSQL .= $fields.' = :value';
		}

		$sql = 'UPDATE ' . $table . ' SET ' . $buildSQL . ' WHERE ' . $where;
		//echo $sql;
		$stmt = $this->conn->prepare($sql);

		if ($stmt){
			if (is_array($values)){ // execute for multiple values
				$stmt->execute($values);
			} else { // execute for single value
				//echo $values;
				$stmt->execute(array(':value' => $values));
			}
		}
		$stmt = null;
	}

	// Delete rows from a table that match the where clause
	function delete_rows($table, $where){
		$sql = 'DELETE FROM ' . $table . ' WHERE ' . $where;
		$stmt = $this->conn->prepare($sql);
		$exec = $stmt->execute();
		if ($exec){
			$count = $stmt->rowCount();
			return $count;
		} else {
			return false;
		}
		$stmt = null;
	}

	// Get the column names from a given table
	function get_column_names($table){
		$sql = 'SHOW COLUMNS FROM ' . $table;
		$stmt = $this->conn->prepare($sql);
		if($stmt){
			$stmt->execute();
			$columnNames = array();
			while ($row = $stmt->fetch()){
				array_push($columnNames, $row);
			}
			return $columnNames;
		} else {
			return false;
		}
		$stmt = null;
	}

}
