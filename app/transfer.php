<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transfer extends Model
{
    // Table Name
    protected $table = 'transfers';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = false;
}
