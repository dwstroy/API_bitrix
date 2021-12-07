<?php
// Добавляем файл для обработки формы на ajax
//ajax\form.result.new.php

define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('DisableEventsCheck', true);
define('BX_SECURITY_SHOW_MESSAGE', true);
$siteId = isset($_REQUEST['SITE_ID']) && is_string($_REQUEST['SITE_ID']) ? $_REQUEST['SITE_ID'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
$LanguageId = isset($_REQUEST['LANGUAGE_ID']) && is_string($_REQUEST['LANGUAGE_ID']) ? $_REQUEST['LANGUAGE_ID'] : '';
$LanguageId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId))
{
    define('SITE_ID', $siteId);
}
if (!empty($LanguageId) && is_string($LanguageId))
{
    define('LANGUAGE_ID', $LanguageId);
}
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);
if( !$request->isPost() && $request->get('formresult') == 'addok' && !empty($_SESSION['form_params']['form.result.new'])){
    $params = $_SESSION['form_params']['form.result.new'];
    //echo \Bitrix\Main\Web\Json::encode(array('STATUS' => 'success', 'MSG' => 'Форма успешно отправлена'));
}else{
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    try
    {
        $params = $signer->unsign($request->get('signedParamsString'), 'form.result.new');
        $params = unserialize(base64_decode($params));
    }
    catch (\Bitrix\Main\Security\Sign\BadSignatureException $e)
    {
        die();
    }
    $_SESSION['form_params']['form.result.new'] = $params;
}
$APPLICATION->IncludeComponent("bitrix:form.result.new", "json", $params, false );
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');