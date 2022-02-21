<?

namespace Dwstroy\Core;

use Bitrix\Main\EventManager;

class DwsEvents
{
    /**
     * Регистрация обработчиков событий
     */
    public static function register()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->addEventHandler("main", "OnEpilog", array("\Dwstroy\Core\DwsHelper", "canonical"));
    }

}
