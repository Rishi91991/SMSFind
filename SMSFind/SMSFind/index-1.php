<?php
include("Cache.php");
include("Search.php");
/*
 * Author : Saudamini Sehgal
 *          Akansksha XYZ
 *          Darshit ABC
 */
$searchtag = NULL;
$no = $_GET['number'];
$str = $_GET['keyword'];
$srch1 = "ADDRESS:";
$srch2 = "WEB:";
$sub_str = NULL;
//$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//socket_connect($sock, "127.0.0.1", 2400);
//$msg = "Ping !";
//$len = strlen($msg);

//do {
//$input = socket_read($spawn, 4096, 1) or die("Could not read input\n");//echo socket_write($sock, $msg, strlen($msg));
if (substr_count($str,$srch1,0,8)==1)
    {
        $sub_str  = strtoupper(substr($str,8,strlen($str)));
        $searchtag = 2;
    }
else if (substr_count($str,$srch2,0,4)==1)
    {
        $sub_str  = strtoupper(substr($str,4,strlen($str)));
        $searchtag = 1;
    }
	$sub_str = str_replace(" ","+",  $sub_str);
    $cache = new Cache();
    $chk_in_Cache = $cache->chk_In_Cache($sub_str);
    if($chk_in_Cache == 1)
    {
	//echo $cache->get_Result($sub_str);
			$result = $cache->get_Result($sub_str);
			echo $result;
		  // echo socket_write($sock, $result, strlen($result));
    }
    else 
     {
        $search = new Search();
        $result = $search->get_Result($sub_str , $searchtag);
		//echo socket_write($sock, $result, strlen($result));
        echo $result;
    }
//}while(true);
//socket_close($sock);
?>