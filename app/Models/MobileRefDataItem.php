<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileRefDataItem extends Model
{
    use HasFactory;
    private $id;
    private $id_parent;
    private $type;
    private $key;
    private $TextDe;
    private $TextEn;
    private $TextFr;
    private $date;

    const _CLASS = 1;
    const _CATEGORY = 2;
    const _MAKE = 3;
    const _MODEL = 4;
    const _MODELGROUP = 5;
    const _MODEL_OF_MODEL_GROUP = 6;
    const _MODELRANGE = 7;
    const _TRIMLINE = 8;
    const _USED_CAR_SEAL = 9;
    const _FEATURE = 10;
}
