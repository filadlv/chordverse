<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class SongRequest extends FormRequest
{
    /**
     * Hanya pengguna yang sudah login yang boleh mengirim form chord.
     * Kepemilikan chord (update/delete) tetap diperiksa SongPolicy di controller.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'artist' => ['required', 'string', 'max:150'],
            'genre_id' => ['required', 'exists:genres,id'],
            'chord' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'judul',
            'artist' => 'penyanyi/band',
            'genre_id' => 'genre',
            'chord' => 'chord',
            'notes' => 'catatan',
            'cover' => 'cover',
        ];
    }

    public function messages(): array
    {
        return [
            'genre_id.exists' => 'Genre yang dipilih tidak tersedia.',
            'cover.image' => 'Cover harus berupa gambar.',
            'cover.mimes' => 'Cover harus berformat jpg, jpeg, png, atau webp.',
            'cover.max' => 'Ukuran cover maksimal 2 MB.',
        ];
    }
}
