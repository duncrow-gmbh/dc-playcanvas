<?php
namespace DuncrowGmbh\ContaoPlaycanvasBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @ContentElement(category="texts")
 */
class PlaycanvasContentElementController extends AbstractContentElementController
{
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $template->type = $model->type;
        $template->headline = $model->headline;
        return $template->getResponse();
    }
}
