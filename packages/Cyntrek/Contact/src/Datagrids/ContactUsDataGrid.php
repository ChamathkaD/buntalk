<?php

namespace Cyntrek\Contact\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class ContactUsDataGrid extends DataGrid
{
    /**
     * The column that needs to be treated as an index column.
     */
    protected $primaryColumn = 'id';

    /**
     * For sorting order. `asc` or `desc`.
     */
    protected $sortOrder = 'desc';

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('contact_us')
            ->select('id', 'first_name', 'last_name', 'email', 'phone', 'message');

        return $queryBuilder;
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => 'Id',
            'type'       => 'integer',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'first_name',
            'label'      => 'First Name',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'last_name',
            'label'      => 'Last Name',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => 'Email',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'phone',
            'label'      => 'Phone',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'message',
            'label'      => 'Message',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }
}
