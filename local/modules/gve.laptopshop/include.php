<?
use Bitrix\Main\Loader;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Iblock;
use Bitrix\Main\User;
Loc::loadMessages(__FILE__);

class MyModuleClass {

    const MODULE_ID = 'gve.laptopshop';

    public static function CheckData(&$arArgs) {

        //get All options
        $arOptions = Option::getForModule(self::MODULE_ID);
        $flag=0;



        if ($arOptions['CheckboxField']) {
           /* global $USER;
            AddMessage2Log($arArgs, "myname.module");

            $el = new CIBlockElement;

            $arEl = Array(
              "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
              "CODE" => time(),          // элемент лежит в корне раздела
              );
            $res = $el->Update($arArgs['ID'], $arEl);*/

        }
        return $flag;
    }
}



    $kernelDir = Bitrix\Main\IO\Directory::isDirectoryExists($_SERVER['DOCUMENT_ROOT'] . '/local') ? '/local' : '/bitrix';
    $jsPath = "$kernelDir/js/gve/laptopshop/main";
//var_dump($jsPath);
    $js = [
        'laptopshop' => [
            'js' => "$jsPath/test.js",
        ],
    ];

    foreach ($js as $key => $value) {
//        var_dump("$key $value");
        \CJSCore::RegisterExt($key, $value);
    }
?>
