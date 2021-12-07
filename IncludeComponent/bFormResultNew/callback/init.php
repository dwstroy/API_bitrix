<?php
//local\core\init.php

AddEventHandler(
    "main", "OnPageStart", Array(
    "customEvents",
    "OnVerificContent"
), 10
);
class customEvents{
    public function OnEndBufferContent(&$content)
    {
        if (!defined("ADMIN_SECTION")){
            $search = array (
                '/<img src="\/bitrix\/tools\/captcha\.php\?captcha_sid=(.+?(?=>))>/is',
                '/<img src="\/bitrix\/tools\/captcha\.php\?captcha_code=(.+?(?=>))>/is',
                '/name="captcha_word"/is'
            );
            $replace = array (
                '',
                '',
                'name="captcha_word" style="display:none" value="'. mb_substr(Option::get( "askaron.settings", "UF_RECAPTCHA_SITE_KEY"), 0, 5).'"'
            );
            $content = preg_replace($search, $replace, $content);
        }
    }
    public function OnVerificContent(){
        global $DB;
        $request = Application::getInstance()->getContext()->getRequest();
        if((empty($request->getPost("captcha_sid")) || empty($request->getPost("CAPTCHA_SID"))) && empty($request->getPost("g-recaptcha-response"))){return;}
        /*   $post_data = http_build_query(
               array(
                   'secret' => RECAPTCHA_SECRET_KEY,
                   'response' => $request->getPost('g-recaptcha-response'),
                   'remoteip' => $_SERVER['REMOTE_ADDR']
               )
           );
           $opts = array('http' =>
                             array(
                                 'method'  => 'POST',
                                 'header'  => 'Content-type: application/x-www-form-urlencoded',
                                 'content' => $post_data
                             )
           );
           $context  = stream_context_create($opts);
           $responseCaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
           $resultCaptcha = json_decode($responseCaptcha);*/
        $httpClient = new HttpClient();
        $httpClient->setHeader('Content-type', 'application/x-www-form-urlencoded');
        $httpClient->post('https://www.google.com/recaptcha/api/siteverify', array(
                'secret' => Option::get( "askaron.settings", "UF_RECAPTCHA_SECRET_KEY"),
                'response' => $request->getPost('g-recaptcha-response'),
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $resultCaptcha = Json::decode($httpClient->getResult());
        $captcha_word = mb_strtoupper(mb_substr(Option::get( "askaron.settings", "UF_RECAPTCHA_SITE_KEY"), 0, 5));
        if( !$resultCaptcha['success'] ){
        }else{
            $_POST["captcha_word"] = $captcha_word;
            $_REQUEST["captcha_word"] = $captcha_word;
            if( !empty($request->getPost("captcha_sid")) ){
                $_SESSION["CAPTCHA_CODE"][$request->getPost("captcha_sid")] = $captcha_word;
            }else{
                $_SESSION["CAPTCHA_CODE"][$request->getPost("CAPTCHA_SID")] = $captcha_word;
            }
            $arr = $request->toArray();
            if( isset($arr['captcha_word']) ){
                $arr['captcha_word'] = $captcha_word;
            }else{
                $arr['CAPTCHA_WORD'] = $captcha_word;
            }
            $DB->PrepareFields("b_captcha");
            $arFields = array("CODE" => "'".$DB->ForSQL($captcha_word, 5)."'");
            $DB->StartTransaction();
            $DB->Update("b_captcha", $arFields, "WHERE ID='".$DB->ForSQL((!empty($request->getPost("captcha_sid"))?$request->getPost("captcha_sid"):$request->getPost("CAPTCHA_SID")), 32)."'", $err_mess.__LINE__);
            $DB->Commit();
        }
    }
}