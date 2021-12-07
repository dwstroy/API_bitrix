<?php
//Переходим на страницу и размещаем компонент Веб-форм bitrix:form.result.new
//В настройках компонента указываем ID формы и создаём копию с названием "callback"
?>

<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "callback", Array(
    "CACHE_TIME" => "3600",	// Время кеширования (сек.)
    "CACHE_TYPE" => "A",	// Тип кеширования
    "CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
    "CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
    "EDIT_URL" => "",	// Страница редактирования результата
    "IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
    "LIST_URL" => "",	// Страница со списком результатов
    "SEF_MODE" => "N",	// Включить поддержку ЧПУ
    "SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
    "USE_EXTENDED_ERRORS" => "Y",	// Использовать расширенный вывод сообщений об ошибках
    "WEB_FORM_ID" => "3",	// ID веб-формы
    "COMPONENT_TEMPLATE" => ".default",
    "VARIABLE_ALIASES" => array(
        "WEB_FORM_ID" => "CALLBACK",
        "RESULT_ID" => "RESULT_ID",
    )
),
    false
);?>