<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use ProtoneMedia\Splade\FileUploads\HasSpladeFileUploads;

class StoreTicketRequest extends FormRequest implements HasSpladeFileUploads
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


        return [
            'user_id' => ['required', 'int'],
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
    }
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id()
        ]);
    }
}
