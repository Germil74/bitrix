<?php
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    global $APPLICATION;

    $cp = $this->__component; // объект компонента

    if (is_object($cp))
    {
        // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
        $cp->arResult['MY_TITLE'] = 'Мое название';
        $cp->arResult['IS_OBJECT'] = 'Y';
        $cp->SetResultCacheKeys(array('MY_TITLE','IS_OBJECT'));

        $APPLICATION->SetTitle($cp->arResult['MY_TITLE']); // не будет работать на каждом хите:
//отработает только первый раз, затем будет все браться из кеша и вызова $APPLICATION->SetTitle()
// не будет. Поэтому изменение title делается в component_epilog, который выполняется на каждом хите.

    }
?>
