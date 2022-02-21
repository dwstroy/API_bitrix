<?

namespace Dwstroy;

use function explode;
use function implode;
use function is_array;
use function mb_substr;
use function str_replace;

class Autoload
{
    private $path;
    private $fullPath;
    private $loadFiles = [];

    public function __construct($path, $arPaths)
    {
        $this->path = $path;

        $this->fullPath = $_SERVER['DOCUMENT_ROOT'].$path;

        if (is_array($arPaths) && !empty($arPaths))
        {
            foreach ($arPaths as $path)
            {
                $this->loadPath($path);
            }
        }
    }

    /**
     * загружает файлы из указанной директории
     * @param $folder
     */
    private function loadPath($folder)
    {
        $directoryPath = $this->fullPath . '/' . $folder . '/';

        $obDir = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directoryPath));

        foreach ($obDir as $file)
        {
            if ($file != '.' && $file != '..' && $file->isFile())
            {
                $fileName = $file->getFilename();

                if (mb_substr($fileName, 0, 1) != '_' && mb_substr($fileName, -4) == '.php')
                {
                    $filePath = str_replace('\\', '/', $file->getPath()) . '/';
                    $prsNamespace = $this->getPSRNamespace(str_replace($directoryPath, '', $filePath));
                    $prsPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);
                    $className = $prsNamespace . '\\' . ucwords(str_replace('.php', '', $fileName));
                    $classPath = $prsPath . $fileName;
                    $this->loadFiles[$className] = $classPath;
                }
            }
        }
    }

    private function getPSRNamespace($pstPath)
    {
        $arResult = [
            __NAMESPACE__,
        ];

        $arTempPath = explode('/', $pstPath);

        $arTempPath = array_filter($arTempPath);

        if (!empty($arTempPath))
        {
            foreach ($arTempPath as $namespace)
            {
                $arResult[] = ucwords($namespace);
            }
        }

        unset($arTempPath);

        return implode('\\', $arResult);
    }

    /**
     * возвращает список загруженных файлов
     * @return array
     */
    public function getLoadedClass()
    {
        return $this->loadFiles;
    }
}