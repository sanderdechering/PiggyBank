<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class piggy extends Model
{
    // Table Name
    protected $table = 'piggies';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = false;
    public function piggy()
    {
        return $this->hasMany('App\transfer');
    }
}
