# lib-locale


Library yang menyediakan translasi suatu teks berdasarkan dictionary.
Semua translasi di cache di folder `etc/cache/locale`, jika melakukan
perubahan pada locale file di `etc/locale/*`, pastikan menjalankan perintah
`mim app config` di folder aplikasi untuk meregenerasi cache locale.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-locale
```

## Penggunaan

Module ini mendaftarkan satu fungsi global dengan nama `lang` yang bisa diakses
darimana saja untuk melakukan translasi.

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

## Translasi

Semua translasi suatu locale disimpan di folder `etc/locale/[locale]/`. Umumnya, nama
file translasi adalah `main.php`. Tapi nama file yang lain tentu bisa digunakan dengan
ketentuan nama file harus digunakan di key translasi. Folder ini juga bisa menyimpan
subfolder dan subfiles, seperti perbedaan nama file, masing-masing folder juga harus
disebutkan pada key translasi yang dipisahkan dengan titik.

Sebagai contoh, untuk file translasi `etc/locale/en-US/form/error/general.php`, yang 
berisi data seperti di bawah:

```php
// file etc/locale/en-US/form/error/general.php
return [
    'required' => 'The field (:name) is required'
];
```

Dengan contoh seperti di atas, maka untuk mendapatkan translasi, bisa menggunakan
perintah seperti di bawah:

```php
$text = lang('form.error.general.required', ['name'=>'username'], 'en-US');
```

Nilai variable `(:name)` diambil dari parameter kedua fungsi ini.

Jika nama file adalah `main.php`, maka key `main` tidak perlu ada pada key translasi.

## Formatter

Jika library `lib-formatter` terpasang, maka module ini akan menambahkan satu formatter
dengan nama `locale`.

### locale

Mentranslasi nilai properti object sesuai dengan konfigurasi locale.

```php
'field' => [
    'type' => 'locale',
    'locale' => [
        'params' => [
            'name' => '$name',
            'fullname' => '$user.fullname',
            'prop' => 'prop'
        ]
    ]
]
```

Nilai properti `locale.params` akan ditambahkan ke fungsi `lang` sebagai params.

Nilai properti object yang akan di translasi diharapkan berbentuk seperti di bawah:

```
'field' => (object)[
    'default' => [
        'text' => Default translation if locale not found',
        'locale' => 'en-US'
    ],
    'locale' => [
        'key' => 'form.error.general.required',
        'params' => [
            'name' => 'username'
        ]
    ]
];
```

Jika translasi dengan dari nilai `locale.key` tidak ditemukan, maka nilai
dari `default.text` akan digunakan.