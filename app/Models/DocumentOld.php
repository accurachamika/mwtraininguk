<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentOld extends Model
{
    use HasFactory;

    protected $table = 'documentsold';
    protected $primaryKey = 'doc_id';
    public $incrementing = true;

    
    protected $fillable = [
        'file_name',
        'doc_type',
        'std_id',
        'std_name',
        'last_updated',
        'uploaded_by',
        'mime',
        'desc'
    ];
}
