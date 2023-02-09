<?php

namespace App\Http\Requests\Ticket;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Rules\isAgent;
use Illuminate\Foundation\Http\FormRequest;
use ProtoneMedia\Splade\FileUploads\HasSpladeFileUploads;

class UpdateTicketRequest extends FormRequest implements HasSpladeFileUploads
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:25', 'max:3000'],
            'label_id' => ['required'],
            'label_id.*' => ['integer', 'exists:labels,id'],
            'priority_id' => ['required'],
            'priority_id.*' => ['required', 'integer', 'exists:priorities,id'],
            'category_id' => ['required'],
            'category_id.*' => ['required', 'integer', 'exists:categories,id'],
            'files.*' => ['file'],

        ];
        if (User::find(auth()->id())->role == RoleEnum::ADMIN->value) {
            $rules['assigned_agent_id'] = ['integer', 'exists:users,id', new isAgent()];
        }

        return $rules;
    }
}