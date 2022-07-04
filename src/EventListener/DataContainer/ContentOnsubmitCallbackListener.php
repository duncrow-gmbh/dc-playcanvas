<?php
// src/EventListener/DataContainer/NewsOnsubmitCallbackListener.php
namespace DuncrowGmbh\ContaoPlaycanvasBundle\EventListener\DataContainer;

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Psr\Log\LogLevel;
use Contao\CoreBundle\Monolog\ContaoContext;
use Alchemy\Zippy\Zippy;

class ContentOnsubmitCallbackListener
{
    /**
     * @Callback(table="tl_content", target="config.onsubmit")
     */
    public function __invoke(DataContainer $dc): void
    {
        $test  =  $dc->activeRecord->dc_playcanvas_settings;
        $filesCryptisch  =  $dc->activeRecord->dc_playcanvas_settings_files;
        $files = array_map('\StringUtil::binToUuid', deserialize($filesCryptisch, true));

        $objFile = [];
        for($i = 0; $i < count($files); $i++){
            $objFile[] = [(\FilesModel::findByUuid($files[$i]))->path, (\FilesModel::findByUuid($files[$i]))->extension];
        }
        if(count($objFile)){
            $foldername = "dc-playcanvas-unzipped";
            $extractFolder = str_replace('web','',getcwd()).'/files/'.$foldername.'/'. $files[0];
            if (!file_exists($extractFolder)) {
                try {
                    $zippy = Zippy::load();
                    $archive = $zippy->open($objFile[0][0]);


                    if (!mkdir($extractFolder, 0777, true)) {
                        die('Erstellung der Verzeichnisse schlug fehl...' . $extractFolder);
                    }

                    $archive->extract($extractFolder . '/');
                    $symlinkResult = symlink(str_replace('web', '', getcwd()) . '/files/'.$foldername.'/' , './files/'.$foldername);
                    $myfile = fopen(str_replace('web', '', getcwd()) . 'files/'.$foldername.'/.public', "w");
                    fclose($myfile);

                    \Message::addConfirmation('Saved and unzipped to: /'.$foldername.'/'. $files[0]);
                    $result = $dc->Database->prepare("UPDATE tl_content SET dc_playcanvas_settings = ? WHERE id=?")->execute('./files/'.$foldername.'/'. $files[0].'/index.html', $dc->id);
                    \Message::addConfirmation('Path changed...'.'./files/'.$foldername.'/'. $files[0].'/index.html');

                } catch (\Exception $e) {
                    \Message::addError('Error extracting zip file: ' . $e->getMessage());
                }
            }else{
                $result = $dc->Database->prepare("UPDATE tl_content SET dc_playcanvas_settings = ? WHERE id=?")->execute('./files/'.$foldername.'/'. $files[0].'/index.html', $dc->id);
                \Message::addConfirmation('Path changed...'.'./files/'.$foldername.'/'. $files[0].'/index.html');
            }
        }

    }
}
