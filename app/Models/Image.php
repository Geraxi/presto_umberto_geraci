<?php

namespace App\Models;
use App\Models\Article;
use Illuminate\Database\Eloquent\Relatinos\BelongsTo;

use Illuminate\Database\Eloquent\Factories\BelongsToManyRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable=[
        'path'
    ];

    public function article(): BelongsTo{
        return $this->belongsTo(Article::class);
    }
}
