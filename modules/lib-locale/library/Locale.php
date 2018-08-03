<?php
/**
 * Translation library
 * @package lib-locale
 * @version 0.0.2
 */

namespace LibLocale\Library;

use Mim\Library\Fs;

class Locale
{
    private static $locale;
    private static $keys = [];

    private static function getLocaleDir(string $locale, string $base=''): string{
        $path = BASEPATH . '/etc/locale/';
        $path.= $locale;
        $path.= '/' . $base;
        return chop($path, '/');
    }

    private static function loadLocale(string $locale): bool{
        $trans = self::loadLocaleRec($locale);
        if(!$trans)
            return false;
        return !!(self::$keys[$locale] = $trans);
    }

    private static function loadLocaleRec(string $locale, string $base=''): ?array{
        $result = [];
        $locale_dir = self::getLocaleDir($locale, $base);
        $lang_base = str_replace('/', '.', $base);

        $files = Fs::scan($locale_dir);
        foreach($files as $file){
            if($file === '.gitkeep')
                continue;

            $file_abs = $locale_dir . '/' . $file;
            $key_base = $lang_base ? $lang_base . '.' : '';

            if(is_file($file_abs)){
                if(substr($file, -4) !== '.php')
                    continue;
                $file_base = basename($file, '.php');

                $file_langs = include $file_abs;
                foreach($file_langs as $key => $value){
                    $main_key_base = $key_base . $key;
                    $key_base.= $file_base . '.' . $key;

                    $result[$key_base] = $value;
                    if($file_base === 'main')
                        $result[$main_key_base] = $value;
                }
            }elseif(is_dir($file_abs)){
                $res = self::loadLocaleRec($locale, trim($base . '/' . $file, '/'));
                $result = array_merge($result, $res);
            }
        }

        return $result;
    }

    static function getLocale(): ?string{
        if(!self::$locale){
            $locales = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en-US,en';
            $locales = explode(',', $locales);

            $known_locales = [[], []];

            foreach($locales as $locale){
                $locale = explode(';', $locale)[0];
                $index = strlen($locale) == 2 ? 1 : 0;
                $known_locales[$index][] = $locale;
            }

            foreach($known_locales as $index => $locales){
                foreach($locales as $locale){
                    if(!$index){
                        $locale_dir = self::getLocaleDir($locale);
                        if(is_dir($locale_dir)){
                            self::$locale = $locale;
                            break 2;
                        }
                    }else{
                        $locale_dirs = self::getLocaleDir($locale . '-*');
                        $locale_dirs = glob($locale_dirs);
                        if($locale_dirs){
                            self::$locale = basename($locale_dirs[0]);
                            break 2;
                        }
                    }
                }
            }

            if(!self::$locale){
                $locale_dir = self::getLocaleDir('');
                $locales = Fs::scan($locale_dir);
                foreach($locales as $locale){
                    $locale_abs = $locale_dir . '/' . $locale;
                    if(is_dir($locale_abs)){
                        self::$locale = $locale;
                        break;
                    }
                }
            }
        }

        return self::$locale;
    }

    static function setLocale(string $locale): void{
        self::$locale = $locale;
    }

    static function translate(string $key, array $params=[], string $locale=null): string{
        if(!$locale)
            $locale = self::getLocale();

        if(!isset(self::$keys[$locale])){
            if(!self::loadLocale($locale))
                return $key;
        }

        if(!isset(self::$keys[$locale][$key]))
            return $key;

        $text = self::$keys[$locale][$key];
        foreach($params as $pkey => $pval)
            $text = str_replace('(:' . $pkey . ')', $pval, $text);

        return $text;
    }
}