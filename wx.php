<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "qqqq");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->run();

class wechatCallbackapiTest
{
    public function run()
    {
        if (empty($_GET["echostr"])) {
            $this->responseMsg();
        }else{
            $this->valid();
        }
    }
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postStr=file_get_contents("php://input");
      	//extract post data
		if (!empty($postStr)){
		    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            //根据发送过来的消息进行自动回复
                $msgType=$postObj->MsgType;
                switch ($msgType){
                    case "text":
                        echo $result=$this->replaytext($postObj);
                    break;


                }
        }else {
        	echo "空值";
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
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	public function replaytext($obj){
	    $content=$obj->Content;
	    return $this->createxmltext($obj,$content);
    }

    public function createxmltext($obj,$content)
    {
        //创建xml格式
        $xml="<xml> 
                <ToUserName><![CDATA[%s]]></ToUserName> 
                <FromUserName><![CDATA[%s]]></FromUserName> 
                <CreateTime>%s</CreateTime> 
                <MsgType><![CDATA[text]]></MsgType> 
                <Content><![CDATA[%s]]></Content> 
              </xml>";
        $time=time();
        $tousername=$obj->ToUserName;
        $fromusername=$obj->FromUserName;
        $contents=$content;
        //进行回复
        return sprintf($xml,$fromusername,$tousername,$time,$contents);
    }


}

?>