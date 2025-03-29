<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Article extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 'body', 'category_id', 'user_id', 'is_accepted', 'price'
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function setAccepted($value) {
        $this->is_accepted = $value;
        $this->save();
        
        // Clear related caches
        Cache::forget('articles_page_1');
        Cache::forget('category_articles_' . $this->category_id);
        
        return true;
    }

    public static function toBeRevisedCount() {
        return Cache::remember('articles_to_revise_count', 3600, function () {
            return static::where('is_accepted', null)->count();
        });
    }

    public function images(): HasMany {
        return $this->hasMany(Image::class);
    }
}
