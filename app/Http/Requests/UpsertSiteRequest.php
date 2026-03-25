<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertSiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $siteId = $this->user()?->site?->id;

        return [
            'public_name' => ['required', 'string', 'max:120'],
            'slug' => [
                'required',
                'string',
                'max:120',
                'alpha_dash',
                Rule::unique('sites', 'slug')->ignore($siteId),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar_url' => ['nullable', 'string'],
            'banner_url' => ['nullable', 'url'],
            'draft_payload' => ['nullable', 'array'],
            'draft_payload.blocks' => ['nullable', 'array'],
            
        ];
    }

    public function messages(): array
    {
        return [
            'public_name.required' => 'El nombre público es obligatorio.',
            'slug.required' => 'El slug es obligatorio.',
            'slug.alpha_dash' => 'El slug solo puede contener letras, números, guiones y guiones bajos.',
            'slug.unique' => 'Ese slug ya está en uso.',
        ];
    }
}