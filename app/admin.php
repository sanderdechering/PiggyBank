<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{

    // Table Name
    protected $table = 'admin';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = false;

    public function admin()
    {
        return $this->hasOne('App\User');
    }
}
