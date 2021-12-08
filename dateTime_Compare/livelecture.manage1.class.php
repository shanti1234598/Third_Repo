<?php

/**##FUNCTIONS##**/
require_once("../includes/common_top.php");
require_once 'php-jwt-master/src/BeforeValidException.php';
require_once 'php-jwt-master/src/ExpiredException.php';
require_once 'php-jwt-master/src/SignatureInvalidException.php';
require_once 'php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

class livelecture extends com_fun {

	public $db;
	public $data = array();
	public $err_msg;
	public $err_rows_msg;
	public $success_msg;
	public $sem_branch_data=array();
	private $zoom_api_key = 'jXdDYL6NQYyseHbT1HAhxQ';
	private $zoom_api_secret = 'TaggkjeRhhvDqLo8SOx1YyfWWOQXl5BPz1wq';	
	private $liid=0;
	public $c=1;

	function chapter()
	{
		global $db;
		$this->db = $db;
		$this->empty_data();
	}

	function empty_data()
	{
		$this->data = array('vcm_id'=>'','vcm_edu_level_id'=>'','vcm_subject_id'=>'','vcm_title'=>'','vcm_desc'=>'','vcm_pdf_note'=>'','vcm_pdf_title'=>'','notes_cnt'=>'','vcm_pdf_note_edit'=>'','vcm_pdf_note_edit_id'=>'','vcm_color'=>'','vcm_university_id'=>'');

		$this->sem_branch_data = array('csbsr_branch_id'=>array(),'csbsr_sem_id'=>array());
	}

	function field_value($var_name)
	{
		return com_fun::make_field_value($this->data[$var_name]);
	}

	

