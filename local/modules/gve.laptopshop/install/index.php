<?

    use Bitrix\Main\Localization\Loc;
    use Bitrix\Main\ModuleManager;
    use Bitrix\Main\Config\Option;
    use Bitrix\Main\EventManager;
    use Bitrix\Main\Application;
    use Bitrix\Main\IO\Directory;
    use Bitrix\Main\IO\File;
    use Gve\Laptopshop\Orm\EntutyLaptopshop\ManufacturerTable;
    use Gve\Laptopshop\Orm\EntutyLaptopshop\ModelTable;
    use Gve\Laptopshop\Orm\EntutyLaptopshop\NotebookTable;
    use Gve\Laptopshop\Orm\EntutyLaptopshop\OptionTable;
    use Bitrix\Main\Diag\Debug;
    Loc::loadMessages(__FILE__);

    class gve_laptopshop extends CModule
    {
        public $MODULE_ID = 'gve.laptopshop';
        public $MODULE_VERSION;
        public $MODULE_VERSION_DATE;
        public $MODULE_NAME;
        public $MODULE_DESCRIPTION;

        public function __construct()
        {
            if (file_exists(__DIR__ . "/version.php")) {
                $arModuleVersion = [];
                include __DIR__ . '/version.php';

                $this->MODULE_ID = str_replace("_", ".", get_class($this));
                $this->MODULE_VERSION = $arModuleVersion["VERSION"];
                $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

                $this->MODULE_NAME = Loc::getMessage('LAPTOPSHOP_NAME');
                $this->MODULE_DESCRIPTION = Loc::getMessage('LAPTOPSHOP_MODULE_DESCRIPTION');
                $this->PARTNER_NAME = Loc::getMessage("LAPTOPSHOP_PARTNER_NAME");
                $this->PARTNER_URI = Loc::getMessage("LAPTOPSHOP_PARTNER_URI");
            }
        }

        public function DoInstall()
        {
            global $APPLICATION;

            if (CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
                ModuleManager::registerModule($this->MODULE_ID);
                $this->InstallDB();
                $this->InstallFiles();
                $this->InstallEvents();
            } else {
                $APPLICATION->ThrowException(Loc::getMessage("LAPTOPSHOP_ERROR_VERSION"));
            }

            $APPLICATION->IncludeAdminFile(
                Loc::getMessage("LAPTOPSHOP_INSTALL_TITLE") . " \"" . Loc::getMessage("LAPTOPSHOP_NAME") . "\"",
                __DIR__ . "/step.php"
            );

            return false;
        }

        public function InstallFiles()
        {
            require_once Application::getDocumentRoot() . '/local/modules/gve.laptopshop/install/data/initDataTable.php';

            CopyDirFiles(
                Application::getDocumentRoot()."/local/modules/gve.laptopshop/install/components/gve/",
                Application::getDocumentRoot() ."/bitrix/components/gve/", true, true);


            return false;
        }

        public function InstallDB()
        {
            if (\Bitrix\Main\Loader::includeModule($this->MODULE_ID)) {
                $conection = Application::getConnection();
                ManufacturerTable::getEntity()->createDbTable();
                ModelTable::getEntity()->createDbTable();
                NotebookTable::getEntity()->createDbTable();
                OptionTable::getEntity()->createDbTable();
                if(!($conection->isTableExists('gve_option_notebook') || $conection->isTableExists('gve_option_notebook'))) {
                    $fileSql = File::getFileContents(Application::getDocumentRoot() . '/local/modules/gve.laptopshop/install/sql/many.sql');
                    $conection->executeSqlBatch($fileSql);
                }
//                Debug::writeToFile($res);
            }

            return false;
        }

        public function InstallEvents()
        {
            EventManager::getInstance()->registerEventHandler(
                "iblock",
                "OnAfterIblockElementAdd",
                $this->MODULE_ID,
                "MyModuleClass",
                "CheckData"
            );

            return false;
        }

        public function DoUninstall()
        {
            global $APPLICATION;

            $this->UnInstallFiles();
            $this->UnInstallEvents();
            $this->UnInstallDB();
            ModuleManager::unRegisterModule($this->MODULE_ID);

            $APPLICATION->IncludeAdminFile(
                Loc::getMessage("LAPTOPSHOP_UNINSTALL_TITLE") . " \"" . Loc::getMessage("LAPTOPSHOP_NAME") . "\"",
                __DIR__ . "/unstep.php"
            );

            return false;
        }

        public function UnInstallFiles()
        {
            Directory::deleteDirectory(Application::getDocumentRoot()."/bitrix/components/gve/");
            return false;
        }

        public function UnInstallDB()
        {
            $connection = \Bitrix\Main\Application::getConnection();
            if (\Bitrix\Main\Loader::includeModule($this->MODULE_ID)) {
                $connection->dropTable('gve_option_notebook');
                $connection->dropTable('gve_option_model');
                $connection->dropTable(ManufacturerTable::getTableName());
                $connection->dropTable(ModelTable::getTableName());
                $connection->dropTable(NotebookTable::getTableName());
                $connection->dropTable(OptionTable::getTableName());

            }

            return false;
        }

        public function UnInstallEvents()
        {
            EventManager::getInstance()->unRegisterEventHandler(
                "iblock",
                "OnAfterIblockElementAdd",
                $this->MODULE_ID,
                "MyModuleClass",
                "CheckData"
            );

            return false;
        }
    }

?>
