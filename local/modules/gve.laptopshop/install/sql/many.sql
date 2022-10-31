CREATE TABLE `gve_option_notebook`
(
    `NOTEBOOK_ID` int(11) NOT NULL,
    `OPTION_ID` int(11) NOT NULL,
    PRIMARY KEY (`NOTEBOOK_ID`, `OPTION_ID`),
    CONSTRAINT `NO_OPTION` FOREIGN KEY (`NOTEBOOK_ID`) REFERENCES `gve_notebook` (`id`),
    CONSTRAINT `NO_NOTEBOOK` FOREIGN KEY (`OPTION_ID`) REFERENCES `gve_option` (`id`)

)
    COLLATE utf8_general_ci;

CREATE TABLE `gve_option_model`
(
    `MODEL_ID` int(11) NOT NULL,
    `OPTION_ID` int(11) NOT NULL,
    PRIMARY KEY (`MODEL_ID`, `OPTION_ID`),
    CONSTRAINT `MO_OPTION` FOREIGN KEY (`MODEL_ID`) REFERENCES `gve_model` (`id`),
    CONSTRAINT `MO_MODEL` FOREIGN KEY (`OPTION_ID`) REFERENCES `gve_option` (`id`)

)
    COLLATE utf8_general_ci;
