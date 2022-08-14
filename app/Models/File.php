<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "files";
    
    protected $primaryKey = "file_id";

    protected $fillable = [
        'file_name',
        'file_status',
        'file_key',
        'file_iv',
        'file_user_id'
    ];
 
    public function user()
    {
        return $this->belongsTo('App\User', 'file_user_id');
    }
}
