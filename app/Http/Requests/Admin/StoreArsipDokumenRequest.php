<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreArsipDokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'nomor_dokumen' => ['nullable', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:100'],
            'tanggal_dokumen' => ['nullable', 'date'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg',
                'max:10240', // Maksimal 10MB
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul dokumen wajib diisi.',
            'judul.max' => 'Judul dokumen maksimal 255 karakter.',
            'kategori.required' => 'Kategori dokumen wajib dipilih atau diisi.',
            'file.required' => 'Berkas dokumen wajib diunggah.',
            'file.file' => 'Berkas yang diunggah harus berupa file yang valid.',
            'file.mimes' => 'Format berkas tidak didukung. Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG.',
            'file.max' => 'Ukuran berkas maksimal adalah 10 MB.',
        ];
    }
}
