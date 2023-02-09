<?php

namespace App\Tables;

use App\Models\Label;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class LabelTable extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return Label::query()->withTrashed();
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table

            ->withGlobalSearch(columns: ['id', 'name'])
            ->column('id', sortable: true, canBeHidden: false)
            ->column('name', sortable: true, canBeHidden: false)
            ->column('action', canBeHidden: false)
            ->defaultSort('id')
            ->paginate(15);
    }
}