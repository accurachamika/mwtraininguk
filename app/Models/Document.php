<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documents';
    protected $primaryKey = 'doc_id';
    public $incrementing = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

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
