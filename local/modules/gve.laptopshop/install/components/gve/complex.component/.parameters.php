<?

    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
        die();
    }
    /** @var array $arCurrentValues */

    if (!CModule::IncludeModule("iblock")) {
        return;
    }


// Список типов информационных блоков
    $arTypesEx = CIBlockParameters::GetIBlockTypes(array("-" => " "));


// Массив информационных блоков. Для списка
    $arIBlocks = array();

    $db_iblock = CIBlock::GetList(array("SORT" => "ASC"),
        array(
            "SITE_ID" => $_REQUEST["site"],
            "TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")
        ));

    while ($arRes = $db_iblock->Fetch()) {
        $arIBlocks[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];
    }


//$arSorts = array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
//$arSortFields = array(
//		"ID"=>GetMessage("T_IBLOCK_DESC_FID"),
//		"NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
//		"ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
//		"SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
//		"TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
//	);
//
//$arProperty_LNS = array();
//$rsProp = CIBlockProperty::GetList(array("sort"=>"asc", "name"=>"asc"), array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
//while ($arr=$rsProp->Fetch())
//{
//	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
//	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
//	{
//		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
//	}
//}
    $list_view = array(
        "Случайно" => "Случайно",
        "Последний" => "Последний"
    );

    // Расширения для выбираемого файла
    $ext = 'wmv,wma,flv,vp6,mp3,mp4,aac,jpg,jpeg,gif,png';

    $arComponentParameters = array(
        "GROUPS" => array(
            "BASE_SETTINGS" => array("NAME" => GetMessage("PC_GROUP_BASE_SETTINGS"), "SORT" => "100"),
            "SETTINGS" => array(
                "NAME" => "Грауппа Настройки параметров"
            ),
            "PARAMS" => array(
                "NAME" => "Группа Параметры"
            ),
        ),
        "PARAMETERS" => array(
//		"AJAX_MODE" => array(),
            "VARIABLE_ALIASES" => array(
                "SECTION_ID" => array("NAME" => GetMessage("BN_P_SECTION_ID_DESC")),
                "ELEMENT_ID" => array("NAME" => GetMessage("NEWS_ELEMENT_ID_DESC")),
            ),

            "SEF_MODE" => array(
                "list" => array(
                    "NAME" => "список производителей",
                    "DEFAULT" => "#SEF_FOLDER#",
                    "VARIABLES" => array("SEF_FOLDER"),
                ),
                "brand" => array(
                    "NAME" => "список моделей производителя",
                    "DEFAULT" => "/#SEF_FOLDER#/#BRAND#",
                    "VARIABLES" => array("SEF_FOLDER", "BRAND"),
                    "COLS" => "5",
                ),
                "model" => array(
                    "NAME" => "список ноутбуков модели",
                    "DEFAULT" => "/#SEF_FOLDER#/#BRAND#/#MODEL#",
                    "VARIABLES" => array("SEF_FOLDER","BRAND", "MODEL"),
                    "COLS" => "5",
                ),
                "element" => array(
                    "NAME" => "детальная страница ноутбука",
                    "DEFAULT" => "/#SEF_FOLDER#//detail/#NOTEBOOK#",
                    "VARIABLES" => array("SEF_FOLDER","NOTEBOOK"),
                    "COLS" => "5",
                ),
            ),

            "ELEMENT_COUNT" => array(
                "PARENT" => "BASE_SETTINGS",
                "NAME" => "Количество элементов на странице",
                "TYPE" => "STRING",
                "DEFAULT" => "5",
            ),

            "SET_TITLE" => array(
                "DEFAULT" => "Y",
            ),

            "IBLOCK_TYPE" => array(
                "PARENT" => "BASE",
                "NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
                "TYPE" => "LIST",
                "VALUES" => $arTypesEx,
                "DEFAULT" => "news",
                "REFRESH" => "Y",
            ),

            "IBLOCK_ID" => array(
                "PARENT" => "BASE",
                "NAME" => GetMessage("T_IBLOCK_DESC_LIST_ID"),
                "TYPE" => "LIST",
                "VALUES" => $arIBlocks,
                "DEFAULT" => '={$_REQUEST["ID"]}',
                "ADDITIONAL_VALUES" => "Y",
                "REFRESH" => "Y",
            ),

            "SHOW_VIEW" => array(
                "PARENT" => "PARAMS",
                "NAME" => 'Правило показа',
                "TYPE" => "LIST",
                "VALUES" => $list_view,
                "DEFAULT" => 'Случайно'

            ),

            "FIELDS_ELEMENT" => array(
                "PARENT" => "PARAMS",
                "NAME" => 'Поля элемента',
                "TYPE" => "TEXT",
                "DEFAULT" => 'NAME, ID'
            ),

            "CACHE_TIME" => array("DEFAULT" => "3600"),
        ),
    );













    //CIBlockParameters::AddPagerSettings(
    //	$arComponentParameters,
    //	GetMessage("T_IBLOCK_DESC_PAGER_NEWS"), //$pager_title
    //	true, //$bDescNumbering
    //	true, //$bShowAllParam
    //	true, //$bBaseLink
    //	$arCurrentValues["PAGER_BASE_LINK_ENABLE"]==="Y" //$bBaseLinkEnabled
    //);

    //CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);


    /*
        "код параметра" => array(
        "PARENT" => "код группы",  // если нет - ставится ADDITIONAL_SETTINGS
        "NAME" => "название параметра на текущем языке",
        "TYPE" => "тип элемента управления, в котором будет устанавливаться параметр",
        "REFRESH" => "перегружать настройки или нет после выбора (N/Y)",
        "MULTIPLE" => "одиночное/множественное значение (N/Y)",
        "VALUES" => "массив значений для списка (TYPE = LIST)",
        "ADDITIONAL_VALUES" => "показывать поле для значений, вводимых вручную (Y/N)",
        "SIZE" => "число строк для списка (если нужен не выпадающий список)",
        "DEFAULT" => "значение по умолчанию",
        "COLS" => "ширина поля в символах",
    ),
    */












































