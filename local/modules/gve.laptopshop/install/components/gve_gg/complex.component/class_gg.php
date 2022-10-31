<?php


//    local/components/testComp/news.listt/class.php
    #local/components/example/testing.my.component/class.php

    use Bitrix\Main\Entity\ExpressionField;
    use Bitrix\Main\Error;
    use Bitrix\Main\ErrorCollection;
    use Bitrix\Main\Type\DateTime;


    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
        die();
    }

    class NewsListt extends \CBitrixComponent implements \Bitrix\Main\Engine\Contract\Controllerable,
                                                         \Bitrix\Main\Errorable
    {
        /** @var ErrorCollection */
        protected $errorCollection;

        public function configureActions()
        {
            //если действия не нужно конфигурировать, то пишем просто так. И будет конфиг по умолчанию
            return [];
        }

        public function onPrepareComponentParams($arParams)
        {
            $this->errorCollection = new ErrorCollection();
            $this->arParams = $arParams;
            //подготовка параметров
            //Этот код **будет** выполняться при запуске аяксовых-действий
            return $arParams;
        }

        /**
         * @throws \Bitrix\Main\ObjectPropertyException
         * @throws \Bitrix\Main\SystemException
         * @throws \Bitrix\Main\ArgumentException
         */
        public function executeComponent()
        {
            //Внимание! Этот код **не будет** выполняться при запуске аяксовых-действий
            CModule::IncludeModule("iblock");
            //здесь можно использовать функции и классы модуля
            if ($this->startResultCache()) {
                $this->arResult = array(
                    "ID_RAND" => rand(1, 100)
                );
                $iblockId = $this->arParams['IBLOCK_ID'];
                // объект инфоблока
                $iblock = \Bitrix\Iblock\Iblock::wakeUp($iblockId);
                /* Тут какая-то логика по заполнению $this->arResult */


                /** @var \Bitrix\Iblock\Elements\EO_ElementApiClothes_Collection $elements */
//                    $elements = $iblock->getEntityDataClass()::getList([
//                        'select' => [
//                            'id',
//                            'NAME',
//                            'RAND',
//                        ],
//                        'limit' => 1,
//                        // Сортировка по случай ному значению
//                        'runtime' => [
//                            'RAND'=>[
//                                'data_type' => 'float',
//                                'expression' => ['RAND()']
//                            ]
//                        ],
//                        'order' => array('RAND'=>'ASC'),
//                    ])->fetchAll();


                $query = $iblock->getEntityDataClass()::query();
                $query->setSelect([
                    'ID',
                    'NAME',
                    'RAND',
                ]);
                $query->setLimit(1);
                $query->setFilter([]);
                $query->registerRuntimeField('RAND', [
                    'data_type' => 'float',
                    'expression' => ['RAND()']
                ]);
                if ($this->arParams["SHOW_VIEW"] === "Последний") {
                    $query->setOrder(['ID' => 'DESC']);
                } elseif ($this->arParams["SHOW_VIEW"] === "Случайно") {
                    $query->setOrder(['RAND' => 'ASC']);
                } else {
                    $query->setOrder(['ID' => 'ASC']);
                }
                $query->exec();
                $elements = $query->fetchAll();


                foreach ($elements as $item) {
//        dump($item);
                    $this->arResult['ITEM'] = $item;
                }

//                    $iterator = CIBlockElement::GetList(
//                        ["SORT" => "ASC"],
//                        ['=IBLOCK_ID' => $iblockId],
//                        false,
//                        false,
//                        ['ID', 'NAME'],
//
//                    );
//                    while ($arItem = $iterator->GetNext()) {
//                        $this->arResult['ITEMS'][] = $arItem;
//                    }

//
//                    while ($arItem = $iterator->GetNext()) {
//                        $this->arResult['ITEMS'][] = $arItem;
//                    }
                $objDateTime = new DateTime();


                $this->arResult['DATE_CACHE'] = $objDateTime->toString();
                $this->setResultCacheKeys(array(
                    "ITEM",
                    "DATE_CACHE",
                ));
                // Если выполнилось какое-то условие, то кешировать
                // данные не надо
                if (empty($this->arParams['KEY'])) {
                    // Если требуется отменить кеш
                    $this->AbortResultCache();
                    ShowError('Не установлен ключ');
                    return;
                }
                // Подключить шаблон вывода
                $this->IncludeComponentTemplate();
            }

            // Установить заголовок страницы с помощью отложенной
// функции
            if ($this->arParams['SET_TITLE'] === 'Y') {
                global $APPLICATION;
                $APPLICATION->SetTitle($this->arResult['ITEM']['NAME']);
            }
        }

        protected function listKeysSignedParameters()
        {
            //перечисляем те имена параметров, которые нужно использовать в аякс-действиях
            return [
                'CACHE_GROUPS',
                'CACHE_TIME',
                'CACHE_TYPE',
                'FIELDS_ELEMENT',
                'IBLOCK_ID',
                'IBLOCK_TYPE',
                'KEY',
                'SET_TITLE',
                'SHOW_VIEW',
            ];
        }


        //в параметр $person будут автоматически подставлены данные из REQUEST
        
        public function greetAction($person = 'guest', $dateRequest)
        {
            $this->arResult = array(
                "ID_RAND" => rand(1, 100)
            );

            CModule::IncludeModule("iblock");
            if ($this->startResultCache()) {

                $iblockId = $this->arParams['IBLOCK_ID'];
                $iblock = \Bitrix\Iblock\Iblock::wakeUp($iblockId);

                /** @var \Bitrix\Iblock\Elements\EO_ElementApiClothes_Collection $elements */
                $query = $iblock->getEntityDataClass()::query();
                $query->setSelect([
                    'ID',
                    'NAME',
                    'RAND',
                ]);
                $query->setLimit(1);
                $query->setFilter([]);
                $query->registerRuntimeField('RAND', [
                    'data_type' => 'float',
                    'expression' => ['RAND()']
                ]);
                if ($this->arParams["SHOW_VIEW"] === "Последний") {
                    $query->setOrder(['ID' => 'DESC']);
                } elseif ($this->arParams["SHOW_VIEW"] === "Случайно") {
                    $query->setOrder(['RAND' => 'ASC']);
                } else {
                    $query->setOrder(['ID' => 'ASC']);
                }
                $query->exec();
                $elements = $query->fetchAll();

                foreach ($elements as $item) {
                    $this->arResult['ITEM'] = $item;
                }

                $objDateTime = new DateTime();

                $this->arResult['DATE_CACHE'] = $objDateTime->toString();
                $this->setResultCacheKeys(array(
                    "ITEM",
                    "DATE_CACHE",
                ));

                if (empty($this->arParams['KEY'])) {
                    $this->AbortResultCache();
                    ShowError('Не установлен ключ');
                    return;
                }

                $this->endResultCache();
            }

            if ($this->arParams['SET_TITLE'] === 'Y') {
                global $APPLICATION;
                $APPLICATION->SetTitle($this->arResult['ITEM']['NAME']);
            }
            $obj2DateTime = Bitrix\Main\Type\DateTime::createFromTimestamp($dateRequest / 1000);
            $this->arResult['dateRequest'] = $obj2DateTime->format("d-m-Y H:i:s");
            return $this->arResult;
        }


        /**
         * Getting array of errors.
         * @return Error[]
         */
        public function getErrors()
        {
            return $this->errorCollection->toArray();
        }

        /**
         * Getting once error with the necessary code.
         * @param string $code Code of error.
         * @return Error
         */
        public function getErrorByCode($code)
        {
            return $this->errorCollection->getErrorByCode($code);
        }
    }
