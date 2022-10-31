<?php

    namespace Gve\Laptopshop\Orm\EntutyLaptopshop;

    use Bitrix\Main\Entity;
    use Bitrix\Main\Entity\IntegerField;
    use Bitrix\Main\Entity\Query\Join;
    use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
    use Bitrix\Main\ORM\Fields\Relations\Reference;
    use Bitrix\Main\Type;

    class NotebookTable extends \Bitrix\Main\ORM\Data\DataManager
    {
        public static function getTableName()
        {
            return 'gve_notebook';
        }

        public static function getObjectClass()
        {
            return Notebook::class;
        }

        public static function getCollectionClass()
        {
            return Notebooks::class;
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
                    'default_value' => ''
                ])),
                new Entity\StringField('YEAR', array(
                    'default_value' => '')),
                (new Entity\FloatField('PRICE')),
                (new IntegerField('MANUFACTURER_ID')),
                (new Reference(
                    'MANUFACTURER',
                    ManufacturerTable::class,
                    Join::on('this.MANUFACTURER_ID', 'ref.ID')
                ))
                    ->configureJoinType('left'),

                (new ManyToMany('OPTIONS', OptionTable::class))
                    ->configureTableName('gve_option_notebook')
                    ->configureLocalPrimary('ID', 'NOTEBOOK_ID')
                    ->configureLocalReference('NOTEBOOK')
                    ->configureRemotePrimary('ID', 'OPTION_ID')
                    ->configureRemoteReference('OPTION'),

                (new IntegerField('MODEL_ID')),
                (new Reference(
                    'MODEL',
                    ModelTable::class,
                    Join::on('this.MODEL_ID', 'ref.ID')
                ))
                    ->configureJoinType('left'),
            );
        }


        public static function getUfId()
        {
            return 'GVE_NOTEBOOK';
        }

        // Работает только с версии 20.5.500, у меня 20.0.1175
/*        public static function withActive(Query $query)
        {
            $query->where('=TITLE', 'Незнайка в стране чудес.');
        }*/

    }
