<?

namespace Dwstroy\Core;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\HttpRequest;
use \Bitrix\Main\IO\File;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Bitrix\Main\Page\Asset;
use ReflectionClass;

class DwsHelper {

    public function canonical(){
        global $APPLICATION;
        $canonical = $APPLICATION->GetPageProperty('canonical');
        if( empty($canonical) ){
            $APPLICATION->SetPageProperty('canonical', \CHTTP::URN2URI($APPLICATION->GetCurPage()));
        }elseif( strpos($canonical, \CHTTP::URN2URI('')) === false ){
            $APPLICATION->SetPageProperty('canonical', \CHTTP::URN2URI($canonical));
        }
    }

}


?>