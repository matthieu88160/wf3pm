<?php
namespace App\Dto;

use App\Entity\CommentFile;
use Symfony\Component\Validator\Constraints as Assert;

class FileDto extends CommentFile
{
    /**
     * @Assert\File(
     *      maxSize = "2M"
     * )
     */
    public $file;
}

