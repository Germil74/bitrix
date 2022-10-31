<?php

    namespace Gve\Laptopshop\Orm\EntutyLaptopshop;

    use Bitrix\Main\Entity;
    use Bitrix\Main\Entity\IntegerField;
    use Bitrix\Main\Entity\Query\Join;
    use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
    use Bitrix\Main\ORM\Fields\Relations\OneToMany;
    use Bitrix\Main\ORM\Fields\Relations\Reference;

    class ModelTable extends \Bitrix\Main\ORM\Data\DataManager
    {
        public static function getTableName()
        {
            return 'gve_model';
        }

        public static function getObjectClass()
        {
            return Model::class;
        }

        public static function getCollectionClass()
        {
            return Models::class;
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

                (new IntegerField('MANUFACTURER_ID')),

                (new Reference(
                    'MANUFACTURER',
                    ManufacturerTable::class,
                    Join::on('this.MANUFACTURER_ID', 'ref.ID')
                ))->configureJoinType('inner'),

                (new ManyToMany('OPTIONS', OptionTable::class))
                    ->configureTableName('gve_option_model')
                    ->configureLocalPrimary('ID', 'MODEL_ID')
                    ->configureLocalReference('MODEL')
                    ->configureRemotePrimary('ID', 'OPTION_ID')
                    ->configureRemoteReference('OPTION'),
                (new OneToMany(
                    'NOTEBOOKS',
                    NotebookTable::class,
                    'MODEL'
                ))->configureJoinType('inner'),


            );
        }


        public static function getUfId()
        {
            return 'GVE_MODEL';
        }

        // Работает только с версии 20.5.500, у меня 20.0.1175
/*        public static function withActive(Query $query)
        {
            $query->where('=TITLE', 'Незнайка в стране чудес.');
        }*/

    }
