<?php

namespace Cyntrek\Contact\Models;

use Cyntrek\Contact\Contracts\Contact as ContactContract;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model implements ContactContract
{
    public $table = 'contact_us';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'message',
    ];
}
