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
            new \Twig_SimpleFilter('kodPocztowy', array($this, 'kodPocztowyFilter')),
            new \Twig_SimpleFilter('waluta', array($this, 'walutaFilter'))
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getFileTypeIcon', array($this,'getFileTypeIconFunction')),
        );
    }


    public function nipFilter($numer)
    {
        $nip = sprintf("%s %s %s %s",substr($numer,0,3),substr($numer,3,2),substr($numer,5,2),substr($numer,7));

        return $nip;
    }

    public function kodPocztowyFilter($kod)
    {
        $pos = strpos($kod,"-");
        if($pos === false)
        {
            $kodPocztowy = sprintf("%s-%s",substr($kod,0,2),substr($kod,2));
        }else{
            $kodPocztowy = $kod;
        }

        return $kodPocztowy;
    }

    public function walutaFilter($kwota)
    {
        return number_format($kwota,2,',',' ').' zł';
    }

    public function getFileTypeIconFunction($type)
    {
        switch($type)
        {
            case 'accdb':
                return 'bundles/dfpetapi/images/accdb-64_32.png';
            case 'avi':
                return 'bundles/dfpetapi/images/avi-64_32.png';
            case 'bmp':
                return 'bundles/dfpetapi/images/bmp-64_32.png';
            case 'docx':
                return 'bundles/dfpetapi/images/docx_win-64_32.png';
            case 'doc':
                return 'bundles/dfpetapi/images/docx_win-64_32.png';
            case 'gif':
                return 'bundles/dfpetapi/images/gif-64_32.png';
            case 'html':
                return 'bundles/dfpetapi/images/html-64_32.png';
            case 'ini':
                return 'bundles/dfpetapi/images/ini-64_32.png';
            case 'jpeg':
                return 'bundles/dfpetapi/images/jpeg-64_32.png';
            case 'jpg':
                return 'bundles/dfpetapi/images/jpeg-64_32.png';
            case 'mid':
                return 'bundles/dfpetapi/images/midi-64_32.png';
            case 'mov':
                return 'bundles/dfpetapi/images/mov-64_32.png';
            case 'mp3':
                return 'bundles/dfpetapi/images/mp3-64_32.png';
            case 'mpg':
                return 'bundles/dfpetapi/images/mpg-64_32.png';
            case 'pdf':
                return 'bundles/dfpetapi/images/pdf-64_32.png';
            case 'png':
                return 'bundles/dfpetapi/images/png-64_32.png';
            case 'pptx':
                return 'bundles/dfpetapi/images/pptx_win-64_32.png';
            case 'ppt':
                return 'bundles/dfpetapi/images/pptx_win-64_32.png';
            case 'txt':
                return 'bundles/dfpetapi/images/text-64_32.png';
            case 'tiff':
                return 'bundles/dfpetapi/images/tiff-64_32.png';
            case 'wav':
                return 'bundles/dfpetapi/images/wav-64_32.png';
            case 'wma':
                return 'bundles/dfpetapi/images/wma-64_32.png';
            case 'wmv':
                return 'bundles/dfpetapi/images/wmv-64_32.png';
            case 'xlsx':
                return 'bundles/dfpetapi/images/xlsx_win-64_32.png';
            case 'xls':
                return 'bundles/dfpetapi/images/xlsx_win-64_32.png';
            case 'rar':
                return 'bundles/dfpetapi/images/zip-64_32.png';
            case 'zip':
                return 'bundles/dfpetapi/images/zip-64_32.png';
            case '7z':
                return 'bundles/dfpetapi/images/zip-64_32.png';
            default:
                return 'bundles/dfpetapi/images/nieznany_typ_pliku_icon_64.png';
        }
    }
}