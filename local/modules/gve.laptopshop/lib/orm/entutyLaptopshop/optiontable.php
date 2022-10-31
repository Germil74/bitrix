<?php

    namespace Gve\Laptopshop\Orm\EntutyLaptopshop;

    use Bitrix\Main\Entity;
    use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

    class OptionTable extends \Bitrix\Main\ORM\Data\DataManager
    {
        public static function getTableName()
        {
            return 'gve_option';
        }

        public static function getObjectClass()
        {
            return Option::class;
        }

        public static function getCollectionClass()
        {
            return Options::class;
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
                (new ManyToMany('NOTEBOOKS', NotebookTable::class))
                    ->configureTableName('gve_option_notebook')
                    ->configureLocalPrimary('ID', 'OPTION_ID')
                    ->configureLocalReference('OPTION')
                    ->configureRemotePrimary('ID', 'NOTEBOOK_ID')
                    ->configureRemoteReference('NOTEBOOK'),

                (new ManyToMany('MODELS', ModelTable::class))
                    ->configureTableName('gve_option_model')
                    ->configureLocalPrimary('ID', 'OPTION_ID')
                    ->configureLocalReference('OPTION')
                    ->configureRemotePrimary('ID', 'MODEL_ID')
                    ->configureRemoteReference('MODEL')
            );
        }


        public static function getUfId()
        {
            return 'GVE_BOOK';
        }

        // Работает только с версии 20.5.500, у меня 20.0.1175
        /*        public static function withActive(Query $query)
                {
                    $query->where('=TITLE', 'Незнайка в стране чудес.');
                }*/

    }
