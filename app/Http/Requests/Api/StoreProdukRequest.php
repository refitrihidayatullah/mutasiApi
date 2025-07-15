<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdukRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_produk' => 'required',
            'kode_produk' => 'required|unique:produks',
            'kategori' => 'required',
            'satuan' => 'required',
        ];
    }
    public function passedValidation()
    {
        $inputKeys = array_keys($this->all());
        $ruleKeys = array_keys($this->rules());

        $unexpected = array_diff($inputKeys, $ruleKeys);

        if (!empty($unexpected)) {
            abort(response()->json([
                'success' => false,
                'message' => 'Field tidak dikenali: ' . implode(', ', $unexpected),
                'data' => null
            ], 422));
        }
    }
}
