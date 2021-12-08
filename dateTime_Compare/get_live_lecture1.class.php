<?php
class get_live_lecture extends com_fun
{
    public $db;
    public $data = array();
    function get_live_lecture()
    {
        global $db;
        $this->db = $db;
    }

    function getLiveLecture($batch_name)
    {
       $student_id = com_fun::get_data_from($_POST, 'student_id', '0');

        /*$sql_sub = "SELECT `vabat_name`, `admin_salutation`, `admin_firstname`, `admin_lastname`, `vall_start_time`, `vall_duration`, `vall_meet_id`, `vall_meet_pass`, `vall_status`, `vall_is_disabled`    
            FROM
                va_live_lectures
            JOIN va_admin_master ON va_live_lectures.vall_faculty = va_admin_master.admin_id
            JOIN va_batch_master ON va_live_lectures.vall_batch_id = va_batch_master.vabat_id
            WHERE
                DATE_FORMAT(`vall_start_time`, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d') AND `vall_is_deleted` = 0
            ORDER BY
                `vall_start_time`
            ASC";*/
            /*$sql_user="SELECT
            distinct
            va_live_lectures.vall_topic as  topps,
            va_live_lectures.vall_link as  link,
            va_live_lectures.vall_chapter as  chap,
            va_live_lectures.vall_start_time as timess,
            va_topic_master.vtm_topic_name as tops,
            va_chapter_master.vcm_title as chapt
            
            FROM  va_live_lectures  LEFT JOIN va_batch_master ON va_live_lectures.vall_batch_id=va_batch_master.vabat_id
             LEFT  JOIN va_topic_master
               ON va_batch_master.vabat_sub_id = va_topic_master.vtm_subject_id
             LEFT  JOIN va_chapter_master
               ON  va_topic_master.vtm_subject_id = va_chapter_master.vcm_subject_id
            where va_batch_master.vabat_name ='".$bb."'";*/
         $s_u="SELECT distinct
         va_live_lectures.vall_topic as  vall_topics,
         va_live_lectures.vall_link as  vall_links,
         va_live_lectures.vall_chapter as  vall_chap,
         va_live_lectures.vall_start_time as vall_timess,
         va_live_lectures.vall_duration as  vall_durations,
         va_live_lectures.vall_user_type as  vall_user_types
         FROM  va_live_lectures  LEFT JOIN va_batch_master ON va_live_lectures.vall_batch_id=va_batch_master.vabat_id where va_batch_master.vabat_name ='".$batch_name."'";
        $rs = $this->db->Execute($s_u);
        $arr = array();
        $type="paid";
        if ($rs->Count() > 0) {
            $i = 0;
            while ($rs->MoveNext()) {
                /*if(($rs->Count() ==1)||($rs->Count() ==2)&&($type==$rs->vall_user_types))
                {
                    $arr[$i]['link'] = $rs->vall_links;
                }
                else{
                    $arr[$i]['link'] = $rs->vall_links;
                }*/

               
$sq = new DateTime('2021-09-30 10:50:00');
$so = new DateTime('2021-09-30 12:25:00');
$dk= new DateTime('2021-09-30 09:12:00');
$minutes_to_add = 30;
//$time = new DateTime('2011-11-17 05:05');
//$result = $datetime2->format('Y-m-d H:i:s');
//$time = new DateTime($result);
$ss = $so->add(new DateInterval('PT'.$minutes_to_add.'M'));
$new_Date=$ss->format('Y-m-d H:i');

$eee=new DateTime($new_Date);





                $arr[$i]['curr']=strtotime("now");
                $timezoness = date_default_timezone_get();
                date_default_timezone_set("Asia/Kolkata");

                $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
                $sd= $date->format('d-m-Y H:i:s');
                $arr[$i]['sd']= $sd;
                $arr[$i]['ts']=$timezoness;
                $arr[$i]['user_type'] =$rs->vall_user_types;
                $arr[$i]['link'] = $rs->vall_links;
                $arr[$i]['topic'] = $rs->vall_topics;
                $arr[$i]['ch'] = $rs->vall_chap;
                //$arr[$i]['tst']=$rs->timess;
                $ff=$rs->vall_timess;
                //$dates=date_format($ff,"Y/m/d");
                //$times=date_format($ff,"h:i:s");
                $datess=date('Y/m/d', strtotime($ff));
                $timess=date('h:i A', strtotime($ff));
               // $duration=$rs->;
               $duration_int = 30;

               $objDateTime = new DateTime('NOW');
               //echo $objDateTime->format('Y-m-d H:i');
               $dt=$objDateTime->format('Y-m-d H:i');
               $curr_time= new DateTime($dt);
               //echo "curr_time ".$curr_time."<br>";

               $start_timess = new DateTime($ff);
               //echo "s:".$start_timess."<br>" ;

               $minutes_to_add =30;
               //$time = new DateTime('2011-11-17 05:05');
               //$result = $datetime2->format('Y-m-d H:i:s');
               //$time = new DateTime($result);
               $ss = $start_timess->add(new DateInterval('PT'.$minutes_to_add.'M'));
               //$stamp = $time->format('Y-m-d H:i');
               $end_timess  =$ss->format('Y-m-d H:i');
               //echo "e:".$end_timess."<br>";
                 
               if($curr_time>=$so  && $curr_time<=$eee)
{

    $arr[$i]['link_status']="Live"; 

}

if($curr_time<$start_timess)
{
    $arr[$i]['link_status']="upcoming"; 
}

if($curr_time>$end_timess)
{
    $arr[$i]['link_status']="completed"; 
}

               // echo "ff :".$dates."times ".$times;
              // $arr[$i]['tsk']= $duration_int;
                $arr[$i]['dates']= $datess;
                $arr[$i]['timesf']=$timess;
                $arr[$i]['timese']=date('h:i A', strtotime('+'.' '.$duration_int.' '.'minutes' ,strtotime($ff)));
               // $end_dtimes=date('d/M/Y h:i ', strtotime('+'.' '.$duration_int.' '.'minutes' ,strtotime($ff)));
               //$arr[$i]['end_time']=strtotime($ff) +  strtotime($rs-> vall_durations*60);
               //$arr[$i]['end_time']=(int ) strtotime($ff) + (int) strtotime($duration_int *60);
               // $arr[$i]['end_time']=strtotime($end_dtimes);
               // $arr[$i]['time'] = date('h:i A', strtotime($rs->vall_start_time)) . ' - ' . date('h:i A', strtotime($rs->vall_start_time) + $rs->vall_duration*60);
               // $arr[$i]['startTime'] = strtotime($rs->vall_start_time);
               // $arr[$i]['endTime'] = strtotime($rs->vall_start_time) + $rs->vall_duration*60;
               // $arr[$i]['link'] = "http://localhost/rkedu/1tgbhu2/live/index.html?mn=$rs->vall_meet_id&pwd=$rs->vall_meet_pass";
                //$arr[$i]['meetingUUID'] = "$rs->vall_meet_id";
                //$arr[$i]['status'] = "$rs->vall_status";
                $i++;
            }
            $arr_ses_user['ESTATUS'] = 0;
            //$arr_ses_user['MESSAGE'] = LIVE_LECTURE_MSG_SUCC;
            $arr_ses_user['DATA'] = $arr;
            return com_fun::encode($arr_ses_user);
        } else
        {
            return com_fun::encode(array('ESTATUS' => 1, "MESSAGE" => LIVE_LECTURE_VIDEO_NRF_ERR));
        }
		//echo "batch name :".$bb." s date".$s."end date ".$e;
		//echo "live lecture";
       // exit;
		//return  "in live lecture";
    }


