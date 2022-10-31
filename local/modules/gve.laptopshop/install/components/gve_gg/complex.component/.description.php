<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

    $arComponentDescription = array(
        "NAME" => GetMessage("COMP_NAME"),
        "DESCRIPTION" => GetMessage("COMP_DESCR"),
        "ICON" => "/images/icon.gif",
        "PATH" => array(
            "NAME" => 'GVE',
            "ID" => "gve_id",
            "CHILD" => array(
                "ID" => "complex.component",
                "NAME" => "Комплексный компонент"
            )
        ),
        "AREA_BUTTONS" => array(
            array(
                'URL' => "javascript:alert('Это кнопка!!!');",
                'SRC' => '/images/button.jpg',
                'TITLE' => "Это кнопка!"
            ),
        ),
        "CACHE_PATH" => "Y",
        "COMPLEX" => "Y"
    );

?>
