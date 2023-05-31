<?php
namespace App\Http\Controllers\dgaAdmin;

class ZalopayApi{

    public $phone       = '';
    public $password        = '';
    public $deviceid  = '';
    public $otp = '';
    public $send_otp_token = '';
    public $token = '';
    public $public_key = '';
    public $salt = '';
    public $config = array();
    public $sieuthicode_config = array(
        "appversion"   => "8.5.0",
        "sdkver"    => "2.0.0" 
        );
   
    public function get_otp_token()
    {
        $headers = array(
            'x-device-id: '.$this->deviceid.'',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.zalopay.vn/v2/account/phone/status?phone_number=".$this->phone."");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        return $data;
    }
    public function get_public_key()
    {
        $headers = array(
            'x-device-id: '.$this->deviceid.'',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.zalopay.vn/v2/user/public-key");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        return $data;
    }
    public function get_salt()
    {
        $headers = array(
            'x-device-id: '.$this->deviceid.'',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.zalopay.vn/v2/user/salt");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        return $data;
    }
    public function get_otp()
    {
        $headers = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
            'x-device-id: '.$this->deviceid.'',
            'x-device-model: Samsung SM_G532G',
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: '.$_SERVER['HTTP_USER_AGENT'].' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer'
         );
         $data =array(
            'phone_number' => $this->phone,
            'send_otp_token' => $this->send_otp_token
        );
        return $this->CURL('https://api.zalopay.vn/v2/account/otp', $headers, $data);
    }
    public function xac_thuc_otp()
    {
        $headers = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
            'x-device-id: '.$this->deviceid.'',
            'x-device-model: Samsung SM_G532G',
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: '.$_SERVER['HTTP_USER_AGENT'].' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer'
         );
         $data =array(
            'phone_number' => $this->phone,
            'otp' => $this->otp
        );
        return $this->CURL('https://api.zalopay.vn/v2/account/otp-verification', $headers, $data);
    }
    
    //login zalo
    // public function ZaloLogin()
    // {
    //     $headers = array(
    //         'Host: api.zalopay.vn',
    //         'x-platform: NATIVE',
    //         'x-device-os: ANDROID',
    //         'x-device-id: '.$this->deviceid.'',
    //         'x-device-model: Samsung SM_G532G',
    //         'x-app-version: '.$this->sieuthicode_config['appversion'],
    //         'user-agent: '.$_SERVER['HTTP_USER_AGENT'].' ZaloPay Android / 9464',
    //         'x-density: hdpi',
    //         'authorization: Bearer'
    //     );
    //     $data =array(
    //         'phone_number' => $this->phone,
    //         'pin' => $this->RsaEncrypt($this->public_key,json_encode(array(
    //             'pin' => hash("sha256",$this->password),
    //             'salt'=> $this->salt
    //             ))),
    //         'phone_verified_token' => $this->token
    //     );
    //     return $this->CURL('https://api.zalopay.vn/v2/account/phone/session', $headers, $data);
    // }
    public function ZaloLogin()
    {
        $headers = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
            'x-device-id: '.$this->deviceid.'',
            'x-device-model: Samsung SM_G532G',
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: '.$_SERVER['HTTP_USER_AGENT'].' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer'
        );
        $data =array(
            'phone_number' => $this->phone,
            'encrypted_pin' => hash("sha256", $this->password),
            'phone_verified_token' => $this->token
        );
        return $this->CURL('https://api.zalopay.vn/v2/account/phone/session', $headers, $data);
    }
    public function ordertoken($phone, $amount, $comment)
    {
        // dd($this->config);
        $result = $this->createorder($phone, $amount, $comment);
        if (isset($result['error'])) {
            dd($result);
        }
        // dd($result['data']['embed_data']);
        $resultv2 = json_decode($result['data']['embed_data'], true);
        // $resultv3 = json_decode($resultv2['item'], true);
        $phonev2 = substr( (string) $phone , -4);
        $phonev3 = substr( (string) $phone , 0, -4);
        
        // $curl = curl_init();
        
        // curl_setopt_array($curl, array(
        //   CURLOPT_URL => 'https://api.zalopay.vn/v2/cashier/assets',
        //   CURLOPT_RETURNTRANSFER => true,
        //   CURLOPT_ENCODING => '',
        //   CURLOPT_MAXREDIRS => 10,
        //   CURLOPT_TIMEOUT => 0,
        //   CURLOPT_FOLLOWLOCATION => true,
        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => 'POST',
        //   CURLOPT_POSTFIELDS =>'{
        //     "sessionid": "'.$this->config['session_id'].'",
        //     "conntype": "wifi",
        //     "mno": "45204",
        //     "platform": "ios",
        //     "token_data": {
        //         "trans_token": "",
        //         "app_id": '.$result['data']['app_id'].'
        //     },
        //     "deviceid": "'.$this->config['deviceId'].'",
        //     "full_assets": true,
        //     "order_type": "FULL_ORDER",
        //     "accesstoken": "'.$this->config['access_token'].'",
        //     "order_data": {
        //         "app_id": 450,
        //         "description": "'.$comment.'",
        //         "mac": "'.$result['data']['mac'].'",
        //         "amount": '.$amount.',
        //         "app_time": "'.$result['data']['app_time'].'",
        //         "item": "{\\"ext\\":\\"'.trim(explode('Số',$resultv3['ext'])[0]).'\\\\tSố điện thoại:****'.$phonev2.'\\"}",
        //         "embed_data": "{\\"orderInfo\\":{\\"clientId\\":\\"2\\",\\"senderZaloPayId\\":\\"'.$resultv2['orderInfo']['senderZaloPayId'].'\\",\\"senderSocialId\\":\\"'.$resultv2['orderInfo']['senderSocialId'].'\\",\\"receiverZaloPayId\\":\\"'.$resultv2['orderInfo']['receiverZaloPayId'].'\\",\\"receiverSocialId\\":\\"'.$resultv2['orderInfo']['receiverSocialId'].'\\",\\"amount\\":\\"'.$resultv2['orderInfo']['amount'].'\\",\\"note\\":\\"'.$resultv2['orderInfo']['note'].'\\",\\"embeddedData\\":\\"{\\\\\\"sender_zalo_id\\\\\\":\\\\\\"'.json_decode($resultv2['orderInfo']['embeddedData'],true)['sender_zalo_id'].'\\\\\\",\\\\\\"sender_zalopay_id\\\\\\":\\\\\\"'.json_decode($resultv2['orderInfo']['embeddedData'],true)['sender_zalo_id'].'\\\\\\",\\\\\\"sender_phone\\\\\\":\\\\\\"'.json_decode($resultv2['orderInfo']['embeddedData'],true)['sender_phone'].'\\\\\\",\\\\\\"receiver_zalo_id\\\\\\":\\\\\\"'.json_decode($resultv2['orderInfo']['embeddedData'],true)['receiver_zalo_id'].'\\\\\\",\\\\\\"receiver_zalopay_id\\\\\\":\\\\\\"'.json_decode($resultv2['orderInfo']['embeddedData'],true)['receiver_zalopay_id'].'\\\\\\",\\\\\\"receiver_phone\\\\\\":\\\\\\"'.json_decode($resultv2['orderInfo']['embeddedData'],true)['receiver_phone'].'\\\\\\"}\\",\\"senderName\\":\\"'.$resultv2['orderInfo']['senderName'].'\\",\\"receiverName\\":\\"'.$resultv2['orderInfo']['receiverName'].'\\",\\"noConfirmation\\":true,\\"item\\":\\"{\\\\\\"ext\\\\\\":\\\\\\"'.trim(explode('Số',$resultv3['ext'])[0]).'\\\\\\\\tSố điện thoại:****'.$phonev2.'\\\\\\"}\\",\\"productCode\\":\\"TF020\\"},\\"transferId\\":\\"'.$resultv2['transferId'].'\\",\\"signature\\":\\"'.$resultv2['signature'].'\\"}",
        //         "app_trans_id": "'.$result['data']['app_trans_id'].'",
        //         "service_fee": {
        //             "message": "",
        //             "fee_amount": "0"
        //         },
        //         "product_code": "'.$result['data']['product_code'].'",
        //         "trans_type": 4,
        //         "app_user": "'.$result['data']['app_user'].'"
        //     },
        //     "issecure": "true",
        //     "userid": "'.$this->config['user_id'].'",
        //     "app_version": "7.17.0",
        //     "devicemodel": "iPhone10,2",
        //     "carriername": "Viettel",
        //     "frontendid": "1",
        //     "display_mode": 1,
        //     "osver": "15.5",
        //     "appversion": "7.17.0",
        //     "mnoupdated": "452_04"
        // }',
        //   CURLOPT_HTTPHEADER => array(
        //     'Host: api.zalopay.vn',
        //     'Authorization: Bearer '.$this->config['access_token'].'',
        //     'x-access-token: '.$this->config['access_token'].'',
        //     'x-zalo-id: '.$this->config['zalo_id'],
        //     'x-zalopay-id:'.$this->config['user_id'],
        //     'x-user-id:'.$this->config['user_id'],
        //     'x-device-model: iPhone10,2',
        //     'x-device-id: '.$this->config['deviceId'],
        //     'sessionid: '.$this->config['session_id'],
        //     'x-device-os: IOS',
        //     'x-os-version: 15.5',
        //     'x-density: iphone3x',
        //     'x-app-version: 7.17.0',
        //     'x-platform: ZPA',
        //     'Connection: keep-alive',
        //     'Content-Type: application/json'
        //   ),
        // ));
        
        // $response = curl_exec($curl);
        
        // curl_close($curl);
        // return $response;
        $phonev2 = substr((string) $phone, -4);
        $header = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
            'x-device-id: ' . $this->config['deviceId'],
            'x-device-model: ios',
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: ' . $_SERVER['HTTP_USER_AGENT'] . ' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer ' . $this->config['access_token'],
            'x-access-token: ' . $this->config['access_token'],
            'x-zalo-id: ' . $this->config['zalo_id'],
            'x-zalopay-id:' . $this->config['user_id'],
            'x-user-id:' . $this->config['user_id']
        );
        // $Data = '{"order_type":"FULL_ORDER","full_assets":true,"order_data":{"app_id":450,"app_trans_id":"' . $result['data']['app_trans_id'] . '","app_time":' . $result['data']['app_time'] . ',"app_user":"' . $result['data']['app_user'] . '","amount":' . $amount . ',"item":"{\"transtype\":4,\"ext\":\"Người nhận:' . $resultv2['orderInfo']['receiverName'] . '\\\tSố điện thoại:*** ' . $phonev2 . '\",\"sender\":{\"phonenumber\":\"' . $this->config['phone'] . '\",\"name\":\"' . $this->config['display_name'] . '\",\"userid\":\"' . $this->config['user_id'] . '\"}}","description":"' . $comment . '","embed_data":"'.json_encode($resultv2).'","mac":"' . $result['data']['mac'] . '","trans_type":4,"product_code":"TF002","service_fee":{"fee_amount":0,"total_free_trans":0,"remain_free_trans":0}},"token_data":{"trans_token":"","app_id":450},"campaign_code":"","display_mode":1}';
        // $Data = '{"order_type":"FULL_ORDER","full_assets":true,"order_data":{"app_id":450,"app_trans_id":"230228000210033","app_time":"1677567729655","app_user":"1;230219005504291","amount":"2000","item":"{\"ext\":\"Người nhận:Hien Dev\\tSố điện thoại:****2451\"}","description":"Đừng quên khoe thiệp cho bạn bè nhé!","embed_data":"{\"orderInfo\":{\"clientId\":\"2\",\"senderZaloPayId\":\"180201000005859\",\"senderSocialId\":\"745499988101243155\",\"receiverZaloPayId\":\"230219005504291\",\"receiverSocialId\":\"9167896808181806705\",\"amount\":\"2000\",\"note\":\"Đừng quên khoe thiệp cho bạn bè nhé!\",\"embeddedData\":\"{\\\"sender_zalo_id\\\":\\\"745499988101243155\\\",\\\"sender_zalopay_id\\\":\\\"180201000005859\\\",\\\"sender_phone\\\":\\\"****4726\\\",\\\"receiver_zalo_id\\\":\\\"9167896808181806705\\\",\\\"receiver_zalopay_id\\\":\\\"230219005504291\\\",\\\"receiver_phone\\\":\\\"****2451\\\"}\",\"senderName\":\"Hien Nguyen\",\"receiverName\":\"Hien Dev\",\"noConfirmation\":true,\"item\":\"{\\\"ext\\\":\\\"Người nhận:Hien Dev\\\\tSố điện thoại:****2451\\\"}\",\"productCode\":\"TF020\"},\"transferId\":\"230228000210033\",\"signature\":\"b18a6be5e4081de7411a039a6ac4e258ce3e51441a06de9751f2e629abdf53ac\"}","mac":"213ddf3ba3bcc8eb5b5660380c31bafe6298ccf3cb22f5357845c191c7383ec1","trans_type":4,"product_code":"TF020"},"campaign_code":"","display_mode":2}';
        $Data = [
            "order_type"=> "FULL_ORDER",
            "full_assets"=> true,
            "order_data"=> [
                "app_id"=> 450,
                "app_trans_id"=> $result['data']['app_trans_id'],
                "app_time"=> $result['data']['app_time'],
                "app_user"=> $result['data']['app_user'],
                "amount"=> $result['data']['amount'],
                "item"=> $result['data']['item'],
                "description"=> $result['data']['description'],
                "embed_data"=> $result['data']['embed_data'],
                "mac"=> $result['data']['mac'],
                "trans_type"=> 4,
                "product_code"=> "TF020"
            ],
            "campaign_code"=> "",
            "display_mode"=> 2
        ];
        // dd(is_array($Data) ? json_encode($Data) : $Data);
        $Action = 'https://api.zalopay.vn/v2/cashier/assets';
        return $this->CURL($Action, $header, $Data);
    }
    // public function getinfov2($phone)
    // {
    //     $header = array(
    //         'Host: zalopay.com.vn'
    //     );
    //     return $this->CURL('https://zalopay.com.vn/um/getuserinfobyphonev2?userid=' . $this->config['user_id'] . '&accesstoken=' . $this->config['access_token'] . '&phonenumber=' . $phone . '&platform=android&deviceid=' . $this->config['deviceId'] . '&devicemodel=Samsung%20SM-G955W&osver=Android%2028%20%289%29&appversion=7.7.0&sdkver=2.0.0&distsrc=&mno=Viettel&conntype=WIFI&issecure=true', $header);
    // }
    public function giaodich1($phone, $amount, $comment)
    {
        $result = $this->getInfoByPhone($phone);
        // dd($phone, $result);
        $phonev2 = substr( (string) $phone , -4);
        $header = array(
            'Content-Type:application/json; charset=UTF-8',
            'Host:mte.zalopay.vn',
            'User-Agent:okhttp/4.9.1'
        );
        $Data = '{"clientid":1,"appid":450,"frontendid":1,"userid":"'.$this->config['user_id'].'","accesstoken":"'.$this->config['access_token'].'","senderuserid":"'.$this->config['user_id'].'","senderzaloid":"'.$this->config['zalo_id'].'","sendername":"'.$this->config['display_name'].'","receiveruserid":"'.$result['userid'].'","receiverzaloid":"0","receivername":"'.$result['displayname'].'","receiverphone":"'.$phone.'","amount":'.$amount.',"description":"'.$comment.'","item":"{\"transtype\":4,\"ext\":\"Người nhận:'.$result['displayname'].'\\\tSố điện thoại:*** '.$phonev2.'\",\"sender\":{\"phonenumber\":\"'.$this->config['phone'].'\",\"name\":\"'.$this->config['display_name'].'\",\"userid\":\"'.$this->config['user_id'].'\"}}","embeddeddata":"","productcode":"TF002"}';
        $Action = 'https://mte.zalopay.vn/api/transfers/direct?platform=android&deviceid='.$this->config['deviceId'].'&devicemodel=Samsung%20SM-G955W&osver=Android%2028%20%289%29&appversion='.$this->sieuthicode_config['appversion'].'&sdkver=2.0.0&distsrc=&mno=Viettel&conntype=WIFI&issecure=true';
        return $this->CURL($Action, $header, $Data);
    }
    public function giaodich2($phone, $amount, $comment)
    {
        $result = $this->giaodich1($phone, $amount, $comment);
        // dd($result);
        $resultv2 = json_decode($result['embeddata'], true);

        $resultv3 = json_decode($resultv2['orderInfo']['item'], true);
        // dd($resultv3);

        $phonev2 = substr( (string) $phone , -4);
        $header = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
            'x-device-id: '.$this->config['deviceId'],
            'x-device-model: Samsung SM_G532G',
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: '.$_SERVER['HTTP_USER_AGENT'].' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer '.$this->config['access_token'],
            'x-access-token: '.$this->config['access_token'],
            'x-zalo-id: '.$this->config['zalo_id'],
            'x-zalopay-id:'.$this->config['user_id'],
            'x-user-id:'.$this->config['user_id']
        );
        $Data = '{"order_type":"FULL_ORDER","full_assets":true,"order_data":{"app_id":450,"app_trans_id":"'.$result['apptransid'].'","app_time":'.$result['apptime'].',"app_user":"'.$result['appuser'].'","amount":'.$amount.',"item":"{\"transtype\":4,\"ext\":\"Người nhận:'.$resultv2['orderInfo']['receiverName'].'\\\tSố điện thoại:*** '.$phonev2.'\",\"sender\":{\"phonenumber\":\"'.$this->config['phone'].'\",\"name\":\"'.$this->config['display_name'].'\",\"userid\":\"'.$this->config['user_id'].'\"}}","description":"'.$comment.'","embed_data":"{\"orderInfo\":{\"clientId\":\"1\",\"senderZaloPayId\":\"'.$this->config['user_id'].'\",\"senderSocialId\":\"'.$resultv2['orderInfo']['senderSocialId'].'\",\"receiverZaloPayId\":\"'.$resultv2['orderInfo']['receiverZaloPayId'].'\",\"receiverSocialId\":\"0\",\"amount\":\"'.$amount.'\",\"note\":\"'.$comment.'\",\"embeddedData\":\"\",\"senderName\":\"'.$this->config['display_name'].'\",\"receiverName\":\"'.$resultv2['orderInfo']['receiverName'].'\",\"noConfirmation\":true,\"item\":\"{\\\\\"transtype\\\\\":4,\\\\\"ext\\\\\":\\\\\"Người nhận:'.$resultv2['orderInfo']['receiverName'].'\\\\\\\tSố điện thoại:*** '.$phonev2.'\\\\\",\\\\\"sender\\\\\":{\\\\\"phonenumber\\\\\":\\\\\"'.$this->config['phone'].'\\\\\",\\\\\"name\\\\\":\\\\\"'.$this->config['display_name'].'\\\\\",\\\\\"userid\\\\\":\\\\\"'.$this->config['user_id'].'\\\\\"}}\",\"receiverPhoneStr\":\"'.$phone.'\",\"productCode\":\"TF002\"},\"transferId\":\"'.$resultv2['transferId'].'\",\"signature\":\"'.$resultv2['signature'].'\"}","mac":"'.$result['mac'].'","trans_type":4,"product_code":"TF002","service_fee":{"fee_amount":0,"total_free_trans":0,"remain_free_trans":0}},"token_data":{"trans_token":"","app_id":450},"campaign_code":"","display_mode":1}';
        // $Data = '{"order_type":"FULL_ORDER","full_assets":true,"order_data":{"app_id":450,"app_trans_id":"'.$result['apptransid'].'","app_time":'.$result['apptime'].',"app_user":"'.$result['appuser'].'","amount":'.$amount.',"item":"{\"transtype\":4,\"ext\":\"Người nhận:'.$result['displayname'].'\\tSố điện thoại:*** '.$phonev2.'\",\"sender\":{\"phonenumber\":\"037 3690789\",\"name\":\"'.$this->config['name'].'\",\"userid\":\"'.$this->config['user_id'].'\"}}","description":"'.$comment.'","embed_data":"{\"orderInfo\":{\"clientId\":\"1\",\"senderZaloPayId\":\"'.$resultv2['orderInfo']['senderZaloPayId'].'\",\"senderSocialId\":\"'.$resultv2['orderInfo']['senderSocialId'].'\",\"receiverZaloPayId\":\"'.$resultv2['orderInfo']['receiverZaloPayId'].'\",\"receiverSocialId\":\"0\",\"amount\":\"'.$resultv2['orderInfo']['amount'].'\",\"note\":\"'.$resultv2['orderInfo']['note'].'\",\"embeddedData\":\"\",\"senderName\":\"'.$resultv2['orderInfo']['senderName'].'\",\"receiverName\":\"'.$resultv2['orderInfo']['receiverName'].'\",\"noConfirmation\":true,\"item\":\"{\"transtype\":4,\"ext\":\"Người nhận:'.$result['displayname'].'\\tSố điện thoại:*** '.$phonev2.'\",\"sender\":{\"phonenumber\":\"037 3690789\",\"name\":\"'.$this->config['name'].'\",\"userid\":\"'.$this->config['user_id'].'\"}}\",\"receiverPhoneStr\":\"'.$phone.'\",\"productCode\":\"TF002\"},\"transferId\":\"'.$resultv2['transferId'].'\",\"signature\":\"'.$resultv2['signature'].'\"}","mac":"'.$result['mac'].'","trans_type":4,"product_code":"TF002","service_fee":{"fee_amount":0,"total_free_trans":0,"remain_free_trans":0}},"token_data":{"trans_token":"","app_id":450},"campaign_code":"","display_mode":1}';
        $Action = 'https://api.zalopay.vn/v2/cashier/assets';
        return $this->CURL($Action, $header, $Data);
    }
    public function giaodich3($phone, $amount, $comment)
    {
        

        $result = $this->giaodich2($phone, $amount, $comment);
        $pass = hash('sha256', $this->config['password']);
        $header = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
            'x-device-id: '.$this->config['deviceId'],
            'x-device-model: Samsung SM_G532G',
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: '.$_SERVER['HTTP_USER_AGENT'].' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer '.$this->config['access_token'],
            'x-access-token: '.$this->config['access_token'],
            'x-zalo-id: '.$this->config['zalo_id'],
            'x-zalopay-id:'.$this->config['user_id'],
            'x-user-id:'.$this->config['user_id']
        );
        $Data = '{"order_token":"'.$result['data']['order_token'].'","sof_token":"'.$result['data']['source_of_fund']['sof_token'].'","promotion_token":"","transaction_fee":0,"service_fee":0,"authenticator":{"authen_type":1,"pin":"'.$pass.'","bio_token":"","pay_token":"","bio_state":""},"zalo_token":"","service_id":0,"order_source":0}';
        $Action = 'https://api.zalopay.vn/v2/cashier/pay';
        return $this->CURL($Action, $header, $Data);
    }
    public function verify_pin(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sapi.zalopay.vn/v2/user/pin:validate',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "pin": "'.hash("sha256",$this->config['password']).'",
            "type": 1
        }',
          CURLOPT_HTTPHEADER => array(
            'Host: sapi.zalopay.vn',
            'Cookie: zalo_id='.$this->config['zalo_id'].'; zlp_token='.$this->config['access_token'].'; X-DRSITE=off; has_device_id=0',
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return $response;
    }
    public function payMent($phone, $amount, $comment)
    {
        if (preg_match('/^[0-9]{10}+$/', $phone)) {
            $receiverInfo = $this->getInfoByPhone($phone);
            if (isset($receiverInfo['userid'])) {
                $phone = $receiverInfo['userid'];
            }
        }
        $result = $this->ordertoken($phone, $amount, $comment);
        
        $pass = hash('sha256', $this->config['password']);
        $header = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
            'x-device-id: ' . $this->config['deviceId'],
            'x-device-model: Samsung SM_G532G',
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: ' . $_SERVER['HTTP_USER_AGENT'] . ' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer ' . $this->config['access_token'],
            'x-access-token: ' . $this->config['access_token'],
            'x-zalo-id: ' . $this->config['zalo_id'],
            'x-zalopay-id:' . $this->config['user_id'],
            'x-user-id:' . $this->config['user_id']
        );
        $Data = '{
            "order_token":"' . $result['data']['order_token'] . '",
            "sof_token":"' . $result['data']['source_of_fund']['sof_token'] . '",
            "promotion_token":"",
            "transaction_fee":0,
            "service_fee":0,
            "authenticator":{
                "authen_type":1,
                "pin":"' . $pass . '",
                "bio_token":"",
                "pay_token":"",
                "bio_state":""
            },
            "zalo_token":"",
            "service_id":0,
            "order_source":0
        }';
        $Action = 'https://api.zalopay.vn/v2/cashier/pay';
        return $this->CURL($Action, $header, $Data);
    }
    public function createorder($phone, $amount, $comment){
        // $info = $this->getinfov2($phone);
        // dd($info);
        $phonev2 = substr((string) $phone, -4);
         $header = array(
            'Host: sapi.zalopay.vn',
            'Origin: https://social.zalopay.vn',
            'Cookie: zalo_id='.$this->config['zalo_id'].'; zlp_token='.$this->config['access_token'].'; X-DRSITE=off; has_device_id=0',
        );
        $Data = '
        {
            "receiver_user_id": "'.$phone.'",
            "receiver_zalo_id": null,
            "receiver_name": "",
            "receiver_avatar": "",
            "amount": "'.$amount.'",
            "note": "'.$comment.'",
            "zalo_token": null,
            "media": {
                "greeting_card": {
                    "theme_id": "1"
                }
            }
        }';
        $Action = 'https://sapi.zalopay.vn/mt/v5/order';
        return $this->CURL($Action, $header, $Data);
        // $header = array(
        // 'Content-Type:application/json; charset=UTF-8',
        // 'Host:mte.zalopay.vn',
        // 'User-Agent:okhttp/4.9.1'
        // );
        // $Data = '{
        //     "clientid":1,
        //     "appid":450,
        //     "frontendid":1,
        //     "userid":"' . $this->config['user_id'] . '",
        //     "accesstoken":"' . $this->config['access_token'] . '",
        //     "senderuserid":"' . $this->config['user_id'] . '",
        //     "senderzaloid":"' . $this->config['zalo_id'] . '",
        //     "sendername":"' . $this->config['name'] . '",
        //     "receiveruserid":"' . $info['userid'] . '",
        //     "receiverzaloid":"0",
        //     "receivername":"' . $info['displayname'] . '",
        //     "receiverphone":"' . $phone . '",
        //     "amount":' . $amount . ',
        //     "description":"' . $comment . '",
        //     "item":"{\"transtype\":4,\"ext\":\"Người nhận:' . $info['displayname'] . '\\\tSố điện thoại:*** ' . $phonev2 . '\",\"sender\":{\"phonenumber\":\"' . $this->config['phone'] . '\",\"name\":\"' . $this->config['display_name'] . '\",\"userid\":\"' . $this->config['user_id'] . '\"}}","embeddeddata":"","productcode":"TF002"}';
        // $Action = 'https://mte.zalopay.vn/api/transfers/direct?platform=android&deviceid=' . $this->config['deviceId'] . '&devicemodel=Samsung%20SM-G955W&osver=Android%2028%20%289%29&appversion=7.7.0&sdkver=2.0.0&distsrc=&mno=Viettel&conntype=WIFI&issecure=true';
        // return $this->CURL($Action, $header, $Data);
        
    }
    public function getBalance()
    {
        $headers = array(
            'Host: api.zalopay.vn',
            'x-platform: NATIVE',
            'x-device-os: ANDROID',
             'x-device-id: '.$this->config['deviceId'],
            'x-device-model: Samsung SM_G532G',
           'x-access-token: '.$this->config['access_token'],
            'x-zalo-id: '.$this->config['zalo_id'],
            'x-zalopay-id:'.$this->config['user_id'],
            'x-user-id:'.$this->config['user_id'],
            'x-app-version: '.$this->sieuthicode_config['appversion'],
            'user-agent: '.$_SERVER['HTTP_USER_AGENT'].' ZaloPay Android / 9464',
            'x-density: hdpi',
            'authorization: Bearer '.$this->config['access_token']
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.zalopay.vn/v2/user/balance");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        if (is_object(json_decode($data))) {
            return json_decode($data, true);
        }
        return $data;
    }

    public function getOrderInfo($orderCode)
    {
        $headers = array(
            'Cookie: has_device_id=0; zalo_id='.$this->config['zalo_id'].'; zlp_token='.$this->config['access_token'].'; X-DRSITE=off'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sapi.zalopay.vn/mt/v5/order/".$orderCode);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data,true);
    }

    public function getUserInfoByZalopayId($user_id)
    {
        // $headers = array(
        //     'Host: sapi.zalopay.vn',
        //     'x-device-os: ANDROID',
        //     'x-platform" ZPA',
        //     'authorization:Bearer '.$this->config['access_token'].''
        // );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://zalopay.com.vn/um/getuserinfobyzalopayidv2?accesstoken=".$this->config['access_token']."&requestid=".$user_id."&userid=".$this->config['user_id']);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    // dd($data);
        curl_close($ch);
        return json_decode($data,true);
    }

    public function getHistory($user_id,$access_token,$device_id,$hours)
    {
        $sieuthicode =  (time() - (3600 * $hours)) * 1000;
        $headers = array(
            'Host: zalopay.com.vn'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://zalopay.com.vn/v001/tpe/transhistory?userid=$user_id&accesstoken=$access_token&timestamp=$sieuthicode&count=20&order=1&statustype=1&platform=android&deviceid=$device_id&devicemodel=Samsung%20SM-G610F&osver=Android%2027%20%288.1.0%29&appversion=7.7.0&sdkver=2.0.0&distsrc=&mno=VN%20MobiFone&conntype=4G&issecure=true");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        return $data;
    }
    public function checkHistory($access_token)
    {
        $result = $this->getHistoryV2($access_token);
        
        // dd(json_decode($result['ẻ']));
        if (isset($result['error'])) {
            return array(
                "status" => "error",
                "code"   => 16,
                "message"=> 'Hết thời gian đăng nhập vui lòng đăng nhập lại'
            );
        }
        $HisList = $result["data"]['transactions'];
        if(empty($HisList)){
            return array(
                "status" => "error",
                "code"   => -5,
                "message"=> 'Hết thời gian đăng nhập vui lòng đăng nhập lại'
            );
        }
        $tranList = array();
        foreach ($HisList as $transaction){
            if ($transaction['sign'] == -1) {
                continue;
            }
            if ($transaction['sign'] == 1 && $transaction['status_info']['status'] != 1) {
                continue;
            }
            $detailTrans = json_decode($this->GET_TRANS_BY_TID($transaction['trans_id'],$access_token),true);
            if (isset($detailTrans['error'])) {
                continue;
            }
            
            $list_result = $detailTrans["data"]['transaction'];
            // dd($transaction,$list_result);
            $orderInfo = $this->getOrderInfo($list_result['app_trans_id']);
            if (isset($orderInfo['error'])) {
                continue;
            }
            // dd($orderInfo);
            // $getInfo = $this->getUserInfoByZalopayId("200503000005093");
            // dd($getInfo);

            $transaction['title'] = str_replace('Nhận tiền từ ', '', $transaction['title']);
            $transaction['title'] = str_replace('Nhận tiền mừng từ ', '', $transaction['title']);
            $transaction['title'] = str_replace('Chuyển tiền tới ', '', $transaction['title']);
            $comment = explode(" ", (!empty($list_result["description"])) ? $list_result["description"] : "");
            $fullDescription = (!empty($list_result["description"])) ? $list_result["description"] : "";
                $tranList[] = array(
                    "user_id" => $orderInfo['data']['sender']['user_id'],
                    "partnerName" => $transaction['title'],
                    "tranId"=> $list_result["trans_id"],
                    "sign"    => $list_result["sign"],
                    "amount" => empty($list_result["trans_amount"]) ? 0 : $list_result["trans_amount"],
                    "comment" => $fullDescription,
                    "patnerID" => $orderInfo['data']['sender']['user_id'],
                    "description" => $fullDescription,
                    "trans_time"  => empty($list_result["trans_time"]) ? "" : $list_result["trans_time"],
                    "icon" =>empty($list_result["icon"]) ? "" : $list_result["icon"],
                //    "detailTrans" => $list_result,
                //    'orderInfo' => $orderInfo,
                //    'getInfo' => $getInfo
                );
        }

       return (array(
            "status" => true,
              'message' => 'Thành công',
              "data" => $tranList,
              "HisList" => $HisList
      ));
    }
    public function getHistoryV2($access_token)
    {
        $headers = array(
            'Host: sapi.zalopay.vn',
            'x-device-os: ANDROID',
            'x-platform" ZPA',
            'authorization:Bearer '.$access_token.''
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sapi.zalopay.vn/v2/history/transactions?category_id=2&page_size=10&page_token=");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        return json_decode($data,true);
    }
    public function GET_TRANS_BY_TID($ID,$access_token)
    {
         $headers = array(
            // 'Host: sapi.zalopay.vn',
            // 'x-device-os: ANDROID',
            // 'x-platform" ZPA',
            // 'x-requested-with:	vn.com.vng.zalopay',
            // 'user-agent: Mozilla/5.0 (Linux; Android 12; Pixel 3 Build/SQ3A.220705.004; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/110.0.5481.154 Mobile Safari/537.36ZaloPayClient/8.5.0 ZaloPayWebClient/8.5.0',
            'Cookie: zalo_id='.$this->config['zalo_id'].'; zlp_token='.$this->config['access_token'].'; X-DRSITE=off; has_device_id=0',
            // 'authorization: Bearer '.$access_token.''
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://sapi.zalopay.vn/v2/history/transactions/$ID?type=1");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        return $data;
    }
    public function getName($user_id,$access_token,$device_id)
    {
        $headers = array(
            'Host: zalopay.com.vn'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://zalopay.com.vn/um/getuserprofilesimpleinfo?userid=$user_id&accesstoken=$access_token&platform=android&deviceid=$device_id&devicemodel=Vsmart%20Live%204&osver=Android%2030%20%2811%29&appversion=7.10.0&sdkver=2.0.0&distsrc=&mno=Viettel&conntype=WIFI&issecure=true");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
    
        curl_close($ch);
        return $data;
    }
    
    public function get_info($receiver)
    {
        if (preg_match('/^[0-9]{10}+$/', $receiver)) {
            return $this->getInfoByPhone($receiver);
        }
        return $this->getUserInfoByZalopayId($receiver);
        
    }
    public function getInfoByPhone($phone)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://zalopay.com.vn/um/getuserinfobyphonev2?accesstoken='.$this->config['access_token'].'&appversion=7.17.0&carriername=Viettel&conntype=wifi&deviceid='.$this->config['deviceId'].'&devicemodel=iPhone10%252C2&frontendid=1&issecure=true&mno=45204&mnoupdated=452_04&osver=15.5&phonenumber='.$phone.'&platform=ios&sessionid='.$this->config['session_id'].'&userid='.$this->config['user_id'].'',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        return json_decode($response,true);
        
    }
    public function CURL($Action, $header, $data)
    {
        $Data = is_array($data) ? json_encode($data) : $data;
        $curl = curl_init();
        // echo strlen($Data); die;
        $header[] = 'Content-Type: application/json';
        $header[] = 'accept: application/json';
        $header[] = 'Content-Length: ' . strlen($Data);
        $opt = array(
            CURLOPT_URL => $Action,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POST => empty($data) ? FALSE : TRUE,
            CURLOPT_POSTFIELDS => $Data,
            CURLOPT_CUSTOMREQUEST => empty($data) ? 'GET' : 'POST',
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_ENCODING => "",
            CURLOPT_HEADER => FALSE,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_TIMEOUT => 5,
        );
        curl_setopt_array($curl, $opt);
        $body = curl_exec($curl);
        // echo strlen($body); die;
        if (is_object(json_decode($body))) {
            return json_decode($body, true);
        }
        return $body;
    }
    function RsaEncrypt($key,$content)
    {
        if(empty($this->rsa)){
            $this->INCLUDE_RSA($key);
        }
        return base64_encode($this->rsa->encrypt($content));
    }
    public function INCLUDE_RSA($key)
    {
        require_once('Crypt/RSA.php');
        $this->rsa = new Crypt_RSA();
        $this->rsa->loadKey($key);
        $this->rsa->setHash('sha256');
        $this->rsa->setMGFHash('sha256');
        $this->rsa->setEncryptionMode(1);
        return $this;
    }
    // private function INCLUDE_RSA($key)
    // {
    //     require_once('Crypt/RSA.php');
    //     $this->rsa = new Crypt_RSA();
    //     $this->rsa->loadKey($key);
    //     $this->rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
    //     return $this;
    // }
    public function Encrypt_data($data, $key)
    {

        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $this->keys = $key;
        return base64_encode(openssl_encrypt(is_array($data) ? json_encode($data) : $data, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv));
    }

    public function Decrypt_data($data)
    {

        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($data), 'AES-256-CBC', $this->keys, OPENSSL_RAW_DATA, $iv);
    }

    public function generateCheckSum($type, $microtime)
    {
        $Encrypt =   $this->config["phone"] . $microtime . '000000' . $type . ($microtime / 1000000000000.0) . 'E12';
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($Encrypt, 'AES-256-CBC', $this->config["setupKeyDecrypt"], OPENSSL_RAW_DATA, $iv));
    }

    public function get_pHash()
    {
        $data = $this->config["imei"] . "|" . $this->config["password"];
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return base64_encode(openssl_encrypt($data, 'AES-256-CBC', $this->config["setupKeyDecrypt"], OPENSSL_RAW_DATA, $iv));
    }

    public function get_setupKey($setUpKey)
    {
        $iv = pack('C*', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        return openssl_decrypt(base64_decode($setUpKey), 'AES-256-CBC', $this->config["ohash"], OPENSSL_RAW_DATA, $iv);
    }

    public function generateRandom($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function get_SECUREID($length = 17)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
   public function generateImei()
    {
        return $this->generateRandomString(8) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(4) . '-' . $this->generateRandomString(12);
    }
    public function generateRandomString($length = 20)
    {
        $characters = '0123456789AQWERTYUIOPSDFGHJKLMNBVCXZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
  
}
?>