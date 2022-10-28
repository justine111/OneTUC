<?php

class Admin_Class
{	
/* -------------------------set_database_connection_using_PDO---------------------- */
	public function __construct()
	{ 
        $host_name='10.14.1.10';
		#$user_name='sa';
		#$password='T3s+DB';
		$db_name='iSAP';
		$port = "1433";
		$connection = new PDO("sqlsrv:Server=$host_name,$port;Database=$db_name;ConnectionPooling=0");#, $user_name, $password);
		try{			
			$this->db = $connection; // connection established
		} catch (PDOException $message ) {
			echo $message->getMessage();
		}
	}

/* ----------------------manage_all_info--------------------- */
	public function manage_all_info($sql) {
		try{
			$info = $this->db->prepare($sql);
			$info->execute();
			return $info;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}
?>