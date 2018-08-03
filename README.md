# lib-locale


Library yang menyediakan translasi suatu teks berdasarkan dictionary.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-locale
```

## Penggunaan

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

## Translasi

Semua translasi suatu locale disimpan di folder `etc/locale/[locale]/`. Umumnya, nama
file translasi adalah `main.php`. Tapi nama file yang lain tentu bisa digunakan dengan
ketentuan nama file harus digunakan di key translasi. Folder ini juga bisa menyimpan
subfolder dan subfiles, seperti perbedaan nama file, masing-masing folder juga harus
disebutkan pada key transalsi yang dipisahkan dengan titik.

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