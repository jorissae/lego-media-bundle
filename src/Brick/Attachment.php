<?php

namespace Idk\LegoMediaBundle\Brick;

use Idk\LegoBundle\Component\Component;
use Idk\LegoBundle\Form\Type\AutoCompletionType;
use Idk\LegoBundle\Service\MetaEntityManager;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class Attachment extends Component {


    private $entityId = null;
    private $formId = false;
    private $formFactory;
    private $mem;

    public function __construct(MetaEntityManager $mem, FormFactoryInterface $formFactory){
        $this->mem = $mem;
        $this->formFactory = $formFactory;
    }

    protected function init()
    {
        return;
    }

    protected function requiredOptions()
    {
        return [];
    }


    public function getTemplate($name = 'index'){
        if($name == 'index' and $this->formId){
            $name = 'index_in_form_content';
        }
        return '@IdkLegoMedia/brick/attachment/'.$name.'.html.twig';
    }

    public function getTemplateParameters()
    {
        if($this->entityId){
            $formView = null;
            $entity =  $this->getConfigurator()->getRepository()->find($this->entityId);
        }else{
            $form = $this->formFactory->createBuilder(FormType::class, null, [])
                ->add($this->gid('entity_id'), AutoCompletionType::class, ['label' => 'lego.form.choice_entity' ,'class' => $this->getConfigurator()->getClass(), 'route' => $this->getConfigurator()->getPathRoute('autocompletion')])
                ->getForm();
            $formView = $form->createView();
            $entity = null;
        }
        return ['entity' => $entity, 'form' => $formView, 'theme' => $this->getOption('theme','@IdkLego/Form/lego_base_fields.html.twig')];
    }

    public function bindRequest(Request $request){
        parent::bindRequest($request);
        if($request->get('id')){
            $this->entityId = $this->getRequest()->get('id');
        }elseif($request->request->has('form') and isset($request->request->get('form')[$this->gid('entity_id')])){
            $this->entityId = $request->request->get('form')[$this->gid('entity_id')];
            $this->formId = true;
        }
    }
}