<?php
include_once("Configuration.php");
/*
 * Author : Saudamini Sehgal
 *          Akansksha
 *          Darshit
 */
class Cache
{
    public $con = NULL;
    private $stmt = NULL;
    private $res = NULL;
    private $row = NULL;
    private $md5_keyword = NULL;
    private $hits = NULL;
    public $cache_filled = NULL;
    private $min_hit_count = NULL;
    function __construct() 
    {
        $this->con = mysql_connect(Configuration::$SERVER, Configuration::$HOST_NAME, Configuration::$PWD);
        $mysql_select_db =   mysql_select_db(Configuration::$DB_NAME,$this->con);
        if (!$mysql_select_db) 
            {
               die ('Can\'t use foo : ' . mysql_error());
            }
     }
     
     function chk_In_Cache($keyword)
     {
        $this->stmt="SELECT MD5_Keyword , Hit_Count , count(*) as Max_Rows , min(Hit_Count) as Min_Hit_Count FROM cache WHERE Keyword='".$keyword."'";
		$this->res=mysql_query($this->stmt);
        if (!$this->res)
            {
            return 0;
            }
		else 
         {
            $this->row=mysql_fetch_array($this->res);
            $this->md5_keyword = $this->row['MD5_Keyword'];
            $this->hits = $this->row['Hit_Count'];
            $this->cache_filled = $this->row['Max_Rows'];
            $this->min_hit_count = $this->row['Min_Hit_Count'];
            if($this->isCacheEmpty() == 0)
            {
			
                if(!strcasecmp(md5($keyword),  $this->md5_keyword))
                {
                $this->incrementAndUpdate_HitCount($keyword);
                return 1;
                }
            }
            else
            {
                return 0;
            }
			return 0;
         }
     }
     
     function delete_Cache_Entry()
     {
         $this->stmt = "DELETE FROM cache WHERE Hit_Count = ".$this->min_hit_count ;
         $res=mysql_query($this->stmt);
        if (!$res) 
		{
            die('Invalid query: ' . mysql_error());
        }
     }
     
     function get_Result($keyword)
     {
        $this->stmt="SELECT Result FROM cache WHERE Keyword='".$keyword."'";
		$res=mysql_query($this->stmt);
        if (!$res) 
		{
            die('Invalid query: ' . mysql_error());
        }
		$row=mysql_fetch_array($res);
		return $row['Result'];
     }
     
     function isCacheEmpty()
     {
         if($this->cache_filled == 0)
         {
             return 1;
         }
      return 0;
     }
     
     function incrementAndUpdate_HitCount($keyword)
     {
         $this->hits=$this->hits+1;
         $this->stmt = "UPDATE cache SET Hit_Count=".$this->hits." WHERE Keyword='".$keyword."'";
         $mysql_resp = mysql_query($this->stmt);
            if ($mysql_resp)
                return $mysql_resp;
            else
                die("Error in Query.");
     }
}
?>
