<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationNote extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'note', 'noted_at'];

    public $timestamps = false;

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
