<?
use CModule;
use Dwstroy\Autoload;
use Dwstroy\Core\DwsEvents;
use Bitrix\Main\Application;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Json;
use \Bitrix\Main\Config\Option;

require_once('classAutoload.php');

$arLoadPaths = [
    'classes',
];

$obAutoload = new Autoload('/local/core', $arLoadPaths);
$arLoadedFiles = $obAutoload->getLoadedClass();
CModule::AddAutoloadClasses("", $arLoadedFiles);

// регистрация событий
DwsEvents::register();


AddEventHandler(
    "main", "OnPageStart", Array(
    "customEvents",
    "OnVerificContent"
), 10
);