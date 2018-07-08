<?php
/**
 * Translation library
 * @package lib-locale
 * @version 0.0.1
 */

namespace LibLocale\Library;

class Locale
{
    private static $locale;
    private static $keys = [];

    private static function getLocaleFile(string $locale): string{
        return BASEPATH . '/etc/locale/' . $locale . '.php';
    }

    private static function loadLocale(string $locale): bool{
        $locale_file = self::getLocaleFile($locale);
        if(!is_file($locale_file)){
            trigger_error('Locale named `' . $locale . '` not found');
            return false;
        }

        return !!(self::$keys[$locale] = include $locale_file);
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
                        $locale_file = self::getLocaleFile($locale);
                        if(is_file($locale_file)){
                            self::$locale = $locale;
                            break 2;
                        }
                    }else{
                        $locale_files = self::getLocaleFile($locale . '-*');
                        $locale_files = glob($locale_files);
                        if($locale_files){
                            self::$locale = basename($locale_files[0], '.php');
                            break 2;
                        }
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