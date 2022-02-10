<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileConfiguration extends Model
{
    use HasFactory;
    protected $table = 'mobile_ref_data_items';
    public $timestamps = false;
    protected $primaryKey = 'id';
    private static $languages = [
        'de' => 'de',
        'en' => 'en',
        'fr' => 'fr'
    ];

    /**
     * Get the Languages.
     *
     * @return string[] array of languages
     */
    public static function getLang(): array
    {
        return self::$languages;
    }

    /**
     * Set the Language.
     *
     * Get the appropriate column name for given Language
     *
     * @param string $lang
     * @return string|null
     */
    public function getText(string $lang): ?string
    {
        if ($lang === 'de') {
            return 'TextDe';
        } else if ($lang === 'en') {
            return 'TextEn';
        } else if ($lang === 'fr') {
            return 'TextFr';
        }
        return null;
    }
    /**
     * Get all the attribute names.
     * 
     * @return array of attribute names
     */
    public function getAttributeNames()
    {
        $attributes = [
            'airbags' => 11,
            'batteries' => 12,
            'bendinglightstypes' => 13,
            'breakdownservices' => 14,
            'climatisations' => 15,
            'colors' => 16,
            'conditions' => 17,
            'countryversion' => 18,
            'daytimerunninglamps' => 19,
            'doorcounts' => 20,
            'drivingcabs' => 21,
            'drivingmodes' => 22,
            'emissionclasses' => 23,
            'emissionstickers' => 24,
            'fuels' => 25,
            'fuelconsumptionunits' => 26,
            'gearboxes' => 27,
            'headlighttypes' => 28,
            'hydraulicinstallations' => 29,
            'interiorcolors' => 30,
            'interiortypes' => 31,
            'parkingassistants' => 32,
            'petroltypes' => 33,
            'radiotypes' => 34,
            'slidingdoortypes' => 35,
            'speedcontrols' => 36,
            'trailercouplingtypes' => 37,
            'usagetypes' => 38,
            'wheelformulas' => 39

        ];
        return $attributes;
    }
}
