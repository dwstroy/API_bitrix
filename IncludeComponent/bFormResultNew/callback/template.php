<?php
// Кастомизируем шаблон

//bitrix\templates\eshop_bootstrap_v4\components\bitrix\form.result.new\callback\template.php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Config\Option;
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedParams = $signer->sign( base64_encode( serialize( $arParams ) ), 'form.result.new' );
$arResult[ "FORM_HEADER" ] = preg_replace( "/(<form.*?)>(.*)/s", '$1  data-back="formResultCallBack" class="form js-ajax_form"> $2', $arResult[ "FORM_HEADER" ] );
$arResult[ "FORM_HEADER" ] = preg_replace( "/action=[\'\"](.*?)[\'\"]/s", 'action="'.SITE_DIR.'ajax/form.result.new.php"', $arResult[ "FORM_HEADER" ] );
?>
<?if ($arResult["isFormNote"] != "Y"):?>
    <div class="portfolio-ajax-modal ajax-modal-max-450">
        <div class="ajax-modal-title">
            <h2>Заказать обратный звонок</h2>
        </div>
        <div class="modal-padding">
            <div id="contact-form-result-L9nefh" data-notify-type="success"
                 data-notify-msg="<i class=icon-ok-sign></i> "></div>
            <?=$arResult["FORM_HEADER"]?>
            <input type="hidden" name="SITE_ID" value="<?= SITE_ID ?>">
            <input type="hidden" name="signedParamsString" value="<?= $signedParams ?>">
            <div class="response alert"></div>
            <?foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):?>
                <?if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'):?>
                    <?= $arQuestion["HTML_CODE"];?>
                <?else:?>
                    <div class="col_full">
                        <label>
                            <?= $arQuestion[ "CAPTION" ] ?>
                            <?if( $arQuestion[ "REQUIRED" ] == "Y" ):?>
                                <span class="starrequired">*</span>
                            <?endif;?>
                        </label>
                        <?= $arQuestion[ "HTML_CODE" ] ?>
                    </div>
                <?endif;?>
            <?endforeach;?>
            <div class="captcha_container">
                <?if( $arResult[ "isUseCaptcha" ] == "Y" ):?>
                    <input type="hidden" name="captcha_sid"
                           value="<?= htmlspecialcharsbx( $arResult[ "CAPTCHACode" ] ); ?>"/>
                    <input type="hidden" name="captcha_word" size="30"
                           maxlength="50" value=""/>
                <?endif;?>
            </div>
            <div class="col_full">
                <input id="agreecheckboxL9nefh" class="checkbox-style"
                       type="checkbox" required name="agreement"
                       value="Y"
                       checked="checked">
                <label class="checkbox-style-3-label checkbox-small"
                       for="agreecheckboxL9nefh">
                    Я согласен на <a target="_blank" href="#">обработку
                        персональных данных</a> </label>
            </div>
            <div class="col_full">
                <input type="hidden" name="web_form_submit" value="Y">
                <input id="md-button-send-form"
                       class="button noleftmargin form__button-send" <?= (intval( $arResult[ "F_RIGHT" ] ) < 10 ? "disabled=\"disabled\"" : ""); ?>
                       type="submit"
                       name="web_form_submit"
                       value="<?= htmlspecialcharsbx( trim( $arResult[ "arForm" ][ "BUTTON" ] ) == '' ? GetMessage( "FORM_ADD" ) : $arResult[ "arForm" ][ "BUTTON" ] ); ?>"/>
            </div>
            <?=$arResult["FORM_FOOTER"]?>
        </div>
    </div>
<?endif;?>
<script>
    BX.message({
        RECAPTCHA_SITE_KEY: '<?=Option::get( "askaron.settings", "UF_RECAPTCHA_SITE_KEY")?>',
    });
</script>
<script src="https://www.google.com/recaptcha/api.js?render=<?=Option::get( "askaron.settings", "UF_RECAPTCHA_SITE_KEY")?>"></script>