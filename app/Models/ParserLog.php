<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParserLog extends Model
{
    use HasFactory;

    protected $table = 'parser_logs';
    protected $guarded = [];
}
