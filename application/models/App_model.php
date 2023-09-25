<?php 
class App_model extends CI_Model{
	public function __contruct()
	{
		parent::__contruct();
	}
	
	public function insertMember($ar){
		$query = $this->db->get_where('member', array('member_username' => $ar['member_username']));
		$rs =  $query->result();
		if(!$rs){
			$ar['member_level'] =1;
			$ar['member_lastlogin'] = '0000-00-00 00:00:00';
			$ar['member_secret'] = '';
			$ar['member_password'] = md5(sha1(1234));
			$this->db->insert('member', $ar);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
		}
	}
	
	public function updateMember($ar){
		$query = $this->db->get_where('member', array('member_username' => $ar['member_username']));
		$rs =  $query->result();
		if($rs!=null){
			$this->db->where('member_username',$ar['member_username']);
			$this->db->update('member',$ar);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
		}
	}
	
	public function login($username, $password){
		$this -> db -> select('*');
		$this -> db -> from('member');
		$this -> db -> where('member_username', $username);
		$this -> db -> where('member_password', $password);
		$this -> db -> where('member_status', 1);
		$this -> db -> limit(1);
		$query = $this -> db -> get();
	 
		if($query -> num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function getMemberDetail($member_username){

		$this->db->select('member_lastlogin');
		$this->db->from('member');
		$this->db->where('member_username', $member_username );
		$query = $this->db->get();
		
		return $query->result()[0];
	}
	
	public function getMemberEmail($member_username){

		$this->db->select('member_name, member_email');
		$this->db->from('member');
		$this->db->where('member_username', $member_username );
		$query = $this->db->get();
		
		return $query->result()[0];
	}
	
	public function updateProfile($ar){
		$this->db->where('member_username',$ar['member_username']);
		$this->db->update('member',$ar);
		
		$query = $this->db->get_where('member', array('member_username' => $ar['member_username']));
		return $query->result();
	}
	
	public function changePwd($ar){
		$query = $this->db->get_where('member', array('member_username' => $ar['member_username'], 'member_password'=>$ar['member_password_o']));
		$rs= $query->result();
		if($rs!=null){
			$this->db->where('member_username',$ar['member_username']);
			$this->db->update('member', array('member_password'=>$ar['member_password_n'], 'member_lastlogin'=>date('Y-m-d H:i:s')));
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
		}
	}
	
	public function getAdvanceAmount(){
		//$start = date('Y-d-').'01 00:00:00'; 
		//$end = date('Y-').date('d-')+.' 01 00:00:00';
		
		$this->db->select();
		$this->db->from('3e_advance');
		$this->db->where('MONTH(advance_createdate) = '.date('m'));
		$this->db->where('YEAR(advance_createdate) = '.date('Y'));
		//$this->db->where('advance_createdate <= date("'.$end.'")');
		//$this->db->where('is_deleted = 0');
		$query = $this->db->get();
		
		return count($query->result());
	}
	
	public function createAdvance($ar){
		$this->db->insert('3e_advance', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function updateAdvance($ar){
		$query = $this->db->get_where('3e_advance', array('advance_member_username' => $ar['advance_member_username'], 'advance_id'=>$ar['advance_id'], 'advance_verify_is'=>0, 'advance_is_pay'=>0));
		$rs=$query->result();
		if($rs){
			$this->db->where('advance_member_username', $ar["advance_member_username"]); 
			$this->db->where('advance_id', $ar["advance_id"]); 
			$this->db->update('3e_advance', $ar);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}
	}
	
	public function updateVerifyAdvance($ar){
		$this->db->where('advance_id', $ar["advance_id"]);  
		$this->db->update('3e_advance', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	public function updateVerifyClearAdvance($ar){
		$this->db->where('advance_id', $ar["advance_id"]);  
		$this->db->update('3e_advance_clear', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	public function getAdvanceDetail($advance_id, $member){
		if($member['m_level']==1){
			$this->db->select('t1.*, t2.member_name, t2.member_img');
			$this->db->from('3e_advance t1'); 
			$this->db->join('member t2', 't2.member_username=t1.advance_member_username', 'left');
			$this->db->where('t1.advance_member_username',$member['m_user']);
			$this->db->where('t1.advance_id',$advance_id);
			$this->db->where('t1.is_deleted',0);
			$this->db->order_by('t1.advance_createdate desc');
			$query = $this->db->get();
			//$query = $this->db->get_where('3e_advance', array('advance_id'=>$advance_id, 'advance_member_username'=>$advance_member_username, 'is_deleted'=>0));
		}else{
			$this->db->select('t1.*, t2.member_name, t2.member_img');
			$this->db->from('3e_advance t1'); 
			$this->db->join('member t2', 't2.member_username=t1.advance_member_username', 'left');
			$this->db->where('t1.advance_id',$advance_id);
			//$this->db->where('t1.advance_status',1);
			$this->db->where('t1.is_deleted',0);
			$this->db->order_by('t1.advance_createdate desc');
			$query = $this->db->get();
			//$query = $this->db->get_where('3e_advance', array('advance_id'=>$advance_id, 'is_deleted'=>0));
		}
		return $query->result();
	}
	
	public function delAdvance($advance_id, $member){
		if($member['m_level']==3){
			$this->db->where('advance_id', $advance_id); 
			$this->db->update('3e_advance', array('is_deleted'=>1));
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}else{
			$query = $this->db->get_where('3e_advance', array('advance_member_username' => $member['m_user'], 'advance_id'=>$advance_id, 'advance_verify_is'=>0, 'advance_is_pay'=>0));
			$rs=$query->result();
			if($rs){
				$this->db->where('advance_member_username', $member['m_user']); 
				$this->db->where('advance_id', $advance_id); 
				$this->db->update('3e_advance', array('is_deleted'=>1));
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
			}
		}
	}
	
	public function getAdvanceClearDetail($advance_id, $member){
		if($member['m_level']==1){
			$this->db->select('t1.*, t2.member_name, t2.member_img, t3.advance_clear_id, t3.advance_clear_verify_is, t3.advance_clear_approve_is, t3.advance_clear_datetime, t3.advance_clear_real_money, t3.advance_clear_status, t3.advance_clear_price_total, t3.advance_clear_type, t3.advance_clear_type_note, t3.advance_clear_verify_detail, t3.advance_clear_verify_username, t3.advance_clear_verify_datetime, t3.advance_clear_approve_username, t3.advance_clear_approve_datetime');
			$this->db->from('3e_advance t1'); 
			$this->db->join('member t2', 't2.member_username=t1.advance_member_username', 'left');
			$this->db->join('3e_advance_clear t3', 't3.advance_id=t1.advance_id', 'left');
			$this->db->where('t1.advance_member_username',$member['m_user']);
			$this->db->where('t1.advance_id',$advance_id);
			$this->db->where('t1.is_deleted',0);
			$this->db->order_by('t1.advance_createdate desc');
			$query = $this->db->get();
			//$query = $this->db->get_where('3e_advance', array('advance_id'=>$advance_id, 'advance_member_username'=>$advance_member_username, 'is_deleted'=>0));
		}else{
			$this->db->select('t1.*, t2.member_name, t2.member_img, t3.advance_clear_id, t3.advance_clear_verify_is, t3.advance_clear_approve_is, t3.advance_clear_datetime, t3.advance_clear_real_money, t3.advance_clear_status, t3.advance_clear_price_total, t3.advance_clear_type,t3.advance_clear_type_note, t3.advance_clear_verify_detail, t3.advance_clear_verify_username, t3.advance_clear_verify_datetime, t3.advance_clear_approve_username, t3.advance_clear_approve_datetime');
			$this->db->from('3e_advance t1'); 
			$this->db->join('member t2', 't2.member_username=t1.advance_member_username', 'left');
			$this->db->join('3e_advance_clear t3', 't3.advance_id=t1.advance_id', 'left');
			$this->db->where('t1.advance_id',$advance_id);
			//$this->db->where('t1.advance_status',1);
			$this->db->where('t1.is_deleted',0);
			$this->db->order_by('t1.advance_createdate desc');
			$query = $this->db->get();
			//$query = $this->db->get_where('3e_advance', array('advance_id'=>$advance_id, 'is_deleted'=>0));
		}
		return $query->result();
	}
	
	public function getAdvanceList($member, $m, $y){
		if($member['m_level']==1){
			$this->db->select('t1.*, t2.member_name, t2.member_img, t3.advance_clear_id, t3.advance_clear_verify_is, t3.advance_clear_approve_is');
			$this->db->from('3e_advance t1'); 
			$this->db->join('member t2', 't2.member_username=t1.advance_member_username', 'left');
			$this->db->join('3e_advance_clear t3', 't3.advance_id=t1.advance_id', 'left');
			$this->db->where('t1.advance_member_username',$member['m_user']);
			$this->db->where('t1.is_deleted',0);
			
			$this->db->where('MONTH(advance_createdate) = '.$m);
			$this->db->where('YEAR(advance_createdate) = '.$y);

			$this->db->order_by('t1.advance_createdate asc');
			$query = $this->db->get();
			//$query = $this->db->order_by('advance_createdate desc')->get_where('3e_advance', array('is_deleted'=>0, 'advance_member_username'=>$member['m_user']));
		}else{
			$this->db->select('t1.*, t2.member_name, t2.member_img, t3.advance_clear_id, t3.advance_clear_verify_is, t3.advance_clear_approve_is');
			$this->db->from('3e_advance t1'); 
			$this->db->join('member t2', 't2.member_username=t1.advance_member_username', 'left');
			$this->db->join('3e_advance_clear t3', 't3.advance_id=t1.advance_id', 'left');
			$this->db->where('t1.advance_status',1);
			$this->db->where('t1.is_deleted',0);
			
			$this->db->where('MONTH(advance_createdate) = '.$m);
			$this->db->where('YEAR(advance_createdate) = '.$y);
			
			$this->db->order_by('t1.advance_createdate asc');
			$query = $this->db->get();
			//$query = $this->db->order_by('advance_createdate desc')->get_where('3e_advance', array('advance_status'=>1, 'is_deleted'=>0));
		}
		return $query->result();
	}
	
	
	public function updateAdvanceClear($ar, $member){
		if($member['m_level']==1){
			$query = $this->db->get_where('3e_advance', array('advance_id' => $ar['advance_id'], 'advance_member_username'=>$member['m_user']));
		}else{
			$query = $this->db->get_where('3e_advance', array('advance_id' => $ar['advance_id']));
		}
		$rs=$query->result();
		if($rs){
			$query2 = $this->db->get_where('3e_advance_clear', array('advance_id' => $rs[0]->advance_id));
			$rs2=$query2->result();
			if($rs2!=null){
				if($rs2[0]->advance_clear_verify_is==0 && $rs2[0]->advance_clear_approve_is==0){
					$this->db->where('advance_id', $ar["advance_id"]); 
					$this->db->update('3e_advance_clear', $ar);
					return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
				}	
			}else{
				//insert
				$this->db->insert('3e_advance_clear', $ar);
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
			}
		}else{
			return FALSE;
		}
	}
	
	public function getDocumentTransfer($do){
		$data = array();
		$this->db->select('t1.*, t2.member_name, t2.member_img, t3.*');
		$this->db->from('3e_document_transfer t1'); 
		$this->db->join('member t2', 't2.member_username=t1.transfer_responsible', 'left');
		$this->db->join('3e_document_transfer_category t3', 't3.category_id=t1.transfer_category_id', 'left');
		$this->db->where('t1.transfer_type',$do);
		$this->db->where('t1.is_deleted',0);
		$this->db->order_by('t1.transfer_createdate DESC');
		$query = $this->db->get();
		
		foreach($query->result_array() as $row){
			$subRs = array();
			$subQuery = $this->db->get_where('3e_document_transfer_file', array('file_transfer_id' => $row['transfer_id'], 'deleted'=>0));
		  	foreach($subQuery->result_array() as $subRow){
		  		array_push($subRs,$subRow);
		  	}
			$mainMenu = array(
				"transfer_id" 		=> $row["transfer_id"],
				"transfer_type" 	=> $row["transfer_type"],
				"transfer_code" 	=> $row["transfer_code"],
				"transfer_no" 		=> $row["transfer_no"],
				"transfer_category_id" 		=> $row["transfer_category_id"],
				"transfer_category_name" 		=> $row["transfer_category_name"],
				"transfer_date" 		=> $row["transfer_date"],
				"transfer_form" 		=> $row["transfer_form"],
				"transfer_to" 		=> $row["transfer_to"],
				"transfer_title" 		=> $row["transfer_title"],
				"transfer_responsible" 		=> $row["transfer_responsible"],
				"transfer_responsible_other" 		=> $row["transfer_responsible_other"],
				"transfer_approve" 		=> $row["transfer_approve"],
				"transfer_approve_username" 		=> $row["transfer_approve_username"],
				"transfer_approve_date" 		=> $row["transfer_approve_date"],
				"transfer_createdate" 		=> $row["transfer_createdate"],
				"transfer_member_username" 		=> $row["transfer_member_username"],
				"is_deleted" 		=> $row["is_deleted"],
				"member_name" 		=> $row["member_name"],
				"member_img" 		=> $row["member_img"],
				"category_id" 		=> $row["category_id"],
				"category_name" 		=> $row["category_name"],
	            "subScope"=> $subRs
			);
		  	array_push($data,$mainMenu);
		}
		return $data;
		
	}
	
	public function getMemberList(){
		$query = $this->db->select('member_username, member_name, member_level')->order_by('member_name asc')->get_where('member', array('member_status' => 1));
		return $query->result();
	}
	
	public function getMemberListAll(){
		$query = $this->db->select('*')->order_by('member_name asc')->get_where('member');
		return $query->result();
	}
	
	public function getMemberDetailW($member_username, $member_password){
		$query = $this->db->select('*')->order_by('member_name asc')->get_where('member', array('member_username' => $member_username, 'member_password'=>$member_password));
		return $query->result();
	}
	
	public function getDocumentTransferCount($type){
		$this->db->select('*');
		$this->db->from('3e_document_transfer');
		$this->db->where('YEAR(transfer_date) = '.date('Y'));
		//$this->db->where('is_deleted = 0');
		$this->db->where("transfer_type = '".$type."'");
		$query = $this->db->get();
		
		return count($query->result());
	}
	
	public function getTransfetCategory(){
		$query = $this->db->get('3e_document_transfer_category');
		return $query->result();
	}
	
	public function insertNewDocumentTransfer($ar){
		$this->db->insert('3e_document_transfer', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function updateNewDocumentTransfer($ar){
		$query = $this->db->get_where('3e_document_transfer', array('transfer_id' => $ar['transfer_id']));
		$rs=$query->result();
		if($rs){
			$this->db->where('transfer_id', $ar['transfer_id']); 
			$this->db->update('3e_document_transfer', $ar);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}
	}
	
	public function saveActivityLog($ar){
		$this->db->insert('member_log', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function getActivityLog($member){
		if($member['m_level']==3){
			$this->db->select('t1.*, t2.member_name, t2.member_img');
			$this->db->from('member_log t1'); 
			$this->db->join('member t2', 't2.member_username=t1.log_member_username', 'left');
			$this->db->order_by('t1.log_datetime desc');
			$query = $this->db->get();

		}else{
			$this->db->select('t1.*, t2.member_name, t2.member_img');
			$this->db->from('member_log t1'); 
			$this->db->join('member t2', 't2.member_username=t1.log_member_username', 'left');
			$this->db->where('t1.log_member_username', $member['m_user']);
			$this->db->order_by('t1.log_datetime desc');
			$query = $this->db->get();
			
		//	$query = $this->db->order_by('log_datetime desc')->get_where('member_log', array('log_member_username' => $member['m_user']));
		}
		return $query->result_array();
	}
	
	public function insertProject($ar){
		$this->db->insert('3e_project', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function getProjectDetail($project_id, $member){
		$query = $this->db->get_where('3e_project', array('project_id' => $project_id));
		$rs = $query->result();
		
		if($member['m_level']==3 || $member['m_user']=="kittiya" || $member['m_user']=="chindamanee" || $member['m_level']==4){
			return $rs;
		}

		$data4 = json_decode(@$rs[0]->project_member_permission);
		$project_member_permission = (array) @$data4;
			
		if(in_array($member['m_user'],$project_member_permission)){
			return $rs;
		}else{return false;}
	}
	
	public function getProjectDetailFile($file_project_id){
		$query = $this->db->get_where('3e_project_file', array('file_project_id' => $file_project_id, 'is_deleted'=>0));
		return $query->result_array();
	}
	
	public function updateProject($ar, $member){
		$query = $this->db->get_where('3e_project', array('project_id' => $ar['project_id']));
		$rs = $query->result();
		
		$data4 = json_decode(@$rs[0]->project_member_permission);
		$project_member_permission = (array) @$data4;

		if($member['m_level']==3){
			$this->db->where('project_id', $ar['project_id']); 
			//$this->db->where('project_create_member_username', $member['m_user']); 
			$this->db->update('3e_project', $ar);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}else{
			if(in_array($member['m_user'],$project_member_permission)){
				if($rs!=null){
					$this->db->where('project_id', $ar['project_id']); 
					//$this->db->where('project_create_member_username', $member['m_user']); 
					$this->db->update('3e_project', $ar);
					return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
				}
			}else{
				return FALSE;
			}
		}
	}
	
	public function delProject($id, $member){
		$query = $this->db->get_where('3e_project', array('project_id' => $id));
		$rs = $query->result();

		$data4 = json_decode(@$rs[0]->project_member_permission);
		$project_member_permission = (array) @$data4;
		if($member['m_level']==3){
			$this->db->where('account_project_id', $id); 
			$this->db->update('3e_account', array('is_deleted'=>1));
			
			$this->db->where('project_id', $id); 
			$this->db->update('3e_project', array('is_deleted'=>1));
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}else{
			if(in_array($member['m_user'],$project_member_permission)){
				if($rs!=null){
					$this->db->where('account_project_id', $id); 
					$this->db->update('3e_account', array('is_deleted'=>1));
					
					$this->db->where('project_id', $id); 
					$this->db->update('3e_project', array('is_deleted'=>1));
					return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
				}
			}else{
				return FALSE;
			}
		}
	}
	
	public function getProjectList($project_year, $project_type=null){
		$w_array = array(
			'project_year'	=>$project_year,
			'is_deleted' 	=> 0,
			'is_active'	 	=> 1
		);
		if($project_type!='all'){
			$w_array['project_status'] = $project_type; 
		}
		$query = $this->db->order_by('project_createdate desc')->get_where('3e_project', $w_array);
		return $query->result();
	}
	
	public function addProjectFile($ar){
		$this->db->insert('3e_project_file', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function addDocumentFile($ar){
		$this->db->insert('3e_document_transfer_file', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function getProjectFileLists($project_id, $project_point, $member){
		$query = $this->db->get_where('3e_project', array('project_id' => $project_id));
		$rs=$query->result();
		if($rs){
			$query = $this->db->get_where('3e_project_file', array('file_project_id' => $project_id, 'file_preject_point'=> $project_point, 'is_deleted'=>0));
					return $query->result();
					
			$data4 = json_decode(@$rs[0]->project_member_permission);
			$project_member_permission = (array) @$data4;
			
			if(in_array($member['m_user'],$project_member_permission)){
				//if($rs!=null){
					$query = $this->db->get_where('3e_project_file', array('file_project_id' => $project_id, 'file_preject_point'=> $project_point, 'is_deleted'=>0));
					//return $query->result();
				//}
			}else{
				return FALSE;
			}
		}
	}
	
	
	
	
	public function delProjectFile($file_id, $file_project_id, $member){
		$query = $this->db->get_where('3e_project', array('project_id' => $file_project_id));
		$rs=$query->result();
		if($rs){
			$data4 = json_decode(@$rs[0]->project_member_permission);
			$project_member_permission = (array) @$data4;
			
			if(in_array($member['m_user'],$project_member_permission)){
				$this->db->where('file_project_id', $file_project_id); 
				$this->db->where('file_id', $file_id); 
				$this->db->update('3e_project_file', array('is_deleted'=>1));
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
			}
		}
	}
	
	
	/*--------------------------------*/
	public function insertAccount($ar){
		$this->db->insert('3e_account', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function updateAccount($ar,$member){
		/*
		if($member['m_level']==3 || $member['m_level']==4 || $member['m_user']=="kittiya" || $member['m_user']=="chindamanee"){
			$query = $this->db->get_where('3e_account', array('account_id' => $ar['account_id']));
			$rs=$query->result();
			if($rs!=null){
				$this->db->where('account_id', $ar['account_id']); 
				$this->db->update('3e_account', $ar);
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
			}
		}*/
		$query = $this->db->get_where('3e_account', array('account_id' => $ar['account_id']));
		$rs = $query->result();
		
		$data4 = json_decode(@$rs[0]->account_member_permission);
		$account_member_permission = (array) @$data4;

		if($member['m_level']==3){
			$this->db->where('account_id', $ar['account_id']); 
			//$this->db->where('project_create_member_username', $member['m_user']); 
			$this->db->update('3e_account', $ar);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}else{
			if(in_array($member['m_user'],$account_member_permission)){
				if($rs!=null){
					$this->db->where('account_id', $ar['account_id']); 
					//$this->db->where('project_create_member_username', $member['m_user']); 
					$this->db->update('3e_account', $ar);
					return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
				}
			}else{
				return FALSE;
			}
		}
		
	}
	

	
	public function getAccountDetailFile($file_account_id){
		$query = $this->db->get_where('3e_account_file', array('file_account_id' => $file_account_id, 'is_deleted'=>0));
		return $query->result_array();
	}
	
	public function addAccountFile($ar){
		$this->db->insert('3e_account_file', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function getAccountFileLists($account_id, $account_point, $member){
		$query = $this->db->get_where('3e_account', array('account_id' => $account_id));
		$rs=$query->result();
		if($rs){
			$query = $this->db->get_where('3e_account_file', array('file_account_id' => $account_id, 'file_account_point'=> $account_point, 'is_deleted'=>0));
			return $query->result();
		}
	}
	
	public function checkAccountDetail($account_project_id,$member){
		$query = $this->db->get_where('3e_account', array('account_project_id' => $account_project_id));
		return $query->result();
		
		//$query = $this->db->get_where('3e_account', array('account_id' => $ar['account_id']));
		//$rs = $query->result();
		
		$data4 = json_decode(@$rs[0]->account_member_permission);
		$account_member_permission = (array) @$data4;

		if($member['m_level']==3){
			return $rs;
		}else{
			if(in_array($member['m_user'],$account_member_permission)){
				if($rs!=null){
					return $account_member_permission;
				}
			}else{
				return FALSE;
			}
		}
	}
	
	public function getAccountDetail($account_id,$member){
		$query = $this->db->get_where('3e_account', array('account_id' => $account_id));
		$rs= $query->result();
		
		$data4 = json_decode(@$rs[0]->account_member_permission);
		$account_member_permission = (array) @$data4;

		if($member['m_level']==3){
			return $rs;
		}else{
			if(in_array($member['m_user'],$account_member_permission)){
				if($rs!=null){
					return $rs;
				}
			}else{
				return FALSE;
			}
		}
	}
	
	public function delAccountFile($file_id, $file_account_id, $member){
		$query = $this->db->get_where('3e_account', array('account_id' => $file_account_id));
		$rs=$query->result();
		if($rs){
			if($member['m_level']==3){
				$this->db->where('file_account_id', $file_account_id); 
				$this->db->where('file_id', $file_id); 
				$this->db->update('3e_account_file', array('is_deleted'=>1));
				return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
			}
			
		}
	}

	public function getAccountList($account_year=null){
		$query = $this->db->get_where('3e_account', array( 'is_deleted'=>0));
		return $query->result();
	}
	
	public function getVBPermissions(){
		$query = $this->db->get('vb_permissions');
		return $query->result();
	}
	public function setVBPermissions($ar){
		$this->db->update('vb_permissions', $ar);
	}
	
	public function getVBDocument($topic_group){
		$data = array();
		$query = $this->db->get_where('vb_document_topic', array('topic_group'=>$topic_group, 'deleted' => 0));

		foreach($query->result_array() as $row){
			$subRs = array();
			$subQuery = $this->db->get_where('vb_document', array('doc_topic_id' => $row['topic_id'], 'deleted' => 0));
		  	foreach($subQuery->result_array() as $subRow){
		  		array_push($subRs,$subRow);
		  	}
			$rsTopic = array(
				"topic_id" 			=> $row["topic_id"],
				"topic_name" 		=> $row["topic_name"],
				"topic_permission" 	=> $row["topic_permission"],
	            "subScope"			=> $subRs
			);
		  	array_push($data,$rsTopic);
		}
		return $data;
	}
	
	public function getVBDocumentId($topic_id){
		$query = $this->db->get_where('vb_document_topic', array('topic_id' => $topic_id));
		return $query->result();
	}
	
	
	public function insertVBTopic($ar){
		$this->db->insert('vb_document_topic', $ar);
	}
	public function updateVBTopic($ar){
		$this->db->where('topic_id', $ar['topic_id']); 
		$this->db->update('vb_document_topic', $ar);
	}
	public function getVBTopicDetail($id){
		$query = $this->db->get_where('vb_document_topic', array( 'topic_id'=> $id));
		return $query->result();
	}
	
	public function insertVBDocumentFiles($ar){
		$this->db->insert('vb_document', $ar);
		return $this->db->insert_id();
	}
	public function updateVBDocumentFiles($ar){
		$this->db->where('doc_id', $ar['doc_id']); 
		$this->db->update('vb_document', $ar);
	}
	
	public function getVBDocumentDetail($doc_id){
		$query = $this->db->get_where('vb_document', array('doc_id' => $doc_id));
		return $query->result();
	}
	
	public function delVBTopicDetail($topic_id){
		$this->db->where('topic_id', $topic_id); 
		$this->db->update('vb_document_topic', array('deleted'=>1));
	}
	
	public function delVBDocumentDetail($doc_id){
		$this->db->where('doc_id', $doc_id); 
		$this->db->update('vb_document', array('deleted'=>1));
	}
	

	public function insertVBTver($ar){
		$this->db->insert('vb_tver', $ar);
		return $this->db->insert_id();
	}
	public function updateVBTver($ar){
		$this->db->where('tver_id', $ar['tver_id']); 
		$this->db->update('vb_tver', $ar);
	}
	public function getVBTverLists(){
		$this->db->select('*');
		$this->db->from('vb_tver');
		$this->db->where('deleted', 0 );
		$this->db->order_by('tver_year', 'desc' );
		$this->db->order_by('tver_month', 'desc' );
		$query = $this->db->get();
		return $query->result();
	}
	public function delVBTver($tver_id){
		$this->db->where('tver_id', $tver_id); 
		$this->db->update('vb_tver', array('deleted'=>1));
	}
	public function getVBTverDetail($tver_id){
		$query = $this->db->get_where('vb_tver', array('tver_id' => $tver_id));
		return $query->result();
	}

	public function getVBFilesTemplate($set_source_id,$set_type,$set_point){
		$query = $this->db->get_where('vb_document_set', array('set_source_id' => $set_source_id, 'set_type' => $set_type, 'set_point' => $set_point));
		return $query->result();
	}

	public function setVBFilesTemplate($ar){
		$query = $this->db->get_where('vb_document_set', array('set_source_id' => $ar['set_source_id'], 'set_type' => $ar['set_type'], 'set_point' => $ar['set_point']));
		if($query->result()){
			//update
			$this->db->where('set_source_id', $ar['set_source_id']); 
			$this->db->where('set_type', $ar['set_type']); 
			$this->db->where('set_point', $ar['set_point']); 
			$this->db->update('vb_document_set', $ar);
		}else{
			//insert
			$this->db->insert('vb_document_set', $ar);
			return $this->db->insert_id();
		}
	}

	public function getVBFilesUploads($file_source_id, $file_point, $file_type){
		$query = $this->db->get_where('vb_file', array('deleted' => 0, 'file_source_id'=> $file_source_id, 'file_point'=> $file_point, 'file_type'=> $file_type));
		return $query->result();
	}
	
	public function addProjectFileVB($ar){
		$this->db->insert('vb_file', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	
	public function delVBFile($file_id, $file_source_id, $member){
		$this->db->where('file_source_id', $file_source_id); 
		$this->db->where('file_id', $file_id); 
		//$this->db->where('file_member_username', $member['m_user']); 
		$this->db->update('vb_file', array('deleted'=>1));
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	public function getVBTverFileLists($file_source_id){
		$query = $this->db->get_where('vb_file', array('deleted' => 0, 'file_source_id'=> $file_source_id));
		return $query->result();
	}
	
	public function getVBFileStore(){
		$query = $this->db->get_where('vb_document', array('deleted' => 0));
		return $query->result();
	}
	
	public function getVBFilePoint($set_source_id){
		$query = $this->db->get_where('vb_document_set', array('set_source_id' => $set_source_id));
		return $query->result();
	}
	
	//vbcfo
	public function delVBCFO($cfo_id){
		$this->db->where('cfo_id', $cfo_id); 
		$this->db->update('vb_cfo', array('deleted'=>1));
	}
	public function getVBCFOLists(){
		$this->db->select('*');
		$this->db->from('vb_cfo');
		$this->db->where('deleted', 0 );
		$this->db->order_by('cfo_year', 'desc' );
		$this->db->order_by('cfo_month', 'desc' );
		$query = $this->db->get();
		return $query->result();
	}
	public function insertVBCFO($ar){
		$this->db->insert('vb_cfo', $ar);
		return $this->db->insert_id();
	}
	public function updateVBCFO($ar){
		$this->db->where('cfo_id', $ar['cfo_id']); 
		$this->db->update('vb_cfo', $ar);
	}
	public function getVBCFODetail($cfo_id){
		$query = $this->db->get_where('vb_cfo', array('cfo_id' => $cfo_id));
		return $query->result();
	}
	
	//thesis
	public function getThesisListsSearch($type, $txt){
		$this->db->select('*');
		$this->db->from('doc_thesis');
		$this->db->where('deleted', 0 );
		
		if($type=="thesis_title"){
			$this->db->like('thesis_title', $txt, 'both'); 
		}else if($type=="thesis_owner"){
			$this->db->like('thesis_owner', $txt, 'both'); 
		}else if($type=="thesis_tags"){
			$this->db->like('thesis_tags', $txt, 'both'); 
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	public function getThesisLists($thesis_class){
		$query = $this->db->order_by('createdate desc')->get_where('doc_thesis', array('thesis_class' => $thesis_class, 'deleted'=>0));
		return $query->result();
	}
	public function insertThesis($ar){
		$this->db->insert('doc_thesis', $ar);
		return $this->db->insert_id();
	}
	public function updateThesis($ar){
		$this->db->where('thesis_id', $ar['thesis_id']); 
		$this->db->update('doc_thesis', $ar);
	}
	public function getThesisDetail($thesis_id){
		$query = $this->db->get_where('doc_thesis', array('thesis_id' => $thesis_id));
		return $query->result();
	}
	public function delThesis($thesis_id){
		$this->db->where('thesis_id', $thesis_id); 
		$this->db->update('doc_thesis', array('deleted'=>1));
	}
	public function getThesisFilesUploads($file_thesis_id){
		$query = $this->db->get_where('doc_thesis_file', array('deleted' => 0, 'file_thesis_id'=> $file_thesis_id));
		return $query->result();
	}
	public function addThesisFileuploads($ar){
		$this->db->insert('doc_thesis_file', $ar);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}
	public function delThesisFile($file_id, $file_thesis_id){
		$this->db->where('file_thesis_id', $file_thesis_id); 
		$this->db->where('file_id', $file_id); 
		$this->db->update('doc_thesis_file', array('deleted'=>1));
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	
	//research
	public function getResearchListsSearch($type, $txt){
		$this->db->select('*');
		$this->db->from('doc_research');
		$this->db->where('deleted', 0 );
		
		if($type=="thesis_title"){
			$this->db->like('research_title', $txt, 'both'); 
		}else if($type=="thesis_owner"){
			$this->db->like('research_author', $txt, 'both'); 
		}else if($type=="thesis_tags"){
			$this->db->like('research_tags', $txt, 'both'); 
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	public function getResearchLists(){
		$query = $this->db->order_by('createdate desc')->get_where('doc_research', array('deleted'=>0));
		return $query->result();
	}
	public function updateResearch($ar){
		$this->db->where('research_id', $ar['research_id']); 
		$this->db->update('doc_research', $ar);
	}
	public function insertResearch($ar){
		$this->db->insert('doc_research', $ar);
		return $this->db->insert_id();
	}
	public function getResearchDetail($research_id){
		$query = $this->db->get_where('doc_research', array('research_id' => $research_id));
		return $query->result();
	}
	public function delResearch($research_id){
		$this->db->where('research_id', $research_id); 
		$this->db->update('doc_research', array('deleted'=>1));
	}
}


