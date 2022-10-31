<?

/**
 * CControllerClient::GetInstalledOptions($module_id);
 * формат массива, элементы:
 * 1) ID опции (id инпута)(Берется с помощью COption::GetOptionString($module_id, $Option[0], $Option[2]) если есть)
 * 2) Отображаемое имя опции
 * 3) Значение по умолчанию (так же берется если первый элемент равен пустой строке), зависит от типа:
 *      checkbox - Y если выбран
 *      text/password - htmlspecialcharsbx($val)
 *      selectbox - одно из значений, указанных в массиве опций
 *      multiselectbox - значения через запятую, указанные в массиве опций
 * 4) Тип поля (массив)
 *      1) Тип (multiselectbox, textarea, statictext, statichtml, checkbox, text, password, selectbox)
 *      2) Зависит от типа:
 *         text/password - атрибут size
 *         textarea - атрибут rows
 *         selectbox/multiselectbox - массив опций формата ["Значение"=>"Название"]
 *      3) Зависит от типа:
 *         checkbox - доп атрибут для input (просто вставляется строкой в атрибуты input)
 *         textarea - атрибут cols
 *
 *      noautocomplete) для text/password, если true то атрибут autocomplete="new-password"
 *
 * 5) Disabled = 'Y' || 'N';
 * 6) $sup_text - ??? текст маленького красного примечания над названием опции
 * 7) $isChoiceSites - Нужно ли выбрать сайт??? флаг Y или N
 */


use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

//For paid modules only BEGIN
$isExpired = CModule::IncludeModuleEx($module_id);
if ($isExpired != 3) {
//For paid modules only END    
    
    //GET SELECT BOX VALUES
    $arSelect = array(
        'KEY_1' => 'VAL_1',
        'KEY_2' => 'VAL_2',
        'KEY_3' => 'VAL_3'
    );
    
    $aTabs = array(
    	array(
    		"DIV" 	  => "edit",
    		"TAB" 	  => Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_COMMON"),
    		"TITLE"   => Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_NAME"),
    		"OPTIONS" => array(
    			Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_COMMON"),
    			array(
    				"CheckboxField",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_CHECKBOX"),
    				"N",
    				array("checkbox")
    			),
                array(
    				"StringField",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_STRING"),
    				'Example',
    				array("text",40)
    			),
                array(
    				"SelectField",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_SELECT"),
    				'NONE',
    				array("selectbox",$arSelect)
    			),
                array(
    				"StaticTextField",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_STATICTEXT"),
    				'STATIC TEXT VALUE',
    				array("statictext")
    			),
                array(
    				"StaticHtmlField",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_STATICHTML"),
    				'STATIC <b>HTML</b> <a href="#">VALUE</a>',
    				array("statichtml")
    			),
                array(
    				"MultiSelectField",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_MULTISELECT"),
    				'NONE',
    				array("multiselectbox",$arSelect)
    			),
                array(
    				"TextareaField",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_TEXTAREA"),
    				'Textarea value text here',
    				array("textarea",10,70)
    			),
                array("note"=>Loc::getMessage("MYNAME_MODULE_OPTIONS_TAB_MESSAGE")),
                Loc::getMessage("MYNAME_MODULE_OPTIONS_DEV"),
                array(
    				"developer",
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_SUPPORT"),
    				Loc::getMessage("MYNAME_MODULE_OPTIONS_SUPPORT_DATA"),
    				array("statichtml")
    			),                
    		)
    	)
    );
    
    if($request->isPost() && check_bitrix_sessid()){
    
    	foreach($aTabs as $aTab){
    
    		foreach($aTab["OPTIONS"] as $arOption){
    
    			if(!is_array($arOption)){
    
    				continue;
    			}
    
    			if($arOption["note"]){
    
    				continue;
    			}
    
    			if($request["apply"]){
    
    				$optionValue = $request->getPost($arOption[0]);
    
    				if($arOption[0] == "switch_on"){
    
    					if($optionValue == ""){
    
    						$optionValue = "N";
    					}
    				}
    
    				Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
    			}elseif($request["default"]){
    
    				Option::set($module_id, $arOption[0], $arOption[2]);
    			}
    		}
    	}
    
    	LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG);
    }
    
    
    $tabControl = new CAdminTabControl(
    	"tabControl",
    	$aTabs
    );
    
    $tabControl->Begin();
    ?>
    <form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post" id="setparams">
    
    	<?
    	foreach($aTabs as $aTab){
    
    		if($aTab["OPTIONS"]){
    
    			$tabControl->BeginNextTab();
    
    			__AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
    		}
    	}
    
    	$tabControl->Buttons();
    	?>
    	<input type="submit" name="apply" value="<? echo(Loc::GetMessage("MYNAME_MODULE_OPTIONS_APPLY")); ?>" class="adm-btn-save" />
    	<?
    	echo(bitrix_sessid_post());
    	?>
    
    </form>
    <?
    $tabControl->End();
    ?>
<? //For paid modules only BEGIN ?>   
<? } else {
        echo Loc::GetMessage("MYNAME_MODULE_EXPIRED");
    }
?>    
<? //For paid modules only END ?>