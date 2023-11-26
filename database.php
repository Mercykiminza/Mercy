<?php
class Database {
	private $host;
	private $username;
	private $password;
	private $database;
	private $connection;

	public function __construct() {
		require_once 'configuration.php';

		$this->host = $config['db_host'];
		$this->username = $config['db_username'];
		$this->password = $config['db_password'];
		$this->database = $config['db_name'];

		$this->connect();
	}

	private function connect() {
		$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

		if ($this->connection->connect_error) {
			die("Connection failed: " . $this->connection->connect_error);
		}
	}

	public function insertData($query, $values) {
		if (count($values) > 0) {
			$statement = $this->connection->prepare($query);
			$statement->bind_param(str_repeat('s', count($values)), ...$values);
			$statement->execute();
			$statement->close();
		} else {
			$this->connection->query($query);
		}
	}

	public function queryData($query, $values) {
		if (count($values) > 0) {
			$statement = $this->connection->prepare($query);
			$statement->bind_param(str_repeat('s', count($values)), ...$values);
			$statement->execute();
			$result = $statement->get_result();
			$rows = $result->fetch_all(MYSQLI_ASSOC);
			$statement->close();
		} else {
			$result = $this->connection->query($query);
			$rows = $result->fetch_all(MYSQLI_ASSOC);
		}

		return $rows;
	}
	public function selectData($query, $values = []) {
        if (count($values) > 0) {
            $statement = $this->connection->prepare($query);
            $statement->bind_param(str_repeat('s', count($values)), ...$values);
            $statement->execute();
            $result = $statement->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $statement->close();
        } else {
            $result = $this->connection->query($query);
            $rows = $result->fetch_all(MYSQLI_ASSOC);
        }

        return $rows;
    }

	public function disconnect() {
		$this->connection->close();
	}
}
?>
