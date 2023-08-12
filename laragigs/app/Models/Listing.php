<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'email', 'tags', 'description', 'location', 'website'];

    // comes from ListController filter
    public function scopeFilter($query, array $filters)
    {
        // if this isn't false continue
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        // _search.blade.php has an input form, when clicked redirects to "/" (listingController)
        // then 'filter' == 'search'
        // the request('search') actually has the input value ex. (js, backend, ect)
        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    // relationship to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
