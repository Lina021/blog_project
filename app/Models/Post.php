<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'content', 'image'];

    /**
     * Match the term against the title, the full content and the tag names.
     */
    public function scopeSearch(Builder $query, ?string $term): void
    {
        $term = trim((string) $term);

        if ($term === '') {
            return;
        }

        $like = '%'.addcslashes($term, '%_\\').'%';

        $query->where(function (Builder $query) use ($like) {
            $query->where('title', 'like', $like)
                ->orWhere('content', 'like', $like)
                ->orWhereHas('tags', fn (Builder $tags) => $tags->where('name', 'like', $like));
        });
    }

    public function scopeWithTag(Builder $query, int|string|null $tagId): void
    {
        if ($tagId) {
            $query->whereHas('tags', fn (Builder $tags) => $tags->whereKey($tagId));
        }
    }

    public function isEdited(): bool
    {
        return $this->updated_at->gt($this->created_at);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