	function validate_lecture_data()
	{
		if( com_fun::is_empty($this->data['vabat_name']) ){
			$this->err_msg = $rowMessage = 'Please enter Batch Title.';
			return false;
		}

		if(com_fun::is_empty($this->data['vabat_education_id']) ){
			$this->err_msg = "Please select Education Level.";
			return false;
		}
		 
		if( com_fun::is_empty($this->data['vabat_university_id']) )
		{
			$this->err_msg = "Please select University.";
			return false;
		}
		if( com_fun::is_empty($this->data['vabat_branch_id']) ){
			$this->err_msg = "Please select Branch.";
			return false;
		}		
		if( com_fun::is_empty($this->data['vabat_sem_id']) ){
			$this->err_msg = "Please select Semester.";
			return false;
		}

		if( com_fun::is_empty($this->data['vabat_sub_id']) ){
			$this->err_msg = "Please select Subject Name.";
			return false;
		}

		if( com_fun::is_empty($this->data['admin_id']) ){
			$this->err_msg = "Please select Subject Teacher.";
			return false;
		}
        
		if( com_fun::is_empty($this->data['vabat_startDate']) ){
			$this->err_msg = "Please enter Batch Start Date.";
			return false;
		}

		if( com_fun::is_empty($this->data['vabat_endDate']) ){
			$this->err_msg = "Please enter Batch End Date.";
			return false;
		}

		return true;
	}

    
	function insert_livelecture() {
		if (!$this->validate_lecture_data()) {
			return false;
		}

		$db_process = new db_dml($this->db);
		$db_process->tablename = DB_PREFIX.'batch_master';
		
	//$this->data['vabat_id']='';

     //echo "vabat_id ".$ttt;
	/*$c=(int) $c +1;
	 if($c==2)
	 {
		$v_vabat_id=(int)$ttt+1;
	 }
	 else if($c==3){
		$v_vabat_id=(int)$ttt-1;
	 }
     */
	

	 //echo "v_vabat_id "+$v_vabat_id;
	 if($this->data['vabat_id']==0 )
	 {
		$ttt= com_fun::last_insert_idss();
		$v_vabat_id=(int)$ttt+1;


		//$db_process->arr_data['vabat_id '] =com_fun::make_db_value($this->data['vabat_id']);
		$db_process->arr_data['vabat_id '] =com_fun::make_db_value($v_vabat_id);
		//$g=com_fun::make_db_value($this->data['vabat_id']);
		 //echo "v_vabat_id ===>".$g;
		 $db_process->arr_data['vabat_name'] = com_fun::make_db_value($this->data['vabat_name']);
 
		 $db_process->arr_data['vabat_startDate'] = com_fun::make_db_value($this->data['vabat_startDate']);
		 $db_process->arr_data['vabat_endDate'] = com_fun::make_db_value($this->data['vabat_endDate']);
		 
		 $db_process->arr_data['vabat_education_id'] = com_fun::make_db_value($this->data['vabat_education_id']);
		 $db_process->arr_data['vabat_university_id'] = com_fun::make_db_value($this->data['vabat_university_id']);
		 $db_process->arr_data['vabat_branch_id'] = com_fun::make_db_value($this->data['vabat_branch_id']);
		 $db_process->arr_data['vabat_sem_id'] = com_fun::make_db_value($this->data['vabat_sem_id']);
		 $db_process->arr_data['vabat_sub_id'] = com_fun::make_db_value($this->data['vabat_sub_id']);
 
		 $db_process->arr_data['vabat_created_date'] = com_fun::make_db_value("now()");
		 $db_process->arr_data['vabat_updated_date'] = com_fun::make_db_value("now()");
		 $db_process->arr_data['vabat_is_disabled'] = com_fun::make_db_value('0');
		 $db_process->arr_data['vabat_is_deleted'] = com_fun::make_db_value('0');
		 $db_process->arr_data['vabat_admin_id'] = (int)_SES_USER_ID;
		 $db_process->db_insert();

        //echo "v_vabat_id".$v_vabat_id;
		/*$db_process->arr_data['vabat_id '] = $v_vabat_id;
		$db_process->arr_data['vabat_name'] = com_fun::make_db_value($this->data['vabat_name']);

		$db_process->arr_data['vabat_startDate'] = com_fun::make_db_value($this->data['vabat_startDate']);
		$db_process->arr_data['vabat_endDate'] = com_fun::make_db_value($this->data['vabat_endDate']);
		
        $db_process->arr_data['vabat_education_id'] = com_fun::make_db_value($this->data['vabat_education_id']);
        $db_process->arr_data['vabat_university_id'] = com_fun::make_db_value($this->data['vabat_university_id']);
        $db_process->arr_data['vabat_branch_id'] = com_fun::make_db_value($this->data['vabat_branch_id']);
        $db_process->arr_data['vabat_sem_id'] = com_fun::make_db_value($this->data['vabat_sem_id']);
        $db_process->arr_data['vabat_sub_id'] = com_fun::make_db_value($this->data['vabat_sub_id']);

		$db_process->arr_data['vabat_created_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vabat_updated_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vabat_is_disabled'] = com_fun::make_db_value('0');
		$db_process->arr_data['vabat_is_deleted'] = com_fun::make_db_value('0');
		$db_process->arr_data['vabat_admin_id'] = (int)_SES_USER_ID;
		$db_process->db_insert();*/

		//$liid = $this->data['vabat_id'] = $this->last_inserted_id = $db_process->last_inserted_id;
		//$sss=$v_vabat_id-1;
		//$liid = $this->data['vabat_id'] =  $sss;
		$liid = $this->data['vabat_id'] =$v_vabat_id;

       /*$db_process = new db_dml($this->db);
		$db_process->tablename = DB_PREFIX.'live_lectures';
		$db_process->arr_data['vall_id'] = '';
		
		$db_process->arr_data['vall_uuid'] = com_fun::make_db_value(mt_rand(000000,999999));
		$db_process->arr_data['vall_status'] = com_fun::make_db_value('upcoming');
		$db_process->arr_data['vall_topic'] = com_fun::make_db_value($this->data['vabat_sub_id']);
        $db_process->arr_data['vall_type'] = com_fun::make_db_value(mt_rand(1,4));
		$db_process->arr_data['vall_link'] = com_fun::make_db_value('https://zoom.us/j/91290006798?pwd=azNqaFNvRE4vaWI3amFpVEk3VGpBUT09#success');
		
		$db_process->arr_data['vall_start_time'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vall_duration'] = com_fun::make_db_value(60);
		$db_process->arr_data['vall_batch_id'] = com_fun::make_db_value($this->data['vabat_id']);
		$db_process->arr_data['vall_faculty'] = com_fun::make_db_value($this->data['admin_id']);

		$db_process->arr_data['vall_is_disabled'] = com_fun::make_db_value(0);
		$db_process->arr_data['vall_is_deleted'] = com_fun::make_db_value(0);

		$db_process->arr_data['vall_created_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vall_updaed_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vall_admin_id'] = (int)_SES_USER_ID;
		
		$db_process->db_insert();
		
	 }
	 else{
		 */
	 }

	

	 //}
		/* $isLiveLectureSuccess = $db_process->last_inserted_id;

		if ($isLiveLectureSuccess != '') {
			return $this->success_msg = $success_msg = "Live Lecture Added Successfully";
		} else {
			return $this->err_msg = "Unable to insert data to the database. IN BATCH MASTER";
		} */
		
	}

