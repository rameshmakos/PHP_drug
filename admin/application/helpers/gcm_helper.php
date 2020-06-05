<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GCM
 *
 * @author Ravi Tamada
 */

class GCM {

    //put your code here
    // constructor
    function __construct() {
        
    }

    /**
     * Sending Push Notification
     */
    public function send($type, $fields,$key=false){
        $url = 'https://fcm.googleapis.com/fcm/send';
        
      // $api_key = "AAAAZM7pAWM:APA91bECstprda2yo30pwsypRK_o9ENmUMk3UJ_YPz94jviTZ1V2_tLXh2FGbDm7dRtEBEhS3T8wZbPAUTCE24o8UA0ZnSFnMzWVLn6g6XDloM3kzbIeyaaVttBkWXFetGkRPHuI1eqA";
        $api_key = "AAAAcq5VghA:APA91bH-YDX3cWNSvR7L27Yutwv9jNqvAQuZsGYSVJxvieEMJt4evtiy4_D3Dmhfk6xbUyhqCA8iqHuTG1C2A5X2fxzMh7-DDcXcziLnmS5NDrWEsyu0QynPF1Xi84eaZ7x6ugM_e15N";
        if($key==1)
        {
//            $api_key ="AAAAcq5VghA:APA91bH-YDX3cWNSvR7L27Yutwv9jNqvAQuZsGYSVJxvieEMJt4evtiy4_D3Dmhfk6xbUyhqCA8iqHuTG1C2A5X2fxzMh7-DDcXcziLnmS5NDrWEsyu0QynPF1Xi84eaZ7x6ugM_e15N";       }
//        $api_key="AAAAP_h1jYg:APA91bHU0pHLnT1a98idOhW4xmpPHzLnerQTK_K1eThbp5-5vU-kl7DS6gaSdmciwEXrlPRrW-9wZr3kQKojxI6YhsUO9w_LKp5CmihGPmuFHFPuozWE6wX41bOcppcm5SkmS-vi85N3"; }
$api_key="AAAAcq5VghA:APA91bH-YDX3cWNSvR7L27Yutwv9jNqvAQuZsGYSVJxvieEMJt4evtiy4_D3Dmhfk6xbUyhqCA8iqHuTG1C2A5X2fxzMh7-DDcXcziLnmS5NDrWEsyu0QynPF1Xi84eaZ7x6ugM_e15N";}
        $headers = array(
            'Authorization: key=' .$api_key ,
            'Content-Type: application/json'
        );
        
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        return $result;

    }
    public function send_notification($registatoin_ids, $message, $type,$key1) {
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        ); 
        if($type == "ios"){
        
        $fields = array(
            'to' => $registatoin_ids[0],
            'notification' => $message,
            'priority' => 'high',
            'content_available' => true
        );

        }
      return  $this->send($type, $fields,$key1);
    }
    
    public function send_topics($topics, $message, $type) {
        
        $fields = array(
            'to' => $topics,
            'data' => $message,
        );
        if($type=="ios"){
$fields = array(
            'to' => $topics,
            'notification' => $message,
            'priority' => 'high',
            'content_available' => true
        );
} 
        return $this->send($type, $fields);
    }
    
    
    
    public function pushAndroid($order_id='', $token='', $order_statues='')
    {   
        $url ='https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'to' => $token,
            'data' => array (
                 "title" => "Your order Status",
                 "body" => $order_statues                                
            )
        );
        
     $fields_pass = json_encode($fields);
    
        $headers = array (
            
            'Authorization: key='."AAAAqSaqDb4:APA91bFhLzXs7jsVzFOBL19lE9eVsSemkSyqg2D4DTxUFdy2jEIPbtFlU7UPWM1bk8uXdh86zWths5X8GOoE4Gur-T7o9CNK4gTsndKB8D6zT_wJE7l1oFWP3JfjV8IANaG4s4SBOAUJ",
            'Content-Type: application/json',

        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);   
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS,  $fields_pass  );
        $result = curl_exec($ch );
        
        //dump($result);exit;

        if(curl_errno($ch)){           
           throw new Exception(curl_error($ch));
        }
        curl_close( $ch );               
    }
    



}

?>
