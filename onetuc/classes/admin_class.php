<?php

class Admin_Class
{	
/* -------------------------set_database_connection_using_PDO---------------------- */
	public function __construct()
	{ 
        $host_name='10.14.1.10';
		#$user_name='sa';
		#$password='T3s+DB';
		$db_name='OneTUC';
		$port = "1433";
		$connection = new PDO("sqlsrv:Server=$host_name,$port;Database=$db_name;ConnectionPooling=0");#, $user_name, $password);
		try{			
			$this->db = $connection; // connection established
		} catch (PDOException $message ) {
			echo $message->getMessage();
		}
	}
/* ---------------------- test_form_input_data ----------------------------------- */
	public function test_form_input_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
	return $data;
	}
		/* -------------------- onetuc Logout ----------------------------------- */
		public function onetuc_logout() {
        
			session_start();
			unset($_SESSION['admin_id']);
			unset($_SESSION['admin_name']);
			unset($_SESSION['user_role']);
			unset($_SESSION['company']);
			unset($_SESSION['employee']);
			unset($_SESSION['department']);
			header('Location: index.php');
		}

/* ---------------------- onetuc Login Check ----------------------------------- */
    public function onetuc_login_check($data) {     
	$onetucupass = $this->test_form_input_data(md5($data['admin_password']));
	$onetucusername = $this->test_form_input_data($data['username']);
	try{
	$stmt = $this->db->prepare("EXEC [dbo].[UserLogin_OnetucAccount_SP] @param_chrUsername = :uname, @param_chrPassword=:upass");
	  $stmt->execute(array(':uname'=>$onetucusername, ':upass'=>$onetucupass));
	  $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	  //var_dump($stmt->rowCount() < 0);
	  //var_dump($userRow);
	  if($stmt->rowCount() < 0)
	  {
			session_start();
			$_SESSION['admin_id'] = $userRow['user_id'];
	        $_SESSION['name'] = $userRow['full_name'];
	    	$_SESSION['user_role'] = $userRow['role_id'];
			$_SESSION['company'] = $userRow['company_id'];
			$_SESSION['department'] = $userRow['department_id'];
			$_SESSION['active'] = $userRow['is_active'];
			$_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
			$_SESSION['employee'] = $userRow['employee_id'];
	        $_SESSION['temp_password'] = $userRow['temporary_password'];

			  if($userRow['temporary_password'] == null){
				header('Location: main.php');
			  }else{
				header ('Location: hectech/changePasswordForEmployee.php');
			} 
		}
		
		else{
			$message = 'Invalid user name or Password';
			return $message;
		}
	 }
	 catch(PDOException $e)
	 {
		 echo $e->getMessage();
	 }	
	  
  }
	/* --------------------delete_data_by_this_method--------------*/
	public function delete_data_by_this_method($sql,$action_id,$sent_po){
		try{
			$delete_data = $this->db->prepare($sql);

			$delete_data->bindparam(':id', $action_id);

			$delete_data->execute();

			header('Location: '.$sent_po);
		}catch (PDOException $e) {
			echo $e->getMessage();
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