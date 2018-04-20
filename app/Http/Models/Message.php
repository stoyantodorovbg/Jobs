<?php

namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Get the user who sends the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('message_id', 'user_id', 'is_sent', 'is_received');
    }
}
