<?php
/**
  * Name : A class for wechat api
  * Author : Jeremaihloo (卢杰杰)
  * Home : lujiejie.com  
  */
class WeiXin
{
    //微信操作类基本成员变量及方法
    private $expires_in = 7200;
    private $latest_time;
    private $access_token;

    private static $instance;
    private function __construct(){
        
    }
    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __clone(){
        trigger_error("Clone is not allowed !");
    }
    private $isDebug = true;
    
    public function Debug($is_debug){
        $this->isDebug = $is_debug;
    }
	public function setAccessToken($accessToken){
		$this->access_token = $accessToken;
	}
	public function getAccessTokenBySource($app_id,$app_secret){
		define('APP_ID', $app_id);
		define('APP_SECRET', $app_secret);
		return $this->getAccessToken();
	}
	public function getAccessToken(){
        $now = date("Y-m-d H:i:s ");
        if(empty($this->access_token)){
            $get_path = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APP_ID.'&secret='.APP_SECRET;
            $json = file_get_contents($get_path);
            $result = json_decode($json,true);        
            $this->access_token = $result['access_token'];
            $this->latest_time = $now;
            $this->expires_in = $result['expires_in'];
            return $result['access_token'];         
        }else{
        	return $this->access_token;
        }
//      else{
//          $second = floor((strtotime($now)-strtotime($latest_time))%86400%60);
//              if($second>$this->expires_in){
//                  $get_path = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APP_ID.'&secret='.APP_SECRET;
//                  $json = file_get_contents($get_path);
//                  $result = json_decode($json,true);        
//                  $this->access_token = $result['access_token'];
//                  $this->latest_time = $now;
//                  $this->expires_in = $result['expires_in'];
//                  return $result['access_token'];         
//              }
//              else{
//                  return $this->access_token;
//              }
//      }
        

        $get_path = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APP_ID.'&secret='.APP_SECRET;
        $json = file_get_contents($get_path);
        $result = json_decode($json,true);        

        return $result['access_token'];         
	}
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        echo $echoStr;
        //valid signature , option
        //if($this->checkSignature()){
        	//echo $echoStr;
        	//exit;
        //}
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

    //自定义菜单封装-------------------------------------------------------------------------------------------
    public function createMenu($buttons){
          $create_path = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->getAccessToken();
          $json = do_post_request($create_path,$buttons);
          $result = json_decode($json,true);
          if($result['errmsg']=='ok')
              return true;
          else
              return false;
      }
      
      public function deleteMenu(){
          $del_path = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$this->getAccessToken();
          $json = file_get_contents($del_path);
          $result = json_decode($json,true);
          if($result['errmsg']=='ok')
              return true;
          else
              return false;
      }
      public function viewMenu(){
          $get_path = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->getAccessToken();
          $result = file_get_contents($get_path);
          return json_decode($result,true);
      }

      //-----------------------------------------------------------------------------------------------------------
}

?>
