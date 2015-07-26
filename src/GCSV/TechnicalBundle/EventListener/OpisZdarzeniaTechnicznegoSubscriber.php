<?php

namespace GCSV\TechnicalBundle\EventListener;

use Doctrine\ORM\EntityRepository;
use GCSV\TechnicalBundle\Entity\RodzajZdarzeniaTechnicznego;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

class OpisZdarzeniaTechnicznegoSubscriber implements EventSubscriberInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * @param FormFactoryInterface $factory
     */
    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT =>  'onPreSubmit'
        );
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if(null === $data)
        {
            return;
        }

        /**
         * @var RodzajZdarzeniaTechnicznego $rodzaj
         */
        $rodzaj = $data->getRodzajZdarzeniaTechnicznego();

        $dodatkowePola = null === $rodzaj ? array() : $rodzaj->getRodzajePytan();

        foreach ($dodatkowePola as $pole)
        {
            $wymagane = $pole->getWymagane();
            $nazwa = 'pole_'.$pole->getPytanie()->getId();
            $typ = $pole->getPytanie()->getTyp();
            $tresc = $pole->getPytanie()->getPytanie();

            $form->add($this->factory->createNamed($nazwa, $typ, array(
                        'label'     =>  $tresc,
                        'required'  =>  $wymagane,
                        'mapped'    =>  false
                    )
                )
            );
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        $rodzajId = array_key_exists('rodzajZdarzeniaTechnicznego', $data) ? $data['rodzajZdarzeniaTechnicznego'] : null;

    }
} 