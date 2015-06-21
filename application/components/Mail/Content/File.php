<?php
namespace Gem\Components\Mail\Content;

use Gem\Components\Mail\Content\Manager;
use Gem\Components\File as FileSystem;

/**
 *  belirli bir metinden yada uzak sunucudan veri çekmek için kullanılır.
 * @package Gem\Components\Mail\Content
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 */
class File implements Manager
{

    private $file;
    private $content;


    public function __construct($filename = '')
    {

        $this->file = FileSystem::boot();
        if ($read = $this->file->read($filename, true)) {

            $this->content = $read;

        }
    }

    public function getContent()
    {

        return $this->content;

    }

    public function setContent($content)
    {

        $this->content = $content;
        return $this;

    }

}
