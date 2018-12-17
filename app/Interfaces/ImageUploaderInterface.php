<?php

namespace App\Interfaces;

use App\Interfaces\Persistence;
use \Illuminate\Database\Eloquent\Model;
/**
 *
 * @author achyut
 */
interface ImageUploaderInterface {

    //put your code here
    public function uploadImage();

    public function deleteImages(Persistence $object);
}
