<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\MobileConfiguration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

ini_set('max_execution_time', '300');
ini_set('max_execution_time', '0');

class MobileRefDataStorageController extends Controller
{
    protected $mobConf;

    /**
     *Class constructor with mobile configuration
     */
    public function __construct()
    {
        $this->mobConf = new MobileConfiguration();
    }

    /**
     * Insert items in the database.
     *
     * Get the given item from the database.
     * If it is empty then enter the given item in the database
     * Otherwise get the id from the item.
     *
     * @param array $items
     * @return int last insert id|id of the item
     */
    public function insertItems(array $items): int
    {
        $refItem = DB::table($this->mobConf->getTable())
            ->where('type', $items['type'])
            ->where('key', $items['key'])
            ->where('id_parent', $items['id_parent'])->get();
        if (empty($refItem[0])) {
            $mobileItems = [
                'id_parent' => $items['id_parent'], 'type' => $items['type'], 'key' => $items['key'], 'TextDe' => $items['TextDe'],
                'TextEn' => $items['TextEn'],
                'TextFr' => $items['TextFr'],
                'date' => null
            ];
            $id = DB::table($this->mobConf->getTable())->insertGetId($mobileItems);
        } else {
            $id = $refItem[0]->id;
        }
        return $id;
    }

    /**
     * Insert items with data in the database.
     *
     * @param array $items
     */
    public function insertItemsWithDate(array $items)
    {
        try {
            DB::insert("insert into {$this->mobConf->getTable()} (id_parent,type,`key`,TextDe,TextEn,TextFr,date) values(?,?,?,?,?,?,?) on duplicate key update date=if(find_in_set(?,date),date,concat(date,',',?))", [$items['id_parent'], $items['type'], $items['key'], $items['value'], $items['value'], $items['value'], $items['date'], $items['date'], $items['date']]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Select id from the database.
     *
     * Select id from db for type,key and id_parent
     *
     * @param int $id_parent parent id of the reference
     * @param int $type type of the reference
     * @param string $key key name of the reference
     * @return Model|Builder|object|null
     */
    public function selectIdForTypeKeyParentId(int $id_parent, int $type, string $key)
    {
        return DB::table($this->mobConf->getTable())
            ->select('id')->where('id_parent', $id_parent)
            ->where('type', '=', $type)
            ->where('key', '=', $key)
            ->first();
    }

    /**
     * Select mobileItem from the database.
     *
     * Select mobile item from the database for teh type and id_parent
     *
     * @param string $textLang text column name
     * @param int $type type of the reference
     * @param int $id_parent parent id of the reference
     * @return Collection collection of data item from the db
     */
    public function selectMobileItemForTypeAndParentId(string $textLang, int $type, int $id_parent): Collection
    {

        return DB::table($this->mobConf->getTable())
            ->select('key', $textLang)->where('type', '=', $type)
            ->where('id_parent', '=', $id_parent)
            ->get();
    }

    /**
     * Select key from the database.
     *
     * Select key from the database for type
     *
     * @param string $textLang text column name
     * @param int $type type of the reference
     * @return Collection collection of data item from the db
     */
    public function selectKeyForType(string $textLang, int $type): Collection
    {
        return DB::table($this->mobConf->getTable())
            ->select('key', $textLang)
            ->where('type', '=', $type)
            ->get();
    }

    /**
     * Select id from the database.
     *
     * Select id from the database for type and key
     *
     * @param int $type type of the reference
     * @param string $key key name of the reference
     * @return Model|Builder|object|null
     */
    public function selectIdForTypeAndKey(int $type, string $key)
    {
        return DB::table($this->mobConf->getTable())
            ->select('id')
            ->where('type', '=', $type)
            ->where('key', '=', $key)
            ->first();
    }

    /**
     * Select all mobile item from the database.
     * 
     * Select all mobile item from the database for the given type
     * 
     * @param int $type type of the mobile item
     * @return Collection collection of data item from the db
     */
    public function selectAllforType(int $type): Collection
    {
        return DB::table($this->mobConf->getTable())
            ->where('type', '=', $type)
            ->get();
    }
    /**
     * Select mobile item for the parent id from db.
     * 
     * Select mobile item for the given type and parent id from db
     * 
     * @param int $type type of the mobile item
     * @param int $id_parent parent id of the mobile item
     * @return Collection collection of data item from the db
     */
    public function selectItemByParentId(int $type, int $id_parent): Collection
    {
        return DB::table($this->mobConf->getTable())
            ->where('type', '=', $type)
            ->where('id_parent', '=', $id_parent)
            ->get();
    }
}
