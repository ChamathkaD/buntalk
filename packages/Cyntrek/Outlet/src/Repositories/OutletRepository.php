<?php

namespace Cyntrek\Outlet\Repositories;

use Cyntrek\Outlet\Models\Outlet;
use Illuminate\Support\Facades\Event;
use Webkul\Core\Eloquent\Repository;

class OutletRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model(): string
    {
        return Outlet::class;
    }

    public function create(array $attributes)
    {
        Event::dispatch('core.outlet.create.before');

        $outlet = parent::create($attributes);

        Event::dispatch('core.outlet.create.after', $outlet);

        return $outlet;
    }

    public function update(array $attributes, $id)
    {
        Event::dispatch('core.outlet.update.before', $id);

        $outlet = parent::update($attributes, $id);

        Event::dispatch('core.outlet.update.after', $outlet);

        return $outlet;
    }

    public function delete($id)
    {
        Event::dispatch('core.outlet.delete.before', $id);

        if ($this->model->count() == 1) {
            return false;
        }

        if ($this->model->destroy($id)) {
            Event::dispatch('core.outlet.delete.after', $id);

            return true;
        }

        return false;
    }
}
