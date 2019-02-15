<?php
declare(strict_types=1);

namespace Idk\LegoMediaBundle\Twig;

use Idk\LegoMediaBundle\Service\AttachmentManager;

class AttachmentTwigExtension extends \Twig_Extension
{

    private $manager;

    public function __construct(AttachmentManager $manager)
    {
        $this->manager = $manager;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('lgo_render_attachment', array($this, 'renderAttachment'), array('is_safe' => array('html'), 'needs_environment' => true)),
            new \Twig_SimpleFunction('lgo_list_attachment', array($this, 'listAttachment'), array('is_safe' => array('html'), 'needs_environment' => true)),
            new \Twig_SimpleFunction('lgo_count_attachment', array($this, 'countAttachment'), array('is_safe' => array('html'), 'needs_environment' => true))
        );
    }

    public function renderAttachment(\Twig_Environment $env, object $item)
    {
        return $env->render('@IdkLegoMedia/twig_extension/render_attachment.html.twig',[
            'docs' => $this->manager->findAll($item),
            'item' => $item,
            'class' => get_class($item),
            'unique_id' => $this->manager->getUniqueId($item)
        ]);
    }

    public function listAttachment(\Twig_Environment $env, object $item, array $options)
    {
        return $env->render('@IdkLegoMedia/twig_extension/list_attachment.html.twig',[
            'docs' => $this->manager->findAll($item),
            'icon' => $options['icon'] ?? 'fa fa-file-o'
        ]);
    }

    public function countAttachment(\Twig_Environment $env, object $item)
    {
        return $env->render('@IdkLegoMedia/twig_extension/count_attachment.html.twig',[
            'count' =>  \count($this->manager->findAll($item)),
            'item' => $item
        ]);
    }

    public function getName()
    {
        return 'attachment_extension';
    }
}