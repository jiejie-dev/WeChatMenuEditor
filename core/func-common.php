<?php
    /** Json数据格式化 
    * @param  Mixed  $data   数据 
    * @param  String $indent 缩进字符，默认4个空格 
    * @return JSON 
    */  
    function json_encode_with_format($data, $indent=null){  

        // 对数组中每个元素递归进行urlencode操作，保护中文字符  
        array_walk_recursive($data, 'jsonFormatProtect');  

        // json encode  
        $data = json_encode($data);  

        // 将urlencode的内容进行urldecode  
        $data = urldecode($data);  

        // 缩进处理  
        $ret = '';  
        $pos = 0;  
        $length = strlen($data);  
        $indent = isset($indent)? $indent : '    ';  
        $newline = "\n";  
        $prevchar = '';  
        $outofquotes = true;  

        for($i=0; $i<=$length; $i++){  

            $char = substr($data, $i, 1);  

            if($char=='"' && $prevchar!='\\'){  
                $outofquotes = !$outofquotes;  
            }elseif(($char=='}' || $char==']') && $outofquotes){  
                $ret .= $newline;  
                $pos --;  
                for($j=0; $j<$pos; $j++){  
                    $ret .= $indent;  
                }  
            }  

            $ret .= $char;  

            if(($char==',' || $char=='{' || $char=='[') && $outofquotes){  
                $ret .= $newline;  
                if($char=='{' || $char=='['){  
                    $pos ++;  
                }  

                for($j=0; $j<$pos; $j++){  
                    $ret .= $indent;  
                }  
            }  

        $prevchar = $char;  
    }  

    return $ret;  
    }  

    /** 将数组元素进行urlencode 
    * @param String $val 
    */  
    function jsonFormatProtect(&$val){  
        if($val!==true && $val!==false && $val!==null){  
            $val = urlencode($val);  
        }  
    }  
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
    /** 保存插件配置
    *  
    */  
    function save_app_config(){
         $path = APP_DIR."/core/inc-config.php";
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
