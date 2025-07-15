<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class GenerateCode
{
    /**
     * Generate kode unik berdasarkan nama, model, dan kolom target.
     *
     * @param string $name     → Nama yang digunakan sebagai prefix.
     * @param string $model    → Nama class model, misal: Produk::class.
     * @param string $column   → Kolom yang dicek keunikannya, misal: 'kode_produk'.
     * @param int    $length   → Panjang angka acak di belakang.
     * @param int    $attempts → Max percobaan untuk menghindari duplikat.
     * @return string
     * @throws \Exception
     */
    public static function generateKodeUnik(string $name, string $model, string $column, int $length = 5, int $attempts = 10): string
    {
        $prefix = strtoupper(Str::substr(Str::slug($name, ''), 0, 3));

        for ($i = 0; $i < $attempts; $i++) {
            $random = str_pad((string)random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
            $kode = $prefix . "-" . $random;

            if (! $model::where($column, $kode)->exists()) {
                return $kode;
            }
        }

        throw new \Exception("Gagal membuat kode unik setelah $attempts percobaan.");
    }
}
