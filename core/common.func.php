<?php
  function do_post_request($url, $data, $optional_headers = null)
  {
     $params = array('http' => array(
                  'method' => 'POST',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
     }
     return $response;
  }
  function save_app_config(){
  	 $path = APP_DIR."\core\config.inc.php";
  	 $outputstring = "<?php 
  	 					define('APP_ID','".APP_ID."');\r\t
  	 					define('APP_SECRET','".APP_SECRET."');\r\t
  	 				  ?>";
	 if(file_exists($path)){
	 	unlink($path);
	 }
  	 $fp = fopen($path, 'ab');
	 flock($fp, LOCK_EX); 
	 if (!$fp)
	 {
	   echo '<p><strong> Your order could not be processed at this time.  '
	        .'Please try again later.</strong></p></body></html>';
	   exit;
	 } 
	 fwrite($fp, $outputstring, strlen($outputstring));
	 flock($fp, LOCK_UN); 
	 fclose($fp);
  }
?>
