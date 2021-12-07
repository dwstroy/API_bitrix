<?php
// Добавляем новый шаблон json для компонента bitrix:form.result.new
//bitrix\templates\eshop_bootstrap_v4\components\bitrix\form.result.new\json\template.php


if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ){
    die();
}
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
ob_start();
if( $arResult[ "isUseCaptcha" ] == "Y" ){
    ?>
    <input type="hidden" name="captcha_sid" value="<?= htmlspecialcharsbx( $arResult[ "CAPTCHACode" ] ); ?>" />
    <input type="hidden" name="captcha_word" style="display:none" size="30" maxlength="50" value="" class="inputtext" />
    <?
}
$captcha = ob_get_clean();
if( $arResult["isFormNote"] == "Y" && empty($arResult["FORM_ERRORS"]) ){
    echo \Bitrix\Main\Web\Json::encode(array('STATUS' => 'success', 'MSG' => "<i class=\"icon-ok-sign\"></i> Ваша заявка принята", 'CAPTCHA' => $captcha));
}else{
    echo \Bitrix\Main\Web\Json::encode(array('STATUS' => 'error', 'MSG' => array_values($arResult['FORM_ERRORS']), 'CAPTCHA' => $captcha));
}