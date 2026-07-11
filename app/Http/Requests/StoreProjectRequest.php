<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('projects', 'slug')->withoutTrashed()],
            'summary' => ['required', 'string'],
            'case_study' => ['required', 'string'],
            'solution' => ['required', 'string'],
            'features' => ['required', 'array', 'min:1'],
            'features.*' => ['required', 'string', 'max:255'],
            'technologies' => ['required', 'array', 'min:1'],
            'technologies.*' => ['required', 'string', 'max:100'],
            'github_url' => ['nullable', 'string', 'url', 'max:255'],
            'demo_url' => ['nullable', 'string', 'url', 'max:255'],
            'status' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Maksimal 255 karakter.',
            'slug.required' => 'Slug wajib diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
            'summary.required' => 'Ringkasan wajib diisi.',
            'case_study.required' => 'Studi kasus wajib diisi.',
            'solution.required' => 'Solusi wajib diisi.',
            'features.required' => 'Minimal satu fitur.',
            'features.min' => 'Minimal satu fitur.',
            'features.*.required' => 'Nama fitur tidak boleh kosong.',
            'technologies.required' => 'Minimal satu teknologi.',
            'technologies.min' => 'Minimal satu teknologi.',
            'sort_order.required' => 'Urutan wajib diisi.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'github_url.url' => 'Format URL tidak valid.',
            'demo_url.url' => 'Format URL tidak valid.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.max' => 'Ukuran gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $features = array_values(array_filter(array_map(
            static fn (mixed $feature): string => trim((string) $feature),
            (array) $this->input('features', []),
        )));

        $this->merge([
            'slug' => Str::slug((string) ($this->input('slug') ?: $this->input('title'))),
            'features' => $features,
            'status' => $this->boolean('status'),
        ]);
    }
}
