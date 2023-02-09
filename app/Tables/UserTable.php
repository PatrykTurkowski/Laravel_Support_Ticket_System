<?php

namespace App\Tables;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\SpladeTable;

class UserTable extends AbstractTable
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


        return User::query()->withTrashed();
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

            ->withGlobalSearch(columns: ['id', 'name', 'email'])
            ->column('id', sortable: true, canBeHidden: false)
            ->column('name', sortable: true, canBeHidden: false)
            ->column('email', sortable: true, canBeHidden: false)
            ->column('action', canBeHidden: false)
            ->selectFilter('role', [
                RoleEnum::ADMIN->value => RoleEnum::ADMIN->value,
                RoleEnum::AGENT->value => RoleEnum::AGENT->value,
                RoleEnum::USER->value => RoleEnum::USER->value,
            ])
            ->selectFilter(key: 'deleted_at', label: __('deleted'), options: [
                RoleEnum::ADMIN->value => RoleEnum::ADMIN->value,
                RoleEnum::AGENT->value => RoleEnum::AGENT->value,
                RoleEnum::USER->value => RoleEnum::USER->value,
            ])
            ->paginate(15);
    }
}