	private function generateJWTKey() {
		$key = $this->zoom_api_key;
		$secret = $this->zoom_api_secret;
		$token = array(
			"iss" => $key,
			"exp" => time() + 3600 //60 seconds as suggested
		);
		return JWT::encode( $token, $secret );
	}	
	

	public function createMeeting($data = array())
	{
     //$post_time  = $data['start_date'];
	//$start_time = gmdate("Y-m-d\TH:i:s", strtotime($post_time));

	//$start_time ="2020-09-18T05:07:00Z";
	$start_time =$data['start_date'];
	$imgs=$data['img'];
	$ch=$data['chap'];
	$tp=$data['topic'];
	//echo  " start time".$start_time;
	$createMeetingArray = array();
	if (!empty($data['alternative_host_ids'])) {
		if (count($data['alternative_host_ids']) > 1) {
		$alternative_host_ids = implode(",", $data['alternative_host_ids']);
		} else {
		$alternative_host_ids = $data['alternative_host_ids'][0];
		}
	}


	$createMeetingArray['topic']      = $data['topic'];
	$createMeetingArray['agenda']     = !empty($data['agenda']) ? $data['agenda'] : "";
	$createMeetingArray['type']       = !empty($data['type']) ? $data['type'] : 2; //Scheduled
	$createMeetingArray['start_time'] = $start_time;
	//$createMeetingArray['start_time'] = $post_time;
	//$createMeetingArray['timezone']   = 'Asia/Tashkent';
	$createMeetingArray['timezone']   = 'Asia/kolkata';
	$createMeetingArray['password']   = !empty($data['password']) ? $data['password'] : "Shantu123";
	$createMeetingArray['duration']   = !empty($data['duration']) ? $data['duration'] : 60;

	$createMeetingArray['settings']   = array(
				'join_before_host'  => !empty($data['join_before_host']) ? true : false,
				'host_video'        => !empty($data['option_host_video']) ? true : false,
				'participant_video' => !empty($data['option_participants_video']) ? true : false,
				'mute_upon_entry'   => !empty($data['option_mute_participants']) ? true : false,
				'enforce_login'     => !empty($data['option_enforce_login']) ? true : false,
				'auto_recording'    => !empty($data['option_auto_recording']) ? $data['option_auto_recording'] : "none",
				'alternative_hosts' => isset($alternative_host_ids) ? $alternative_host_ids : ""
		);

	//return $this->sendRequest($createMeetingArray);

	$dd=$this->sendRequest($createMeetingArray);
	//$storable_json_string = trim( addslashes( json_encode($dd) ) );
	$rr=json_encode($createMeetingArray);

      $ss=json_decode($dd);
	 // echo "json_form ".$dd;
	$ss->join_url ;
     //echo "image file name IN LIVE CLASS ".$imgs;
    $db_process = new db_dml($this->db);
		$db_process->tablename = DB_PREFIX.'live_lectures';
		$db_process->arr_data['vall_id'] = '';
		
		$db_process->arr_data['vall_uuid'] = com_fun::make_db_value(mt_rand(000000,999999));
		$db_process->arr_data['vall_status'] = com_fun::make_db_value('upcoming');
		$db_process->arr_data['vall_topic'] = com_fun::make_db_value($ss->topic);
		//$db_process->arr_data['vall_topic'] = com_fun::make_db_value($this->data['vabat_sub_id']);
        $db_process->arr_data['vall_type'] = com_fun::make_db_value(mt_rand(1,4));
		$db_process->arr_data['vall_meet_id'] = com_fun::make_db_value($ss->id);
		$db_process->arr_data['vall_link'] = com_fun::make_db_value($ss->join_url );
		$db_process->arr_data['vall_meet_pass'] = com_fun::make_db_value($ss->password );
		//$db_process->arr_data['vall_start_time'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vall_start_time'] = com_fun::make_db_value($data['start_date']);
		$db_process->arr_data['vall_duration'] = com_fun::make_db_value($data['duration'] );
		$db_process->arr_data['vall_batch_id'] = com_fun::make_db_value($this->data['vabat_id']);
		$db_process->arr_data['images'] = com_fun::make_db_value($imgs);
		$db_process->arr_data['vall_topic'] = com_fun::make_db_value($tp);
		$db_process->arr_data['vall_chapter'] = com_fun::make_db_value($ch);
		//$db_process->arr_data['vall_batch_id'] = com_fun::make_db_value($this->liid);
		//echo "vabat_id : ".$this->data['vabat_id'];
		$db_process->arr_data['vall_faculty'] = com_fun::make_db_value($this->data['admin_id']);

		$db_process->arr_data['vall_is_disabled'] = com_fun::make_db_value(0);
		$db_process->arr_data['vall_is_deleted'] = com_fun::make_db_value(0);

		$db_process->arr_data['vall_created_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vall_updaed_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vall_admin_id'] = (int)_SES_USER_ID;
		
		$db_process->db_insert();

		/*$isLiveLectureSuccess = $db_process->last_inserted_id;

		if ($isLiveLectureSuccess != '') {
			return $this->success_msg = $success_msg = "Live Lecture Added Successfully";
		} else {
			return $this->err_msg = "Unable to insert data to the database.";
		}
       */
	  /*
		$db_process = new db_dml($this->db);
        $db_process->tablename = DB_PREFIX.'api_response';
		$db_process->arr_data['id'] = '';
        $db_process->arr_data['api_type'] = com_fun::make_db_value("Create Meeting API");
	    $db_process->arr_data['api_response'] = com_fun::make_db_value($dd);
		$db_process->arr_data['user_id'] = (int)_SES_USER_ID;
		$db_process->db_insert();

        $db_process = new db_dml($this->db);
        $db_process->tablename = DB_PREFIX.'api_request';
		$db_process->arr_data['id'] = '';
        $db_process->arr_data['api_type'] = com_fun::make_db_value("Create Meeting API");
	    $db_process->arr_data['api_request'] = com_fun::make_db_value($rr);
		$db_process->arr_data['user_id'] = (int)_SES_USER_ID;
		$db_process->db_insert();
		*/
        $ts="api_request";
		$tb="Create Meeting API";
        $u=(int)_SES_USER_ID;
		$tg="api_response";
	    $rt=com_fun::api_Req($ts,$tb,$rr,$u);

		$rh=com_fun::api_Res($tg,$tb,$dd,$u);
		
		return $rh;
		//$isLiveLectureSuccess = $db_process->last_inserted_id;

		/*if ($isLiveLectureSuccess != '') {
			return $this->success_msg = $success_msg = "Live Lecture Added Successfully";
		} else {
			return $this->err_msg = "Unable to insert data to the database.IN Live lecture";
		}*/
}	

//function to send request
protected function sendRequest($data)
{
//Enter_Your_Email
$request_url = "https://api.zoom.us/v2/users/shanti.rkdemy@gmail.com/meetings";

$headers = array(
	"authorization: Bearer ".$this->generateJWTKey(),
	"content-type: application/json",
	"Accept: application/json",
);

$postFields = json_encode($data);

	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $request_url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => $postFields,
	CURLOPT_HTTPHEADER => $headers,
	));

	$response = curl_exec($ch);
	$err = curl_error($ch);
	curl_close($ch);
	if (!$response) {
			return $err;
}
	return $response;
	//return json_decode($response);
}




	
}