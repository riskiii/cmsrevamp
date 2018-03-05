<?php


class Database {
	public $conn;

	private $my_home;
	private $my_ini;
	private $host;
	private $db_name;
	private $username;
	private $password;

	public function dbConnection() {

		$this->my_ini   = array ();
		$this->my_home  = getenv( "HOME" );
		$this->my_ini   = parse_ini_file( '/Users/riskiii/access_control.ini' );
		$this->host     = $this->my_ini[ 'host' ];
		$this->db_name  = $this->my_ini[ 'db_name' ];
		$this->username = $this->my_ini[ 'user_name' ];
		$this->password = $this->my_ini[ 'user_pass' ];

		$this->conn = null;
		try {
			$this->conn = new PDO( "mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password );
			$this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		} catch ( PDOException $exception ) {
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->conn;
	}
}
