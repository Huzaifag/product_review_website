<?php

namespace App\Models;

use App\Models\Scopes\SortableScope;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public const DIRECTION_LTR = 'ltr';
    public const DIRECTION_RTL = 'rtl';

    protected static function booted()
    {
        static::addGlobalScope(new SortableScope);
    }

    public function scopeDefault($query)
    {
        $query->where('code', env('APP_LOCALE'));
    }

    public function isDefault()
    {
        return $this->code == env('APP_LOCALE');
    }

    protected $fillable = [
        'name',
        'code',
        'logo',
        'direction',
    ];

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
            'code' => m_trans(strtoupper($this->code)),
        ];
    }

    public function getLogoLink()
    {
        return asset($this->logo);
    }

    public function getDirection()
    {
        return self::getAvailableDirections()[$this->direction];
    }

    public function getLocalizeUrl()
    {
        return route('localize', $this->code);
    }

    public static function getAvailableDirections()
    {
        $directions = [
            self::DIRECTION_LTR => d_trans('Left to Right'),
        ];

        if (config('system.rtl')) {
            $directions[self::DIRECTION_RTL] = d_trans('Right to Left');
        }

        return $directions;
    }

    public static function getAvailableLanguages()
    {
        return [
            'aa' => d_trans('Afar'),
            'ab' => d_trans('Abkhazian'),
            'ae' => d_trans('Avestan'),
            'af' => d_trans('Afrikaans'),
            'ak' => d_trans('Akan'),
            'am' => d_trans('Amharic'),
            'an' => d_trans('Aragonese'),
            'ar' => d_trans('Arabic'),
            'as' => d_trans('Assamese'),
            'av' => d_trans('Avaric'),
            'ay' => d_trans('Aymara'),
            'az' => d_trans('Azerbaijani'),
            'ba' => d_trans('Bashkir'),
            'be' => d_trans('Belarusian'),
            'bg' => d_trans('Bulgarian'),
            'bh' => d_trans('Bihari languages'),
            'bi' => d_trans('Bislama'),
            'bm' => d_trans('Bambara'),
            'bn' => d_trans('Bengali'),
            'bo' => d_trans('Tibetan'),
            'br' => d_trans('Breton'),
            'bs' => d_trans('Bosnian'),
            'ca' => d_trans('Catalan, Valencian'),
            'ce' => d_trans('Chechen'),
            'ch' => d_trans('Chamorro'),
            'co' => d_trans('Corsican'),
            'cr' => d_trans('Cree'),
            'cs' => d_trans('Czech'),
            'cu' => d_trans('Church Slavonic, Old Bulgarian, Old Church Slavonic'),
            'cv' => d_trans('Chuvash'),
            'cy' => d_trans('Welsh'),
            'da' => d_trans('Danish'),
            'de' => d_trans('German'),
            'dv' => d_trans('Divehi, Dhivehi, Maldivian'),
            'dz' => d_trans('Dzongkha'),
            'ee' => d_trans('Ewe'),
            'el' => d_trans('Greek (Modern)'),
            'en' => d_trans('English'),
            'eo' => d_trans('Esperanto'),
            'es' => d_trans('Spanish, Castilian'),
            'et' => d_trans('Estonian'),
            'eu' => d_trans('Basque'),
            'fa' => d_trans('Persian'),
            'ff' => d_trans('Fulah'),
            'fi' => d_trans('Finnish'),
            'fj' => d_trans('Fijian'),
            'fo' => d_trans('Faroese'),
            'fr' => d_trans('French'),
            'fy' => d_trans('Western Frisian'),
            'ga' => d_trans('Irish'),
            'gd' => d_trans('Gaelic, Scottish Gaelic'),
            'gl' => d_trans('Galician'),
            'gn' => d_trans('Guarani'),
            'gu' => d_trans('Gujarati'),
            'gv' => d_trans('Manx'),
            'ha' => d_trans('Hausa'),
            'he' => d_trans('Hebrew'),
            'hi' => d_trans('Hindi'),
            'ho' => d_trans('Hiri Motu'),
            'hr' => d_trans('Croatian'),
            'ht' => d_trans('Haitian, Haitian Creole'),
            'hu' => d_trans('Hungarian'),
            'hy' => d_trans('Armenian'),
            'hz' => d_trans('Herero'),
            'ia' => d_trans('Interlingua (International Auxiliary Language Association)'),
            'id' => d_trans('Indonesian'),
            'ie' => d_trans('Interlingue'),
            'ig' => d_trans('Igbo'),
            'ii' => d_trans('Nuosu, Sichuan Yi'),
            'ik' => d_trans('Inupiaq'),
            'io' => d_trans('Ido'),
            'is' => d_trans('Icelandic'),
            'it' => d_trans('Italian'),
            'iu' => d_trans('Inuktitut'),
            'ja' => d_trans('Japanese'),
            'jv' => d_trans('Javanese'),
            'ka' => d_trans('Georgian'),
            'kg' => d_trans('Kongo'),
            'ki' => d_trans('Gikuyu, Kikuyu'),
            'kj' => d_trans('Kwanyama, Kuanyama'),
            'kk' => d_trans('Kazakh'),
            'kl' => d_trans('Greenlandic, Kalaallisut'),
            'km' => d_trans('Central Khmer'),
            'kn' => d_trans('Kannada'),
            'ko' => d_trans('Korean'),
            'kr' => d_trans('Kanuri'),
            'ks' => d_trans('Kashmiri'),
            'ku' => d_trans('Kurdish'),
            'kv' => d_trans('Komi'),
            'kw' => d_trans('Cornish'),
            'ky' => d_trans('Kyrgyz'),
            'la' => d_trans('Latin'),
            'lb' => d_trans('Letzeburgesch, Luxembourgish'),
            'lg' => d_trans('Ganda'),
            'li' => d_trans('Limburgish, Limburgan, Limburger'),
            'ln' => d_trans('Lingala'),
            'lo' => d_trans('Lao'),
            'lt' => d_trans('Lithuanian'),
            'lu' => d_trans('Luba-Katanga'),
            'lv' => d_trans('Latvian'),
            'mg' => d_trans('Malagasy'),
            'mh' => d_trans('Marshallese'),
            'mi' => d_trans('Maori'),
            'mk' => d_trans('Macedonian'),
            'ml' => d_trans('Malayalam'),
            'mn' => d_trans('Mongolian'),
            'mr' => d_trans('Marathi'),
            'ms' => d_trans('Malay'),
            'mt' => d_trans('Maltese'),
            'my' => d_trans('Burmese'),
            'na' => d_trans('Nauru'),
            'nb' => d_trans('Norwegian Bokmål'),
            'nd' => d_trans('Northern Ndebele'),
            'ne' => d_trans('Nepali'),
            'ng' => d_trans('Ndonga'),
            'nl' => d_trans('Dutch, Flemish'),
            'nn' => d_trans('Norwegian Nynorsk'),
            'no' => d_trans('Norwegian'),
            'nr' => d_trans('South Ndebele'),
            'nv' => d_trans('Navajo, Navaho'),
            'ny' => d_trans('Chichewa, Chewa, Nyanja'),
            'oc' => d_trans('Occitan (post 1500)'),
            'oj' => d_trans('Ojibwa'),
            'om' => d_trans('Oromo'),
            'or' => d_trans('Oriya'),
            'os' => d_trans('Ossetian, Ossetic'),
            'pa' => d_trans('Panjabi, Punjabi'),
            'pi' => d_trans('Pali'),
            'pl' => d_trans('Polish'),
            'ps' => d_trans('Pashto, Pushto'),
            'pt' => d_trans('Portuguese'),
            'qu' => d_trans('Quechua'),
            'rm' => d_trans('Romansh'),
            'rn' => d_trans('Rundi'),
            'ro' => d_trans('Moldovan, Moldavian, Romanian'),
            'ru' => d_trans('Russian'),
            'rw' => d_trans('Kinyarwanda'),
            'sa' => d_trans('Sanskrit'),
            'sc' => d_trans('Sardinian'),
            'sd' => d_trans('Sindhi'),
            'se' => d_trans('Northern Sami'),
            'sg' => d_trans('Sango'),
            'si' => d_trans('Sinhala, Sinhalese'),
            'sk' => d_trans('Slovak'),
            'sl' => d_trans('Slovenian'),
            'sm' => d_trans('Samoan'),
            'sn' => d_trans('Shona'),
            'so' => d_trans('Somali'),
            'sq' => d_trans('Albanian'),
            'sr' => d_trans('Serbian'),
            'ss' => d_trans('Swati'),
            'st' => d_trans('Sotho, Southern'),
            'su' => d_trans('Sundanese'),
            'sv' => d_trans('Swedish'),
            'sw' => d_trans('Swahili'),
            'ta' => d_trans('Tamil'),
            'te' => d_trans('Telugu'),
            'tg' => d_trans('Tajik'),
            'th' => d_trans('Thai'),
            'ti' => d_trans('Tigrinya'),
            'tk' => d_trans('Turkmen'),
            'tl' => d_trans('Tagalog'),
            'tn' => d_trans('Tswana'),
            'to' => d_trans('Tonga (Tonga Islands)'),
            'tr' => d_trans('Turkish'),
            'ts' => d_trans('Tsonga'),
            'tt' => d_trans('Tatar'),
            'tw' => d_trans('Twi'),
            'ty' => d_trans('Tahitian'),
            'ug' => d_trans('Uighur, Uyghur'),
            'uk' => d_trans('Ukrainian'),
            'ur' => d_trans('Urdu'),
            'uz' => d_trans('Uzbek'),
            've' => d_trans('Venda'),
            'vi' => d_trans('Vietnamese'),
            'vo' => d_trans('Volap_k'),
            'wa' => d_trans('Walloon'),
            'wo' => d_trans('Wolof'),
            'xh' => d_trans('Xhosa'),
            'yi' => d_trans('Yiddish'),
            'yo' => d_trans('Yoruba'),
            'za' => d_trans('Zhuang, Chuang'),
            'zh' => d_trans('Chinese'),
            'zu' => d_trans('Zulu'),
        ];
    }

    public function translates()
    {
        return $this->hasMany(Translate::class, 'lang', 'code');
    }
}