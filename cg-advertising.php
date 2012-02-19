<?php 
class citygridads {
	
	private $publishercode;
	private $dbserver;
	private $dbname;
	private $dbuser;
	private $dbpassword;

	public function __construct($publishercode) {
		
	  	$this->publishercode = $publishercode;
		
	}

	public function __destruct() {
		 
	}
	
   	public function display_web_ad_300_250($adid,$publisher,$what,$where)
   		{
   		
		$returnAd = '<div id="sidebar_ad_slot_' . $adid . '"></div>';
		$returnAd .= '<script type="text/javascript">';
		$returnAd .= "new CityGrid.Ads('sidebar_ad_slot_" . $adid . "', {";
		$returnAd .= "    collection_id: 'web-002-300x250',";
		$returnAd .= "    publisher: '" . $publisher . "',";
		$returnAd .= "    what:'" . $what . "',";
		$returnAd .= "    where: '" . $where . "',";
		$returnAd .= "    width: 300,";
		$returnAd .= "    height: 250";
		$returnAd .= "  });";
		$returnAd .= "</script>";
   		
   		return $returnAd;
   		
		}
		
   	public function display_web_ad_630_100($adid,$publisher,$what,$where)
   		{		
		
		$returnAd = '<script type="text/javascript">';
		$returnAd .= "new CityGrid.Ads('" . $adid . "', {";
		$returnAd .= "    collection_id: 'web-001-630x100',";
		$returnAd .= "    publisher: '" . $publisher . "',";
		$returnAd .= "    what:'" . $what . "',";
		$returnAd .= "    where: '" . $where . "',";
		$returnAd .= "    width: 630,";
		$returnAd .= "    height: 100";
		$returnAd .= "  });";
		$returnAd .= "</script>";
   		
   		return $returnAd;		
   		
   		}
   		

	// ads/custom/v2/where
   	public function custom_ads_where(
		$what=null, 
		$where=null,
		$max=1,
		$format=null){
   		
   		$client_ip = gethostbyname($_SERVER['HTTP_HOST']);	
   		//echo "IP: " . $client_ip . "<br />";

   		$qStr = "";
   		$url = "http://api.citygridmedia.com/ads/custom/v2/where?";
   		
   		if($what!=''){ $qStr .= "what=" . urlencode($what); }
   		if($where!=''){ $qStr .= "&where=" . urlencode($where); }
   		if($max!=''){ $qStr .= "&max=" . urlencode($max); }

   		$qStr .= "&publisher=" . $this->publishercode;
   		
   		$qStr .= "&client_ip=" . $client_ip;
   		
   		$qStr .= "&format=" . $format;
   		
   		$url .= $qStr;
   		
	 	//echo "pulling - " . $url . "<br /><br />";
		
		$curl_handle = curl_init();  
		curl_setopt($curl_handle, CURLOPT_URL, $url);  
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);   
		
		//curl_setopt($curl_handle,CURLOPT_SSL_VERIFYPEER,0); 
		//curl_setopt($curl_handle,CURLOPT_CAINFO,'/var/www/html/system/ca-bundle.crt');
		
		$searchResponse = curl_exec($curl_handle);  
		curl_close($curl_handle); 
		
		$search = json_decode($searchResponse);
		return $search;   		
   			
   		}   		
   		
	}
?>