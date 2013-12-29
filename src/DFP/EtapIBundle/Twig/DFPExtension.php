<?php

namespace DFP\EtapIBundle\Twig;

class DFPExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'dfp_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('nip', array($this, 'nipFilter')),
        );
    }

    public function nipFilter($numer)
    {
        $nip = sprintf("%s-%s-%s-%s",substr($numer,0,3),substr($numer,3,2),substr($numer,5,2),substr($numer,7));

        return $nip;
    }
}