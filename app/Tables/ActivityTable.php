<?php

namespace App\Tables;


use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\Activitylog\Models\Activity as ModelsActivity;

class ActivityTable extends AbstractTable
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
        return ModelsActivity::query()->orderByDesc('id');
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
            ->withGlobalSearch(columns: ['id'])
            ->column('id', sortable: true)

            ->column(
                key: 'log_name',
                label: __('log name'),
                sortable: true
            )
            ->column(
                key: 'description',
                label: __('description'),
                sortable: true
            )
            ->column(
                key: 'event',
                label: __('event'),
                sortable: true
            )
            ->column(
                key: 'causer_id',
                label: __('user'),
                sortable: true
            )
            ->column(
                key: 'created_at',
                label: __('created_at'),
                sortable: true
            )
            ->column(
                key: 'action',
                canBeHidden: false
            )
            // ->selectFilter('priority_id', $this->priority, __('Priority'))
            // ->selectFilter('categories.id', $this->category, __('Category'))
            ->paginate(15);

        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // ->bulkAction()
        // ->export()
    }
}