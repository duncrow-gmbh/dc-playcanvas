<?php
use Contao\CoreBundle\DataContainer\PaletteManipulator;
// contao/dca/tl_content.php

//$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = array('CallbackLoading', 'loadFile');

$GLOBALS['TL_DCA']['tl_content']['palettes']['playcanvas_content_element'] = '
{dc_playcanvas_type_legend},type,headline;
';
//{text_legend),text,url,singleSRC, markdownSource, multiSRC;

$GLOBALS['TL_DCA']['tl_content']['fields']['dc_playcanvas_settings'] = array
(
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('mandatory'=>false, 'rgxp'=>'url','decodeEntities'=>true, 'maxlength'=>2048, 'dcaPicker'=>true),
    'sql' => "text NULL"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['dc_playcanvas_settings_files'] = array
(
    'exclude'                 => true,
    'inputType'               => 'fileTree',
    'eval'                    => array('multiple'=>false, 'fieldType'=>'checkbox', 'isSortable' => true, 'files'=>true, 'extensions' => 'zip'),
    'sql'                     => "blob NULL",
);

PaletteManipulator::create()
    ->addLegend('dc_playcanvas_legend', 'type_legend', PaletteManipulator::POSITION_AFTER)
    ->addField('dc_playcanvas_settings', 'dc_playcanvas_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('dc_playcanvas_settings_files', 'dc_playcanvas_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('playcanvas_content_element', 'tl_content');

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = ' dc_playcanvas_settings, dc_playcanvas_settings_files';

// contao/dca/tl_content.php
$GLOBALS['TL_DCA']['tl_content']['fields']['onsubmit_callback'][] = [
    \DuncrowGmbh\ContaoPlaycanvasBundle\EventListener\DataContainer\ContentOnsubmitCallbackListener::class, '__invoke'
];