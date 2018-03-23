.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


What does it do?
================

This extension brings a new backend module, with that you can set information for the layout and design for each page. You can easy assign the settings to your fluidtemplate and use them.

[DEPRECATED!] You can add new options to the settings via TypoScript to create new options for navigations or content, that can choose in your theme settings.

Layout: Display of header, sidebars & footer can be set on the theme options, so we are fine when we are using backend-layouts just for controlling the display of columns in the backend.


DEPRECATION
-----------

We drop the support to add typoscript-rendered menus (e.g. navitions.myextTopnav), but you'll can choose of all known menu types in TYPO3. The menu types can be customized with typoscript. We will use fluidtemplate-based menus, so you can easy outsource & modify the menus output.


TODOs
-----

- Overwriting theme conf (templateRootPaths)
- Stabilizing
