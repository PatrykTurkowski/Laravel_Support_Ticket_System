<?php

namespace App\Tables;

use App\Enums\RoleEnum;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class TicketTable extends AbstractTable
{

    private array $priority;
    private array $status;
    private array $category;
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->priority = Priority::all()->pluck('name', 'id')->toArray();

        $this->status = Status::all()->pluck('name', 'id')->toArray();
        $this->category = Category::all()->pluck('name', 'id')->toArray();
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
        $user = User::find(auth()->id());
        switch ($user->role) {
            case RoleEnum::USER->value:
                return Ticket::joinRelationship('users', function ($join) use ($user) {
                    $join->where('user_id', auth()->id());
                });

            case RoleEnum::AGENT->value:
                return Ticket::joinRelationship('users', function ($join) use ($user) {
                    $join->where('assigned_agent_id', auth()->id());
                });

            case RoleEnum::ADMIN->value:
                return Ticket::query()->withTrashed();
        }
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
            ->column(__('title'), sortable: true)
            ->column(
                key: 'priorities.name',
                label: __('Priority'),
                sortable: false
            )->column(
                key: 'statuses.name',
                label: __('Status'),
                sortable: false
            )->column('action', canBeHidden: false)
            ->selectFilter('status_id', $this->status, __('Status'))
            ->selectFilter('priority_id', $this->priority, __('Priority'))
            ->selectFilter('categories.id', $this->category, __('Category'))
            ->paginate(15);
        // ->searchInput()
        // ->selectFilter()
        // ->withGlobalSearch()

        // ->bulkAction()
        // ->export()
    }
}