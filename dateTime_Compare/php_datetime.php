<?php
date_default_timezone_set("Asia/Kolkata");

//$curr_timestamp = date("Y-m-d H:i:s a");
$curr_timestamp = date("Y-m-d H:i:s");
//converting to string in date data type as follow
echo "using date function : ".date("Y-m-d H:i:s")."<br>";

$g=date("Y-m-d H:i:s",strtotime($curr_timestamp));
echo "withount date : ".$g;

$s1="2021-08-17 14:20:55";
$s2="2021-08-15 14:18:50";
$s3="2021-08-18 14:18:58";
$s4="2021-08-13 14:18:54";
$s5="2021-08-17 14:23:54";

function compareByTimeStamp($time1, $time2)
{
    if (strtotime($time1) < strtotime($time2))
        return 1;
    else if (strtotime($time1) > strtotime($time2)) 
        return -1;
    else
        return 0;
}
 

$myStr = array($s1,$s2,$s3,$s4,$s5);
 
echo " current time : ".$curr_timestamp;

usort($myStr, "compareByTimeStamp");
  
print_r($myStr);

?>