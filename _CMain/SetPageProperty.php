<?
//Получаем свойства страницы в header
//в место require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


// использовать
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");

// Такая запись позволит нам сделать какие-то действия на странице, до отображения визуальной части (до запуска header.php активного шаблона сайта), например установка свойств страницы.
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetPageProperty("dws_cities", "Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_after.php");

// Используя подобную запись можно обращаться к свойствам страницы из header.php напрямую, а не только с помощью отложенных функций.
$dws_cities = $APPLICATION->GetProperty("dws_cities");
if ($dws_cities == "Y") {
    // Если есть переменная то выводим данные
}