    function joinLiveLecture()
    {
        $student_id =  com_fun::get_data_from($_POST, 'student_id', '0');
        $meetingID = com_fun::get_data_from($_POST, 'meeting_id', '0');
        $db_process = new db_dml($this->db);
		$db_process->tablename = DB_PREFIX.'live_attendance';
		$db_process->arr_data['vala_id'] = '';
		$db_process->arr_data['vala_live_lecture_uuid'] = com_fun::make_db_value($meetingID);
		$db_process->arr_data['vala_student_id'] = com_fun::make_db_value($student_id);
		$db_process->arr_data['vala_created_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vala_updated_date'] = com_fun::make_db_value("now()");
		$db_process->arr_data['vala_is_disabled'] = com_fun::make_db_value('0');
		$db_process->arr_data['vala_is_deleted'] = com_fun::make_db_value('0');
		$db_process->arr_data['vala_admin_id'] = (int)_SES_USER_ID;
		/* echo json_encode($db_process->arr_data);
        exit; */
        $db_process->db_insert();

        $sql_student = "SELECT * FROM ".DB_PREFIX."student_master WHERE vas_id = " .$student_id;
        $rs_stud = $this->db->Execute($sql_student);

        while ($rs_stud->MoveNext()) {
            $sql_lec = "SELECT * FROM ".DB_PREFIX."live_lectures WHERE vall_meet_id = " . $meetingID;
            $rs = $this->db->Execute($sql_lec);
            
            while ($rs->MoveNext()) {
                $link = "http://localhost/rkedu/1tgbhu2/live/index.html?name=" . $rs_stud->vas_firstname . "&mn=" . $meetingID . "&pwd=" . $rs->vall_meet_pass;
            }
        }

        return $link;
        exit;
    }
}
