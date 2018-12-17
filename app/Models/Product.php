<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Persistence;

class Product extends Model implements Persistence {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'product';

    /**
     * Returns the product thumbnail image path
     * @return string
     */
    public function smallThumbnail(): string {
        $image = $this->image;
        if ($image) {
            $imageDetails = explode('.', $image);
            $imageName = $imageDetails[0];
            $imageExtension = $imageDetails[1];
            $thumnailImage = $imageName . '_small.' . $imageExtension;
            return '/product-images/' . $thumnailImage;
        }
    }

    /**
     * Returns the path of the product image
     * @return string
     */
    public function getImage(): string {
        return '/product-images/' . $this->image;
    }

}
