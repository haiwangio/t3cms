﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

Add the commented typoscript code to your fluidtemplate setup:

.. code-block:: typoscript
    :linenos:

	...
	10 = FLUIDTEMPLATE
	10 {
		templateName = Default
		#variables {}
		dataProcessing {
			# START - ONLY ADD THIS PART
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
			# END - ONLY ADD THIS PART
		}
	...


Testing
-------

{_all->f:debug()} or {t3themesConf->f:debug()} will help you.