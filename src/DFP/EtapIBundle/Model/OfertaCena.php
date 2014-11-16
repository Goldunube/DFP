<?php

namespace DFP\EtapIBundle\Model;


class OfertaCena
{
    public $kolor = '';

    public $wartosc = 0;

    /**
     * @return mixed
     */
    public function getKolor()
    {
        return $this->kolor;
    }

    /**
     * @param mixed $kolor
     */
    public function setKolor($kolor)
    {
        $this->kolor = $kolor;
    }

    /**
     * @return mixed
     */
    public function getWartosc()
    {
        return $this->wartosc;
    }

    /**
     * @param mixed $wartosc
     */
    public function setWartosc($wartosc)
    {
        $this->wartosc = $wartosc;
    }
} 