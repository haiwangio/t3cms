# EXT:T3cms - TYPO3 Content Management System

## TODOs

- Overwriting theme conf (templateRootPaths)

## Installation

* die Extension ```t3cms``` installieren.
* TypoScript Beispiel aus dieser README in dein Projekt einbinden.
* Testen :) {_ all->f:debug()} {t3themesConf->f:debug()}

## Why & How

### Es wurde eine Rootline Configuration für Themes eingeführt.

Es gibt ein neues Backend Modul, mit dem Sie neue Seiteneinstellungen erhalten. Mit den Einstellungen können Sie Anzeige von Content und das Frontend Layout steuern. Diese Einstellungen vererben sich hierarchisch im Seitenbaum.

## Bau dieses TypoScript Setup Beispiel in dein Projekt ein.

	...
	10 = FLUIDTEMPLATE
	10 {
	    templateName = Default
        #variables {}
        dataProcessing {
            30 = SalvatoreEckel\T3cms\DataProcessing\T3themesConfProcessor
            30 {
                fieldName = t3themes_conf
                as = t3themesConf
                rootpageId = TEXT
                rootpageId {
                    insertData = 1
                    data = leveluid : 0
                }
            }
        }
    ...
