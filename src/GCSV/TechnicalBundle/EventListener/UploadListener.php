<?php

namespace GCSV\TechnicalBundle\EventListener;

use Oneup\UploaderBundle\Event\PostUploadEvent;

class UploadListener
{
    public function onUpload(PostUploadEvent $event)
    {
        $request = $event->getRequest();
        $idZdarzenia = $request->get('idZdarzenia');
        $original_filename = $request->files->get('blueimp')->getClientOriginalName();

        $file = $event->getFile();
        $file->move(
            __DIR__.'/../../../../web/uploads/zalaczniki/'.$idZdarzenia,
            $original_filename
        );
    }
} 