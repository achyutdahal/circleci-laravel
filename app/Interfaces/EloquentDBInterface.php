<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Persistence;

/**
 *
 * @author achyut
 */
interface EloquentDBInterface extends Persistence {

    public function all();

    public function add();

    public function delete(): bool;

    public function get(int $id);

    
}
