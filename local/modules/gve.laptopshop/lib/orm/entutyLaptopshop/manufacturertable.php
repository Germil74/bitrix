<?php

    namespace Gve\Laptopshop\Orm\EntutyLaptopshop;

    use Bitrix\Main\Entity;
    use Bitrix\Main\Entity\IntegerField;
    use Bitrix\Main\Entity\Query\Join;
    use Bitrix\Main\ORM\Fields\Relations\OneToMany;

    class ManufacturerTable extends \Bitrix\Main\ORM\Data\DataManager
    {
        public static function getTableName()
        {
            return 'gve_manufacturer';
        }

        public static function getObjectClass()
        {
            return Manufacturer::class;
        }


        /**
         * @throws \Bitrix\Main\SystemException
         */
        public static function getMap()
        {
            return array(
                new Entity\IntegerField('ID', array(
                    'primary' => true,
                    'autocomplete' => true
                )),

                (new Entity\StringField('NAME', [
                    'default_value' => null
                ])),
                (new OneToMany(
                    'MODELS',
                    ModelTable::class,
                    'MANUFACTURER'
                ))
                    ->configureJoinType('inner'),
                (new Entity\ExpressionField(
                    'MODELS_COUNT',
                    'COUNT(%s)',
                    [

                        'ID'

                    ]
                )),
            );

//            (new ExpressionField(
//                'ANALOGS',
//                '%s',
//                array('PRODUCT_ID'),
//                array(
//                    'data_type' => '\Bitrix\Main\ORM\Fields\ArrayField',
//                    'title' => Loc::getMessage('CART_PRODUCT_ANALOGS'),
//                    'fetch_data_modification' => function () {
//                        return array(
//                            function ($value, $query, $data, $alias) {
//                                if ($value) {
//                                    $value = static::getAnalogsFromIblock($value);
//                                }
//                                return $value;
//                            }
//                        );
//                    }
//                )
//            )),

        }


        public static function getUfId()
        {
            return 'GVE_MANUFACTURER';
        }

    }
