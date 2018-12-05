<?php
/**
 * Created by PhpStorm.
 * User: headway
 * Date: 2018/12/4
 * Time: 14:44
 */
include "./curl.php";
class wxchant {

    //APPID
    const APPID = "wx05873a03d31c7000";
    //appserect
    const APPSECRET = "eb6d436b9c4dd5aad1100f23e8aa4237";
    
    //获取access_token
    public function getAccessToken()
    {
        $file=self::APPID.".php";
        if(is_file($file) && filemtime($file)+7000 >time()){
            return include $file;
        }
       $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::APPID."&secret=".self::APPSECRET;
        //发送get请求
        $access_token=request($url,[],'');
        $access_token=json_decode($access_token,true);
        file_put_contents($file,'<?php return '.var_export($access_token,true).';?>');
        return $access_token;
    }

    //自定义菜单接口
    public function our_interface()
    {
        $access_token = $this->getAccessToken();
       $url= "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token['access_token'];
       //菜单的格式
        $data= [
            'button'=>[
                [
                    'type'=>'click',
                    'name'=>'你懂得',
                    'key' =>"CCTRTR",
                ],
                [
                    'name'=>'好东西',
                    'sub_button'=>[
                        [
                            'type'=>'view',
                            'name'=>'一库',
                            'url' =>"http://www.baidu.com",
                        ],
                        [
                            'type'=>'scancode_waitmsg',
                            'name'=>'扫码',
                            'key'=>'SSC_scancode_waitmsg',
                            'sub_button'=>[],
                        ],
                        [
                            "type"=> "scancode_push",
                            "name"=> "扫码推事件",
                            "key"=>"rselfmenu_0_1",
                            "sub_button"=>[],
                        ]
                    ]
                ]
            ]
        ];
        $data=json_encode($data,256);
        //进行发送
        $our_interface=request($url,$data,'');
        return $our_interface;
    }
    
    //上传素材
    public function upload_lsc($file,$type='image',$is_long = 0)
    {
        if($is_long == 0){
            $surl = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s";
            $access_token=$this->getAccessToken()['access_token'];
            $url=sprintf($surl,$access_token,$type);
            $req_mes= request($url,[],$file);
        }else{
            $surl = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s&type=%s";
            $access_token=$this->getAccessToken()['access_token'];
            $url=sprintf($surl,$access_token,$type);
            $req_mes= request($url,[],$file);
        }

        $req_mes=json_decode($req_mes,true);
        if($req_mes['errcode']){
            return $req_mes;die;
        }else{
            $req_mes['is_long'] = $is_long;
            if($is_long == 0){
                $req_mes['url'] = "";
            }else{
                $req_mes['type'] = $type;
                $req_mes['created_at'] = time();
            }
            return $req_mes;
        }
    }

    //生成二维码
    public function erweima($type,$secen_id)
    {
        $access_token=$this->getAccessToken()['access_token'];
        $surl="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=%s";
        $url = sprintf($surl,$access_token);
        $action=['QR_SCENE','QR_LIMIT_SCENE'];
        if($type == 0 ){
            $data=[
                "expire_seconds"=>604800,
                "action_name"=>$action[$type],
                "action_info"=>[
                    "scene"=>["scene_id"=>$secen_id]
                ]
            ];
        }else{
            $data=[
                    "action_name"=>$action[$type],
                    "action_info"=>[
                        "scene"=>["scene_id"=>$secen_id],
                    ]
            ];

        }
        $data=json_encode($data);
        $result=request($url,$data,'');
        $result=json_decode($result,true);
        if($result['ticket']){
            $ticket=urlencode($result['ticket']);
            $surl="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=%s";
            $url=sprintf($surl,$ticket);
            $tick_mes=request($url,[],'');
            file_put_contents($secen_id.'.png',$tick_mes);
            print_r("http://www.wx.com:7080/".$secen_id.'.png');
        }else{
            print_r($result['errmsg']);
        }
    }
}

$cc=new wxchant();
print_r($cc->erweima(1,456));
