<?php
include_once("Configuration.php");
/*
 * Author : Saudamini Sehgal
 *          Akansksha XYZ
 *          Darshit ABC
 */
class Search
{
    public $keyword= NULL;
    public $con = NULL;
    public $result = NULL;


    function __construct() 
    {
        $this->con = mysql_connect(Configuration::$SERVER, Configuration::$HOST_NAME, Configuration::$PWD);
        $mysql_select_db =   mysql_select_db(Configuration::$DB_NAME,$this->con);
        if (!$mysql_select_db) 
            {
               die ('Can\'t use foo : ' . mysql_error());
            }
    }
  
    function get_Result($keyword , $searchtag)
    {
        $this->keyword = $keyword;
        $this->keyword= str_replace(" ","+",  $this->keyword);
        if($searchtag==Configuration::$WEB)
        {
            return $this->search_Web();
        }
        else
        {
            return $this->search_Address();
        }
     }
     
     function search_Web()
     {
         $source = "https://www.googleapis.com/customsearch/v1?key=AIzaSyA6lvcP8ke5QYwPRQzvlo2Btu34COsxWpA&cx=013036536707430787589:_pqjad5hr1a&q=".$this->keyword."&alt=json&prettyPrint=true";
         $data = file_get_contents($source);
		 $enc_data = utf8_encode($data);
		 $dec_data = json_decode($enc_data,true);
		 $result_count = 0;
		 foreach($dec_data['items'] as $p)
			{	if($result_count<1)
				{
					$this->result = $this->result.$p['snippet'];
					//$this->result = $p['title'];
				}
			$result_count = $result_count + 1;
			}
			$t=$this->add_In_Cache();
			return $this->result;
     }
     
     function search_Address()
     {
         $source = "https://maps.googleapis.com/maps/api/place/textsearch/xml?query=".$this->keyword."&sensor=true&key=AIzaSyA6lvcP8ke5QYwPRQzvlo2Btu34COsxWpA";
         $data=file_get_contents($source);
         $xml = new SimpleXMLElement($data);
         $this->result = $xml->result->formatted_address;
         $t=$this->add_In_Cache();
         return $this->result;
     }
     
     function add_In_Cache()
     {
        if($this->isCacheFull())
        {
            $stmt="DELETE FROM cache WHERE Hit_Count IN ( SELECT Count FROM ( SELECT min(Hit_Count) AS Count FROM cache) as temp)";
            $res=mysql_query($stmt);
			Configuration::$CACHE_TOP_COUNT = Configuration::$CACHE_TOP_COUNT - 1;
        }
        $stmt = "INSERT INTO cache VALUES ('".$this->keyword."','".$this->result."','".md5($this->keyword)."',0)";
		Configuration::$CACHE_TOP_COUNT = Configuration::$CACHE_TOP_COUNT + 1;
        return mysql_query($stmt);
     }
     
     function isCacheFull()
     {
	 $stmt="SELECT count(*) AS COUNT from cache";
     $res=mysql_query($stmt);
	 $row = mysql_fetch_array($res);
         if(Configuration::$CACHE_LIMIT == $row['COUNT'])
         {
             return 1;
         }
      return 0;
     }
}
?>