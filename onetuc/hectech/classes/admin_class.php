<?php

class Admin_Class
{	
/* -------------------------set_database_connection_using_PDO---------------------- */
	public function __construct()
	{ 
        $host_name='10.14.1.10';
		#$user_name='sa';
		#$password='T3s+DB';
		$db_name='atYourService';
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
	/* -------------------- Admin Logout ----------------------------------- */
    public function admin_logout() {
        
        session_start();
        header('Location: ../index.php');

    }
/* ---------------------- Admin Login Check ----------------------------------- */
    public function admin_login_check($data) {     
        $upass = $this->test_form_input_data(md5($data['admin_password']));
		$username = $this->test_form_input_data($data['username']);
        try{
		$stmt = $this->db->prepare("EXEC [dbo].[UserLogin_Account_SP] @param_chrUsername = :uname, @param_chrPassword=:upass");
          $stmt->execute(array(':uname'=>$username, ':upass'=>$upass));
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
				$_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
				$_SESSION['employee'] = $userRow['employee_id'];
	            $_SESSION['temp_password'] = $userRow['temporary_password'];

          		if($userRow['temporary_password'] == null){
	                header('Location: task-info.php');
          		}else{
					header('Location: changePasswordForEmployee.php');
        		} 
			}else{
				$message = 'Invalid user name or Password';
				return $message;
			}
		 }
		 catch(PDOException $e)
		 {
			 echo $e->getMessage();
		 }	
		  
	  }
/* ---------------------- Change temp_pass to password ----------------------------------- */
    public function change_password_for_employee($data){
    	$password  = $this->test_form_input_data($data['password']);
		$re_password = $this->test_form_input_data($data['re_password']);
		$user_id = $this->test_form_input_data($data['user_id']);
		$final_password = md5($password);
		$temp_password = '';

		if($password == $re_password){
			try{
				$update_user = $this->db->prepare("EXEC [dbo].[UserChangePassword_Account_SP] @param_chrPassword = :x, @param_chrTempPassword=:y, 
				@param_intUserid = :id ");
				$update_user->bindparam(':x', $final_password);
				$update_user->bindparam(':y', $temp_password);
				$update_user->bindparam(':id', $user_id);
				$update_user->execute();

				session_start();
				unset($_SESSION['admin_id']);
				unset($_SESSION['admin_name']);
				unset($_SESSION['user_role']);
				unset($_SESSION['company']);
				unset($_SESSION['employee']);
				unset($_SESSION['department']);
				header('Location: ../index.php');

			}catch (PDOException $e) {
				echo $e->getMessage();
			}

		}else{
			$message = 'Sorry !! Password Can not match';
            return $message;
		}	
    }
/*----------- add_new_admin--------------*/
public function add_new_admin($data){
	    $user_fullname  = $this->test_form_input_data($data['ad_fullname']);
		$user_username = $this->test_form_input_data($data['ad_username']);
		$contact = $this->test_form_input_data($data['ad_contact']);
		$address = $this->test_form_input_data($data['ad_add']);
		$gender = $this->test_form_input_data($data['ad_gender']);
		$account = $this->test_form_input_data($data['ad_account']);
		$comp = $this->test_form_input_data($data['ad_company']);
		$employe_id = $this->test_form_input_data($data['ad_employeeID']);
		$temp_password = rand(000000001,10000000);
		$user_password = $this->test_form_input_data(md5($temp_password));
		$user_role = $this->test_form_input_data($data['account_role']);
		$dept = $this->test_form_input_data($data['ad_department']);
		
		   try{
			
			$sql = "SELECT username FROM [dbo].[user_masterinfos] WHERE username = '$user_username' ";
			$query_result = $this->manage_all_info($sql);
			$total_row = $query_result->rowCount();
			$all_error = '';
			if($total_row != 0){
				$all_error = "Username Already Exist!";
			}

			if(empty($all_error)){
				$add_user = $this->db->prepare("EXEC [dbo].[AddAdmin_Account_SP] @param_chrUsername = :a, @param_chrPassword = :b, @param_chrTempPassword = :c, 
				@param_chrFullname = :d, @param_intEmployee = :e, @param_chrDomainAccount = :f, @param_bitGender = :g,
				@param_chrContact = :h, @param_chrAddress = :i, @param_intRoleid = :j, @param_intCompanyid = :k, @param_intDepartment = :l");

				$add_user->bindparam(':a', $user_username);
				$add_user->bindparam(':b', $user_password);
				$add_user->bindparam(':c', $temp_password);
				$add_user->bindparam(':d', $user_fullname);
				$add_user->bindparam(':e', $employe_id);
				$add_user->bindparam(':f', $account);
				$add_user->bindparam(':g', $gender);
				$add_user->bindparam(':h', $contact);
				$add_user->bindparam(':i', $address);
				$add_user->bindparam(':j', $user_role);
				$add_user->bindparam(':k', $comp);
				$add_user->bindparam(':l', $dept);
				$add_user->execute();
			
			}else{
				return $all_error;
			}
			
		  }catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
/* ------------update_admin_data-------------------- */

public function update_admin_data($data, $id){
	$user_fullname  = $this->test_form_input_data($data['ad_fullname']);
	$user_username = $this->test_form_input_data($data['ad_user']);
	$user_gender = $this->test_form_input_data($data['ad_gender']);
	$contact = $this->test_form_input_data($data['ad_contact']);
	$address = $this->test_form_input_data($data['ad_add']);
	$department = $this->test_form_input_data($data['ad_department']);
	$company = $this->test_form_input_data($data['ad_company']);
	$employeid = $this->test_form_input_data($data['ad_employeid']);

	try{
		$update_user = $this->db->prepare("EXEC [dbo].[UpdateAdmin_Account_SP] @param_chrFullname = :a, @param_chrUsername = :b, @param_bitGender = :c, 
		@param_chrContact = :d, @param_chrAddress = :e, @param_intEmployee = :g, @param_intDepartment = :h, @param_intCompanyid = :i,
		@param_intUserid = :id ");

		$update_user->bindparam(':a', $user_fullname);
		$update_user->bindparam(':b', $user_username);
		$update_user->bindparam(':c', $user_gender);
		$update_user->bindparam(':d', $contact);
		$update_user->bindparam(':e', $address);
		$update_user->bindparam(':g', $employeid);
		$update_user->bindparam(':h', $department);
		$update_user->bindparam(':i', $company);
		$update_user->bindparam(':id', $id);
		$update_user->execute();

		//header('Location: manage-admin.php');
	}catch (PDOException $e) {
		echo $e->getMessage();
	}
}
/* -------------admin/user_password_change------------*/
	public function admin_password_change($data, $id){
		$admin_old_password  = $this->test_form_input_data(md5($data['admin_old_password']));
		$admin_new_password  = $this->test_form_input_data(md5($data['admin_new_password']));
		$admin_cnew_password  = $this->test_form_input_data(md5($data['admin_cnew_password']));
		$admin_raw_password = $this->test_form_input_data($data['admin_new_password']);
		try{
			$sql = "SELECT * FROM [dbo].[user_masterinfos] WHERE user_id = '$id' AND password = '$admin_old_password' ";
			$query_result = $this->manage_all_info($sql);
			$total_row = $query_result->rowCount();
			$all_error = '';
			if($total_row == 0){
				$all_error = "Invalid old password";
			}
			if($admin_new_password != $admin_cnew_password ){
				$all_error .= '<br>'."New and Confirm New password do not match";
			}
			$password_length = strlen($admin_raw_password);
			if($password_length < 6){
				$all_error .= '<br>'."Password length must be more then 6 character";
			}
			if(empty($all_error)){
				$update_admin_password1 = $this->db->prepare("UPDATE [atYourService].[dbo].[user_masterinfos] SET password = :x WHERE user_id = :id");
				$update_admin_password1->bindparam(':x', $admin_new_password);
				$update_admin_password1->bindparam(':id', $id);
				$update_admin_password1->execute();

				$update_admin_password = $this->db->prepare("UPDATE [OneTUC].[dbo].[user_masterinfos] SET password = :x WHERE user_id = :id");
				$update_admin_password->bindparam(':x', $admin_new_password);
				$update_admin_password->bindparam(':id', $id);
				$update_admin_password->execute();

				$_SESSION['update_user_pass'] = 'update_user_pass';
				header('Location: admin-password-change.php');

			}else{
				return $all_error;
			}
		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/* =================Task Related===================== */
    // data insert and update/edit
	public function add_new_task($data){   
		$task_title  = $this->test_form_input_data($data['task_title']);
		$task_description = $this->test_form_input_data($data['task_description']);
		$priority = $this->test_form_input_data($data['priority']);
		$dept = $this->test_form_input_data($data['dept']);
		$cat = $this->test_form_input_data($data['cat']);
		//$comment = $this->test_form_input_data($data['task_comment']);
		$user_id = $_SESSION['admin_id'];
		
		try{
			
			$add_task = $this->db->prepare("EXEC [dbo].[EntryService_AddTicket_SP] @param_chrTitle = :a ,@param_chrDescription = :b ,@param_intPriorityId = :c 
			,@param_chrDepartment = :d ,@param_chrCategory = :e ,@param_intCreateduser = :id");

			$add_task->bindparam(':a', $task_title);
			$add_task->bindparam(':b', $task_description);
			$add_task->bindparam(':c', $priority);
			$add_task->bindparam(':d', $dept);
			$add_task->bindparam(':e', $cat);	
			//$add_task->bindparam(':h', $comment);
			$add_task->bindparam(':id', $user_id);
			$add_task->execute();

			$message =  'Task Add Successfully';

		}catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

		public function update_task_info($data, $task_id, $user_role){
			$task_title  = $this->test_form_input_data($data['task_title']);
			$reference_id  = $this->test_form_input_data($data['reference_id']);
			$task_description = $this->test_form_input_data($data['task_description']);
			$startdate = $this->test_form_input_data($data['startdate']);
			$t_end_time = $this->test_form_input_data($data['t_end_time']);
			$reso = $this->test_form_input_data($data['reso']);
			$render = $this->test_form_input_data($data['render']);
			$status = $this->test_form_input_data($data['status']);
			$priority = $this->test_form_input_data($data['priority']);
			$assign_to = $this->test_form_input_data($data['assign_to']);
			$user_id = $_SESSION['admin_id'];
			
			try{
				$update_task = $this->db->prepare("EXEC [dbo].[EntryService_UpdateTicket_SP] @param_chrTitle = :a ,@param_chrDescription = :b ,@param_dtCreateddate = :c 
				,@param_dtModifieddate = :d ,@param_intRender = :e ,@param_intModifieduser = :f ,@param_chrReferenceid = :g ,@param_chrResolution = :h
				,@param_chrEntrystatus = :i ,@param_intAssigneduser = :j ,@param_intPriority = :k ,@param_intEntryid = :id ");

				$update_task->bindparam(':a', $task_title);
				$update_task->bindparam(':b', $task_description);
				$update_task->bindparam(':c', $startdate);
				$update_task->bindparam(':d', $t_end_time);
				$update_task->bindparam(':e', $render);
				$update_task->bindparam(':f', $user_id);
				$update_task->bindparam(':g', $reference_id);
				$update_task->bindparam(':h', $reso);
				$update_task->bindparam(':i', $status);
				$update_task->bindparam(':j', $assign_to);
				$update_task->bindparam(':k', $priority);
				$update_task->bindparam(':id', $task_id);
				$update_task->execute();
				//var_dump($reso);
				//var_dump($priority);

				header('Location: task-info.php');
			}catch (PDOException $e) {
				echo $e->getMessage();
			}

		}

		public function add_comment($data){   
			$comment  = $this->test_form_input_data($data['comment']);
			$reference_id  = $this->test_form_input_data($data['reference_id']);
			$user_id = $_SESSION['admin_id'];
			
			try{
				
				$add_task = $this->db->prepare("INSERT INTO [dbo].[entry_comments] (comments, reference_id, user_id) VALUES (:a, :b, :id)");
				$add_task->bindparam(':a', $comment);
				$add_task->bindparam(':b', $reference_id);	
				$add_task->bindparam(':id', $user_id);
				$add_task->execute();
	
				$message =  'Task Add Successfully';
	
			}catch (PDOException $e) {
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