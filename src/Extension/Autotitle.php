<?php

namespace Adarsh\Plugin\Content\Autotitle\Extension;

defined('_JEXEC') or die;

use Joomla\CMS\Event\Model\PrepareFormEvent;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\SubscriberInterface;

final class Autotitle extends CMSPlugin implements SubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'onContentPrepareForm' => 'onContentPrepareForm',
            'onAjaxAutotitle'      => 'onAjaxAutotitle',
        ];
    }

    public function __construct($dispatcher, $config)
    {
        parent::__construct($dispatcher, $config);
    }

    public function onContentPrepareForm(PrepareFormEvent $event): void
    {
        $app = Factory::getApplication();
        $doc = $app->getDocument();

        $form = $event->getForm();
        $name = $form->getName();

        $data = $event->getData();

        if ($form->getName() !== 'com_content.article')
        {
            return;
        }

        $isNew = false;

        if ($data instanceof \stdClass)
        {
            $isNew = empty($data->id);
        }
        elseif (is_array($data))
        {
            $isNew = empty($data['id']);
        }

        if (!$isNew)
        {
            return;
        }

        $wa  = $doc->getWebAssetManager();

        $wa->registerAndUseScript(
            'plg_content_autotitle.script',
            'media/plg_content_autotitle/js/script.js',
            [],
            ['type' => 'module'],
            []
        );

        $ajaxUrl = 'index.php?option=com_ajax&plugin=autotitle&group=content&format=json';
        $token   = $app->getSession()->getFormToken();

        $doc->addScriptDeclaration(
            "window.autotitleConfig = {
                ajaxUrl: '" . $ajaxUrl . "',
                csrf: '" . $token . "'
            };"
        );
    }

    public function onAjaxAutotitle($event)
    {
        $text = $this->params->get('default_text', '');
        
        if (method_exists($event, 'addResult') && !empty($text)) {
            $event->addResult($text);
        }
        
        return $text;
    }
}
