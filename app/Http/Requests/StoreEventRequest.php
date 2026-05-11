<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()->isStaff(); }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'start_date'  => 'required|date|after:now',
            'end_date'    => 'required|date|after:start_date',
            'location'    => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:draft,published,cancelled',
            'image'       => 'nullable|image|max:4096',
        ];
    }
}