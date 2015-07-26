<?php

namespace GCSV\TechnicalBundle;

use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;

class ZalacznikNamer implements NamerInterface
{
    public function name(FileInterface $file)
    {
        return sprintf('%s.%s', $file->getBasename(), $file->getExtension());
    }
} 