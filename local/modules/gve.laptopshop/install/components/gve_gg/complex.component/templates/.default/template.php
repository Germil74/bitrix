<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?= '<pre>' ?>
<?php //dump($arParams);?>
<?php //dump($arResult);?>
<?= '</pre>' ?>


<ul id="component_id">
  <li><?= $arResult['ITEM']['ID'];?></li>
  <li><?= $arResult['ITEM']['NAME'];?></li>
</ul>

<a id="component_id_link" href="#">Обновить</a>
<!--<a href="">Обновить</a>-->
<!---->
<!--<ul>-->
<!--  <li>ID</li>-->
<!--  <li>NAME</li>-->
<!--  <li>Дата запроса: 01/01/2020 00:00:00</li>-->
<!--  <li>Дата кеша: 31/12/2019 23:59:59</li>-->
<!--</ul>-->


<script type="text/javascript">
  BX.ready(function(){
    BX.NewsListt.create('component_id',
      {
        signedParameters: '<?= $this->getComponent()->getSignedParameters() ?>',
        componentName: '<?= $this->getComponent()->getName() ?>'
      }
    );
  });


</script>













<!--<div class="news-list">-->
<?//if($arParams["DISPLAY_TOP_PAGER"]):?>
<!--	--><?//=$arResult["NAV_STRING"]?><!--<br />-->
<?//endif;?>
<?//foreach($arResult["ITEMS"] as $arItem):?>
<!--	--><?//
//	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
//	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
//	?>
<!--	<p class="news-item" id="--><?//=$this->GetEditAreaId($arItem['ID']);?><!--">-->
<!--		--><?//if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
<!--			--><?//if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
<!--				<a href="--><?//=$arItem["DETAIL_PAGE_URL"]?><!--"><img-->
<!--						class="preview_picture"-->
<!--						border="0"-->
<!--						src="--><?//=$arItem["PREVIEW_PICTURE"]["SRC"]?><!--"-->
<!--						width="--><?//=$arItem["PREVIEW_PICTURE"]["WIDTH"]?><!--"-->
<!--						height="--><?//=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?><!--"-->
<!--						alt="--><?//=$arItem["PREVIEW_PICTURE"]["ALT"]?><!--"-->
<!--						title="--><?//=$arItem["PREVIEW_PICTURE"]["TITLE"]?><!--"-->
<!--						style="float:left"-->
<!--						/></a>-->
<!--			--><?//else:?>
<!--				<img-->
<!--					class="preview_picture"-->
<!--					border="0"-->
<!--					src="--><?//=$arItem["PREVIEW_PICTURE"]["SRC"]?><!--"-->
<!--					width="--><?//=$arItem["PREVIEW_PICTURE"]["WIDTH"]?><!--"-->
<!--					height="--><?//=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?><!--"-->
<!--					alt="--><?//=$arItem["PREVIEW_PICTURE"]["ALT"]?><!--"-->
<!--					title="--><?//=$arItem["PREVIEW_PICTURE"]["TITLE"]?><!--"-->
<!--					style="float:left"-->
<!--					/>-->
<!--			--><?//endif;?>
<!--		--><?//endif?>
<!--		--><?//if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
<!--			<span class="news-date-time">--><?//echo $arItem["DISPLAY_ACTIVE_FROM"]?><!--</span>-->
<!--		--><?//endif?>
<!--		--><?//if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
<!--			--><?//if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
<!--				<a href="--><?//echo $arItem["DETAIL_PAGE_URL"]?><!--"><b>--><?//echo $arItem["NAME"]?><!--</b></a><br />-->
<!--			--><?//else:?>
<!--				<b>--><?//echo $arItem["NAME"]?><!--</b><br />-->
<!--			--><?//endif;?>
<!--		--><?//endif;?>
<!--		--><?//if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
<!--			--><?//echo $arItem["PREVIEW_TEXT"];?>
<!--		--><?//endif;?>
<!--		--><?//if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
<!--			<div style="clear:both"></div>-->
<!--		--><?//endif?>
<!--		--><?//foreach($arItem["FIELDS"] as $code=>$value):?>
<!--			<small>-->
<!--			--><?//=GetMessage("IBLOCK_FIELD_".$code)?><!--:&nbsp;--><?//=$value;?>
<!--			</small><br />-->
<!--		--><?//endforeach;?>
<!--		--><?//foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
<!--			<small>-->
<!--			--><?//=$arProperty["NAME"]?><!--:&nbsp;-->
<!--			--><?//if(is_array($arProperty["DISPLAY_VALUE"])):?>
<!--				--><?//=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
<!--			--><?//else:?>
<!--				--><?//=$arProperty["DISPLAY_VALUE"];?>
<!--			--><?//endif?>
<!--			</small><br />-->
<!--		--><?//endforeach;?>
<!--	</p>-->
<?//endforeach;?>
<?//if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
<!--	<br />--><?//=$arResult["NAV_STRING"]?>
<?//endif;?>
<!--</div>-->
