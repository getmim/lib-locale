# lib-locale

Library yang menyediakan translasi suatu teks berdasarkan dictionary.

## instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-locale
```

## penggunaan

Module ini mendaftarkan satu fungsi global dengan nama `lang` yang bisa diakses
darimana saja untuk melakukan transalasi.

### lang(string $key, array $params=[], string $locale=null): string

Fungsi di atas adalah fungsi umum yang bisa digunakan dari mana saja di dalam
aplikasi untuk translasi.

```php
$trans = lang('welcome_user', ['name'=>'Iqbal'], 'en-US');
```

Module ini juga mendaftarkan satu library dengan nama `LibLocale\Library\Locale` dengan
method sebagai berikut:

### setLocale(string $locale): void
### translate(string $key, array $params=[], string $locale=null): string

Fungsi `translate` adalah fungsi yang akan dipanggil oleh fungsi `lang`.

## translasi

Semua translasi di simpan di folder `etc/locale/[lang].php`. Contoh dictionary
translasi adalah sebagai berikut:

```php
return [
    'welcome_user' => 'Selamat datang, (:name)'
];
```

Nilai `(:name)` adalah variabel yang akan diambil dari parameter kedua fungsi `lang`.