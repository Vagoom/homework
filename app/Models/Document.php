<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    public const FILE_FORM_FIELD = 'doc';

    /** @var string */
    protected $table = 'documents';

    /** @var bool  */
    public $timestamps = false;

}
