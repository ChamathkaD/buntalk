<?php

namespace Cyntrek\Contact\Repositories;

use Cyntrek\Contact\Models\Contact;
use Webkul\Core\Eloquent\Repository;

class ContactRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model(): string
    {
        return Contact::class;
    }

    public function create(array $attributes)
    {
        $this->model->create($attributes);
    }
}
