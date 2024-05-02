<?php

namespace Cyntrek\Outlet\Models;

use Cyntrek\Outlet\Contracts\Outlet as OutletContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webkul\User\Models\AdminProxy;

class Outlet extends Model implements OutletContract
{
    protected $fillable = ['name', 'address', 'description', 'status'];

    /**
     * Get the admin.
     *
     * @return HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(AdminProxy::modelClass());
    }
}
