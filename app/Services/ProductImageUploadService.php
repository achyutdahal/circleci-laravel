<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Interfaces\ImageUploaderInterface;
use \App\Interfaces\Persistence;

class ProductImageUploadService implements ImageUploaderInterface {

    protected $request;
    protected $filename;

    /**
     * Sets the incoming request to get processed
     * @param Request $request
     */
    function __construct($request = null) {
        $this->request = $request;
    }

    /**
     * Uploads the images
     * @return type
     */
    public function uploadImage() {
        $extension = $this->request->getClientOriginalExtension();
        $this->setFileName($extension);

        //Images
        $this->saveImage($this->filename['main'], 300);
        $this->saveImage($this->filename['smallThumbnail'], 100);
        return $this->filename;
    }

    /**
     * Save the images to the filesystem
     * @param type $filename
     * @param type $width
     */
    public function saveImage($filename, $width) {
        $destination = public_path('/product-images/');
        $imageIntervention = \Intervention\Image\Facades\Image::make($this->request->getPathName());
        $imageIntervention->fit($width);
        $imageIntervention->save($destination . $filename);
    }

    /**
     * Sets the filename for the uploaded images
     */
    private function setFileName() {
        $extension = $this->request->getClientOriginalExtension();
        $uniqueIdName = uniqid() . '_' . time() . '_' . date('Ymd');
        //File Extensions
        $image['main'] = $uniqueIdName . '.' . $extension;
        $image['smallThumbnail'] = $uniqueIdName . '_small' . '.' . $extension;
        $this->filename = $image;
    }

    /**
     * Deletes the images of the provided product object
     * @param Product $product
     */
    public function deleteImages(Persistence $product) {
        if (\Illuminate\Support\Facades\File::exists(public_path($product->getImage()))) {
            \Illuminate\Support\Facades\File::delete(public_path($product->getImage()));
        }

        if (\Illuminate\Support\Facades\File::exists(public_path($product->smallThumbnail()))) {
            \Illuminate\Support\Facades\File::delete(public_path($product->smallThumbnail()));
        }
    }

}
