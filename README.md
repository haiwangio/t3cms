# EXT:T3cms - TYPO3 Content Management System

## TODOs

.

## Installation

* die Extension ```t3cms``` im EM aktivieren
* die Static Templates und PageTS im gewünschten Seitenbaum einbinden


## Es wurde eine Rootline Configuration für Themes eingeführt.

In den Seiteneigenschaften jeder Seite lassen sich Einstellung setzen die das Theme/Layout beeinflussen. Leere Werte erben nicht leere Werte von Elternseiten.


`` {namespace se=SalvatoreEckel\T3cms\ViewHelpers}
`` <se:jsonDecode data="" as="t3themesConf">{t3themesConf->f:debug()}</se:jsonDecode>

or 

`` <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers" data-namespace-typo3-fluid="true" xmlns:dm="http://typo3.org/ns/SalvatoreEckel/T3cms/ViewHelpers">
`` 		<se:jsonDecode data="" as="t3themesConf">{t3themesConf->f:debug()}</se:jsonDecode>
`` </html>

