<?php
    use Gve\Laptopshop\Orm\EntutyLaptopshop\ManufacturerTable;
    use Gve\Laptopshop\Orm\EntutyLaptopshop\ModelTable;
    use Gve\Laptopshop\Orm\EntutyLaptopshop\NotebookTable;
    use Gve\Laptopshop\Orm\EntutyLaptopshop\OptionTable;
    $arrayOptions = [
        [ 'ID' => 1, 'NAME' => 'Процессор'],
        [ 'ID' => 2, 'NAME' => 'Диагональ экрана'],
        [ 'ID' => 3, 'NAME' => 'Видеокарта'],
        [ 'ID' => 4, 'NAME' => 'Графическая карта память'],
        [ 'ID' => 5, 'NAME' => 'Тип матрицы'],
        [ 'ID' => 6, 'NAME' => 'Количество ядер']
    ];
    $arrayEntity = [
        [
            'NAME' => 'Acer',
            'MODELS' => [
                [
                    'NAME' => 'Acer Aspire 3',
                    'NOTEBOOKS' => [
                        [
                            'NAME' => 'Ноутбук Acer Aspire 3 i5-1135G7/12GB/512/Win11 IPS silver (A315-58 || NX.ADDEP.01M)',
                            'YEAR' => '2015',
                            'PRICE' => '49560',
                            'OPTIONS' => [
                                1,
                                2,
                                3,
                                4,
                            ],
                        ],
                        [
                            'NAME' => 'Ноутбук Acer Aspire 3 R5-3500U/8GB/512 IPS (A315-23 || NX.HVTEP.010)',
                            'YEAR' => '2017',
                            'PRICE' => '52326',
                            'OPTIONS' => [
                                1,
                                2,
                                3,
                                4,
                            ],
                        ],
                        [
                            'NAME' => 'Ноутбук Acer Aspire 3 Athlon 3050U/12GB/64+240/Win11S silver UKR (A315-23 || NX.A2ZEP.006 || UKR)',
                            'YEAR' => '2014',
                            'PRICE' => '48379',
                            'OPTIONS' => [
                                1,
                                2,
                                3,
                                4,
                            ],
                        ],
                    ],
                    'OPTIONS' => [
                        4 , 5
                    ],
                ],
                [
                    'NAME' => 'Acer Aspire 7',
                    'NOTEBOOKS' => [
                        [
                            'NAME' => 'Ноутбук Acer Aspire 7 A715-42G-R0VS (NH.QBFEU.00A) FullHD Black',
                            'YEAR' => '2020',
                            'PRICE' => '68547',
                            'OPTIONS' => [
                                1,
                                2,
                                3,
                                4,
                            ],
                        ],
                        [
                            'NAME' => 'Ноутбук Acer Aspire 7 R5-5625U/8GB/512 RTX3050 (A715-43G || NH.QHDEP.001)',
                            'YEAR' => '2019',
                            'PRICE' => '57168',
                            'OPTIONS' => [
                                1,
                                2,
                                3,
                                4,
                            ],
                        ],
                    ]
                ],
            ]
        ],
        [
            'NAME' => 'Apple',
            'MODELS' => []
        ],
        [
            'NAME' => 'Asus',
            'MODELS' => []
        ],
        [
            'NAME' => 'Samsung',
            'MODELS' => []
        ],
    ];

    foreach ($arrayOptions as $Option) {
        OptionTable::add([
            'NAME' => $Option['NAME'],
        ]);
    }
    foreach ($arrayEntity as $key => $entity) {
        $resultObjectManufacturer = ManufacturerTable::add([
            'NAME' => $entity['NAME']
        ]);
        $manufacturer = ManufacturerTable::wakeUpObject($resultObjectManufacturer->getId());
        if (!empty($entity['MODELS'])) {
            foreach ($entity['MODELS'] as $model) {
                $resultObjectModel = ModelTable::add([
                    'NAME' => $model['NAME'],
                ]);
                $newModel = ModelTable::getByPrimary($resultObjectModel->getId())->fetchObject();
                $newModel->setManufacturer($manufacturer);
//                !is_null($newOption) ? $newModel->setOptions($newOption) : null;
                $newOption = null;
                if (!empty($model['OPTIONS'])) {
                    foreach ($model['OPTIONS'] as $optionId) {
                        $newOption = OptionTable::getByPrimary($optionId, [
                            'select' => ['*', 'MODELS']
                        ])->fetchObject();
                        $newOption->addToModels($newModel);
                        $newOption->save();
                    }
                }
                if (!empty($model['NOTEBOOKS'])) {
                    foreach ($model['NOTEBOOKS'] as $notebook) {
                        $resultObjectNotebook = NotebookTable::add([
                            'NAME' => $notebook['NAME'],
                            'YEAR' => $notebook['YEAR'],
                            'PRICE' => $notebook['PRICE'],
                        ]);

                        $newNotebook = NotebookTable::getByPrimary($resultObjectNotebook->getId())->fetchObject();
                        $newNotebook->setModel($newModel);
                        $newNotebook->setManufacturer($manufacturer);

                        $newOption = null;
                        if (!empty($notebook['OPTIONS'])) {
                            foreach ($notebook['OPTIONS'] as $optionId) {

                                $newOption = OptionTable::getByPrimary($optionId, [
                                    'select' => ['*', 'NOTEBOOKS']
                                ])->fetchObject(
                                );
                                $newOption->addToNotebooks($newNotebook);
                                $newOption->save();
                            }
                        }
                        $newNotebook->save();
                    }
                }
                $newModel->save();
            }
        }
    }
