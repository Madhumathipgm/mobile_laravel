<?php

namespace App\Http\Controllers;


use App\Models\MobileConfiguration;
use App\Models\MobileRefDataItem;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Request;

use function PHPUnit\Framework\isEmpty;

/**
 * Controller Class to get user request and get the required data .
 */
class MobileController extends Controller
{

    private $mobConf;
    private $mobileStorage;
    private $mobileService;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->mobConf = new MobileConfiguration();
        $this->mobileStorage = new MobileRefDataStorageController();
        $this->mobileService = new MobileRefServiceController();
    }

    /**
     * Load the class references.
     *
     * Get the references from mobile for class type
     *
     */
    public function loadClass()
    {
        $itemsDe = $this->mobileService->fetchClasses(MobileConfiguration::getLang()['de']);
        $itemsEn = $this->mobileService->fetchClasses(MobileConfiguration::getLang()['en']);
        $itemsFr = $this->mobileService->fetchClasses(MobileConfiguration::getLang()['fr']);
        foreach ($itemsDe as $key => $value) {
            $id_class = $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => 0, 'type' => MobileRefDataItem::_CLASS, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
            //$this->loadCategories($key, $id_class);
            //$this->loadUsedCarSeals($key, $id_class);
            //$this->loadFeatures($key, $id_class);
            $this->loadMakes($key, $id_class);
        }
    }

    /**
     * Load the category references.
     *
     * Get the references from mobile for category type
     *
     *
     * @param string $class_key key of the class
     * @param int $id_parent id of the class
     */
    private function loadCategories(string $class_key, int $id_parent)
    {
        $itemsDe = $this->mobileService->fetchCategories($class_key, $this->mobConf->getLang()['de']);
        $itemsEn = $this->mobileService->fetchCategories($class_key, $this->mobConf->getLang()['en']);
        $itemsFr = $this->mobileService->fetchCategories($class_key, $this->mobConf->getLang()['fr']);
        foreach ($itemsDe as $key => $value) {
            $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => $id_parent, 'type' => MobileRefDataItem::_CATEGORY, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
        }
    }

    /**
     * Load the make references.
     *
     * Get the references from mobile for make type
     *
     *
     * @param string $class_key key of the class
     * @param int $id_parent id of the class
     */
    private function loadMakes(string $class_key, int $id_parent)
    {
        $itemsDe = $this->mobileService->fetchMakes($class_key, $this->mobConf->getLang()['de']);
        $itemsEn = $this->mobileService->fetchMakes($class_key, $this->mobConf->getLang()['en']);
        $itemsFr = $this->mobileService->fetchMakes($class_key, $this->mobConf->getLang()['fr']);
        foreach ($itemsDe as $key => $value) {
            $id = $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => $id_parent, 'type' => MobileRefDataItem::_MAKE, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
            if ($key === "AUDI") {
                $this->loadModels($class_key, $key, $id);
            }



            //$this->loadModelGroups($class_key, $key, $id);
        }
    }

    /**
     * Load the model references.
     *
     * Get the references from mobile for model type
     *
     *
     * @param string $class_key key of the class
     * @param string $make_key key of the make
     * @param int $id_parent id of the make
     */
    private function loadModels(string $class_key, string $make_key, int $id_parent)
    {
        $itemsDe = $this->mobileService->fetchModels($class_key, $make_key, $this->mobConf->getLang()['de']);
        $itemsEn = $this->mobileService->fetchModels($class_key, $make_key, $this->mobConf->getLang()['en']);
        $itemsFr = $this->mobileService->fetchModels($class_key, $make_key, $this->mobConf->getLang()['fr']);
        var_dump($itemsEn);
        foreach ($itemsDe as $key => $value) {
            $id = $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => $id_parent, 'type' => MobileRefDataItem::_MODEL, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
            $this->loadModelRangesAndTrimLines($class_key, $make_key, $key, $id);
        }
    }

    /**
     * Load the model group references.
     *
     * Get the references from mobile for Model Group type
     *
     *
     * @param string $class_key key of the class
     * @param string $make_key key of the make
     * @param int $id_parent id of the make
     */
    private function loadModelGroups(string $class_key, string $make_key, int $id_parent)
    {
        $itemsDe = $this->mobileService->fetchModelGroups($class_key, $make_key, $this->mobConf->getLang()['de']);
        $itemsEn = $this->mobileService->fetchModelGroups($class_key, $make_key, $this->mobConf->getLang()['en']);
        $itemsFr = $this->mobileService->fetchModelGroups($class_key, $make_key, $this->mobConf->getLang()['fr']);
        var_dump($itemsDe);
        foreach ($itemsDe as $key => $value) {
            $id = $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => $id_parent, 'type' => MobileRefDataItem::_MODELGROUP, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
            $this->loadModelofModelGroups($class_key, $make_key, $key, $id);
        }
    }

    /**
     * Load the model of model group references.
     *
     * Get the references from mobile for model of model group type
     *
     *
     * @param string $class_key key of the class
     * @param string $make_key key of the make
     * @param string $modelGroup_key key of the modelGroup
     * @param int $id_parent id of the modelGroup
     */
    private function loadModelofModelGroups(string $class_key, string $make_key, string $modelGroup_key, int $id_parent)
    {
        $itemsDe = $this->mobileService->fetchModelOfModelGroups($class_key, $make_key, $modelGroup_key, $this->mobConf->getLang()['de']);
        $itemsEn = $this->mobileService->fetchModelOfModelGroups($class_key, $make_key, $modelGroup_key, $this->mobConf->getLang()['en']);
        $itemsFr = $this->mobileService->fetchModelOfModelGroups($class_key, $make_key, $modelGroup_key, $this->mobConf->getLang()['fr']);
        foreach ($itemsDe as $key => $value) {
            $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => $id_parent, 'type' => MobileRefDataItem::_MODEL_OF_MODEL_GROUP, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
        }
    }

    /**
     * Load the ModelRange and Trimline references.
     *
     * Set  the beginning and ending date
     * Set the interval period
     * Get the references from mobile for modelrange and trimline type
     *
     *
     * @param string $class_key key of the class
     * @param string $make_key key of the make
     * @param string $model_key key of the model
     * @param int $id_parent id of the model
     */
    private function loadModelRangesAndTrimLines(string $class_key, string $make_key, string $model_key, int $id_parent)
    {
        try {
            $end = new DateTime();
            $begin = DateTime::createFromFormat('Ym', '199201');
            $interval = new DateInterval('P1M');
            $dateRange = new DatePeriod($begin, $interval, $end);
            foreach ($dateRange as $date) {
                $date = $date->format('Ym');
                $modelRangeItems = $this->mobileService->fetchModelRanges($class_key, $make_key, $model_key, $date, $this->mobConf->getLang()['de']);
                var_dump($modelRangeItems);
                $this->getModelRangesAndTrimLinesItems($modelRangeItems, MobileRefDataItem::_MODELRANGE, $id_parent, $date);
                $trimLineItems = $this->mobileService->fetchTrimLines($class_key, $make_key, $model_key, $date, $this->mobConf->getLang()['de']);
                $this->getModelRangesAndTrimLinesItems($trimLineItems, MobileRefDataItem::_TRIMLINE, $id_parent, $date);
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Load the ModelRange and Trimline references.
     *
     * Get the references from mobile based on  given date for modelrange and trimline type
     *
     *
     * @param
     * @param int $type type of the mobile reference
     * @param int $id_parent id of the model
     * @param string $date date of the reference
     */
    private function getModelRangesAndTrimLinesItems($items, int $type, int $id_parent, string $date)
    {
        foreach ($items as $key => $value) {
            $this->mobileStorage->insertItemsWithDate(['key' => $key, 'value' => $value, 'type' => $type, 'id_parent' => $id_parent, 'date' => $date]);
        }
    }


    /**
     * Load the used car seal references.
     *
     * Get the references from mobile for used car seal type
     *
     * @param string $class_key key of the class
     * @param int $id_parent id of the class
     */
    private function loadUsedCarSeals(string $class_key, int $id_parent)
    {
        $itemsDe = $this->mobileService->fetchUsedCarSeals($class_key, $this->mobConf->getLang()['de']);
        $itemsEn = $this->mobileService->fetchUsedCarSeals($class_key, $this->mobConf->getLang()['en']);
        $itemsFr = $this->mobileService->fetchUsedCarSeals($class_key, $this->mobConf->getLang()['fr']);
        foreach ($itemsDe as $key => $value) {
            $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => $id_parent, 'type' => MobileRefDataItem::_USED_CAR_SEAL, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
        }
    }


    /**
     * Load the feature references.
     *
     * Get the references from mobile for feature type
     *
     * @param string $class_key key of the class
     * @param int $id_parent id of the class
     */
    private function loadFeatures(string $class_key, int $id_parent)
    {
        $itemsDe = $this->mobileService->fetchFeatures($class_key, $this->mobConf->getLang()['de']);
        $itemsEn = $this->mobileService->fetchFeatures($class_key, $this->mobConf->getLang()['en']);
        $itemsFr = $this->mobileService->fetchFeatures($class_key, $this->mobConf->getLang()['fr']);
        foreach ($itemsDe as $key => $value) {
            $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => $id_parent, 'type' => MobileRefDataItem::_FEATURE, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
        }
    }
    /**
     * Load all the attribute reference.
     * 
     * Get the references from mobile for all the attributes
     * 
     */
    public function loadAttributes()
    {
        $attributes = $this->mobConf->getAttributeNames();
        foreach ($attributes as $k => $v) {
            echo $k;
            $itemsDe = $this->mobileService->fetchAttributes($k, $this->mobConf->getLang()['de']);
            var_dump($itemsDe);
            $itemsEn = $this->mobileService->fetchAttributes($k, $this->mobConf->getLang()['en']);
            $itemsFr = $this->mobileService->fetchAttributes($k, $this->mobConf->getLang()['fr']);
            foreach ($itemsDe as $key => $value) {

                $this->mobileStorage->insertItems(['key' => $key, 'TextDe' => $value, 'id_parent' => 0, 'type' => $v, 'TextEn' => $itemsEn[$key], 'TextFr' => $itemsFr[$key]]);
            }
        }
    }

    /**
     * Get the required data from the database.
     *
     * Get the necessary data from the database
     *
     * @return Application|Factory|View
     */
    public function getData()
    {
        $lang = $_GET['lang'] ?? 'en';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $langs = $this->mobConf->getLang();
        $attributes = $this->mobConf->getAttributeNames();
        $classes = $this->mobileStorage->selectKeyForType($textLang, MobileRefDataItem::_CLASS);
        $categories = $this->mobileStorage->selectKeyForType($textLang, MobileRefDataItem::_CATEGORY);
        $makes = $this->mobileStorage->selectKeyForType($textLang, MobileRefDataItem::_MAKE);
        $models = $this->mobileStorage->selectKeyForType($textLang, MobileRefDataItem::_MODEL);
        $modelRanges = $this->mobileStorage->selectKeyForType($textLang, MobileRefDataItem::_MODELRANGE);
        $trimLines = $this->mobileStorage->selectKeyForType($textLang, MobileRefDataItem::_TRIMLINE);
        $data = [
            'lang' => $lang,
            'langs' => $langs,
            'text' => $textLang,
            'attributes' => $attributes,
            'queryParam' => 'dropdown',
            'classes' => $classes,
            'categories' => $categories,
            'makes' => $makes,
            'models' => $models,
            'modelRanges' => $modelRanges,
            'trimLines' => $trimLines

        ];

        return view('index', ['data' => $data]);
    }


    /**
     * Get Category item and Make item from the db.
     * 
     * Get the class value
     * Get the id for the class value from db
     * Get categories and makes for the class id value from db
     * 
     * @param string $lang  selected language
     * @return Application|Factory|View
     */
    public function getCategoryAndMake(string $lang): array
    {
        $class = $_GET['classes'] ?? 'Car';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $attributes = $this->mobConf->getAttributeNames();
        $id_class = ($this->mobileStorage->selectIdForTypeAndKey(MobileRefDataItem::_CLASS, $class)) ?? null;
        if ($id_class) {
            $categories = $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_CATEGORY, $id_class->id);
            $makes = $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_MAKE, $id_class->id);
        }
        return [
            'text' => $textLang,
            'categories' => $categories,
            'makes' => $makes,
        ];
    }

    /**
     * Get models from the db.
     * 
     * Get make value and get the id for thet make from db
     * Get id for the given class value from db
     * Get the models for the class id and make id from db
     * 
     * 
     * @param string $lang selected language
     * @param string $class name of the class
     *  @return Application|Factory|View
     */
    public function getModel(string $lang, string $class): array
    {
        $make = $_GET['makes'] ?? 'AUDI';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $attributes = $this->mobConf->getAttributeNames();
        $id_class = ($this->mobileStorage->selectIdForTypeAndKey(MobileRefDataItem::_CLASS, $class)) ?? null;
        $id_make = ($this->mobileStorage->selectIdForTypeKeyParentId($id_class->id, MobileRefDataItem::_MAKE, $make)) ?? null;
        $models = [];
        $modelGroups = [];
        if ($id_make) {
            $models = $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_MODEL, $id_make->id);
            $modelGroups = $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_MODELGROUP, $id_make->id);
        }

        return [
            'text' => $textLang,
            'models' => $models,
            'modelGroups' => $modelGroups
        ];
    }
    /**
     * Get the model of model groups value from the db.
     * 
     * Get the make value and get the id for that make from db
     * Get the id of the given class value from db
     * Get the model groups items for make id and class id values from db
     * Get the id for every model groups item from db
     * Get the model of model groups item from db for id of the model groups
     * 
     * 
     * @param string $lang selected language
     * @param string $class name of the class
     *  @return Application|Factory|View
     */

    public function getModelOfModelGroup(string $lang, string $class): array
    {
        $make = $_GET['make'] ?? 'AUDI';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $attributes = $this->mobConf->getAttributeNames();
        $id_class = ($this->mobileStorage->selectIdForTypeAndKey(MobileRefDataItem::_CLASS, $class)) ?? null;
        $id_make = ($this->mobileStorage->selectIdForTypeKeyParentId($id_class->id, MobileRefDataItem::_MAKE, $make)) ?? null;
        $modelGroups = $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_MODELGROUP, $id_make->id);
        $arr = [];
        foreach ($modelGroups as $group) {
            $id_modelGroup = ($this->mobileStorage->selectIdForTypeKeyParentId($id_make->id, MobileRefDataItem::_MODELGROUP, $group->key)) ?? null;
            if ($id_modelGroup) {
                $modelofModelGroup = $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_MODEL_OF_MODEL_GROUP, $id_modelGroup->id);
                $arr[$group->key] = $modelofModelGroup;
            }
        }
        return [
            'modelOfModelGroups' => $arr
        ];
    }

    /**
     * Get the model range and trimlines items from the db.
     * 
     * Get the model value and get id for that model from db
     * Get class id and make id for given class and make values from db
     * Get the model ranges and trimlines items for the model id values from db
     * 
     * 
     * @param string $lang selected language
     * @param string $class name of the class
     * @param string $make name of the make
     *  @return Application|Factory|View
     */
    public function getModelRange(string $lang, string $class, string $make)
    {
        $model = $_GET['models'] ?? 80;
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $attributes = $this->mobConf->getAttributeNames();
        $id_class = ($this->mobileStorage->selectIdForTypeAndKey(MobileRefDataItem::_CLASS, $class)) ?? null;
        $id_make = ($this->mobileStorage->selectIdForTypeKeyParentId($id_class->id, MobileRefDataItem::_MAKE, $make)) ?? null;
        if ($id_make) {
            $id_model = ($this->mobileStorage->selectIdForTypeKeyParentId($id_make->id, MobileRefDataItem::_MODEL, $model)) ?? null;
            $modelRanges = $id_model ? $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_MODELRANGE, $id_model->id) : [];
            $trimLines = $id_model ? $this->mobileStorage->selectMobileItemForTypeAndParentId($textLang, MobileRefDataItem::_TRIMLINE, $id_model->id) : [];
        }
        return [
            'text' => $textLang,
            'modelRanges' => $modelRanges,
            'trimLines' => $trimLines
        ];
    }

    /**
     * Get the all the model item from the db.
     * 
     * Get the language value 
     * For the given language select all class items from db
     * Get all the make items for the every class value from db
     * Get all the model items for the every make value from db
     * 
     * 
     *  @return Application|Factory|View
     */
    public  function getAllModels()
    {
        $lang = $_GET['lang'] ?? 'en';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $langs = $this->mobConf->getLang();
        $attributes = $this->mobConf->getAttributeNames();
        $classes = $this->mobileStorage->selectAllforType(MobileRefDataItem::_CLASS);
        foreach ($classes as $class) {
            if ($class->key !== 'Car') {
                continue;
            }
            $makes = $this->mobileStorage->selectItemByParentId(MobileRefDataItem::_MAKE, $class->id);
            foreach ($makes as $make) {
                $models = $this->mobileStorage->selectItemByParentId(MobileRefDataItem::_MODEL, $make->id);
                $modelGroups = $this->mobileStorage->selectItemByParentId(MobileRefDataItem::_MODELGROUP, $make->id);
                if (sizeof($models) === 0) {
                    continue;
                }
                $model[$make->key] = $models;

                if (sizeof($modelGroups) === 0) {
                    continue;
                }

                foreach ($modelGroups as $modelGroup) {
                    $modelOfModelGroups = $this->mobileStorage->selectItemByParentId(MobileRefDataItem::_MODEL_OF_MODEL_GROUP, $modelGroup->id);
                    foreach ($modelOfModelGroups as $modelofModelGroup) {
                        $modelOfModelGrp[$modelofModelGroup->key . $make->key] = $modelGroup;
                    }
                }
            }
            $makeItem[$class->key] = $makes;
        }

        $data = [
            'langs' => $langs,
            'lang' => $lang,
            'textLang' => $textLang,
            'attributes' => $attributes,
            'queryParam' => 'models',
            'models' => $model,
            'makes' => $makeItem,
            'classes' => $classes,
            'modelGroups' => $modelOfModelGrp,

        ];

        return view('table', ['data' => $data]);
    }

    /**
     * Get all the modelRanges and TrimLines from the db.
     * 
     * Get the id for the given model from db
     * Get the model ranges and trimlines for the given model id from db
     * 
     * 
     * @param string $model name of the model
     *  @return Application|Factory|View
     */
    public function getPackage(string $model)
    {
        $langs = $this->mobConf->getLang();
        $attributes = $this->mobConf->getAttributeNames();
        $id_model = ($this->mobileStorage->selectIdForTypeAndKey(MobileRefDataItem::_MODEL, $model)) ?? null;
        if ($id_model) {
            $modelRanges = $this->mobileStorage->selectMobileItemForTypeAndParentId('TextEn', MobileRefDataItem::_MODELRANGE, $id_model->id);

            $trimLines = $this->mobileStorage->selectMobileItemForTypeAndParentId('TextEn', MobileRefDataItem::_TRIMLINE, $id_model->id);
        }
        $data = [
            'langs' => $langs,
            'queryParam' => 'packages/' . $model,
            'attributes' => $attributes,
            'model' => $model,
            'modelRange' => $modelRanges,
            'trimLine' => $trimLines,
        ];
        return view('package', ['data' => $data]);
    }

    /**
     * Get all categories from the db.
     * 
     * Get the all the class items from db.
     * Get the all categories for eveery class item value
     * 
     * 
     *  @return Application|Factory|View
     */
    public function getCategories()
    {
        $langs = $this->mobConf->getLang();
        $attributes = $this->mobConf->getAttributeNames();
        $lang = $_GET['lang'] ?? 'en';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $classes = $this->mobileStorage->selectAllforType(MobileRefDataItem::_CLASS);
        foreach ($classes as $class) {
            $categories = $this->mobileStorage->selectItemByParentId(MobileRefDataItem::_CATEGORY, $class->id);
            $category[$class->key] = $categories;
        }
        $data = [
            'langs' => $langs,
            'text' => $textLang,
            'attributes' => $attributes,
            'queryParam' => 'categories',
            'classes' => $classes,
            'categories' => $category
        ];
        return view('classProperty', ['data' => $data]);
    }

    /**
     * Get all the used car seal items from the db.
     * 
     * Get the all class items from db 
     * Get the all used car seal items for every class item value from db
     * 
     * 
     *  @return Application|Factory|View
     */
    public function getUsedCarSeals()
    {
        $langs = $this->mobConf->getLang();
        $lang = $_GET['lang'] ?? 'en';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $attributes = $this->mobConf->getAttributeNames();
        $classes = $this->mobileStorage->selectAllforType((MobileRefDataItem::_CLASS));
        foreach ($classes as $class) {
            $usedCarSeals = $this->mobileStorage->selectItemByParentId(MobileRefDataItem::_USED_CAR_SEAL, $class->id);

            $carSeal[$class->key] = $usedCarSeals;
        }
        $data = [
            'langs' => $langs,
            'text' => $textLang,
            'queryParam' => 'carSeals',
            'attributes' => $attributes,
            'classes' => $classes,
            'carSeals' => $carSeal

        ];
        return view('classProperty', ['data' => $data]);
    }

    /**
     * Get the all Features from db.
     * 
     * Get all the class ietms from the db.
     * Get the all features items for every class item from db
     * 
     * 
     *  @return Application|Factory|View
     */
    public function getFeatures()
    {
        $langs = $this->mobConf->getLang();
        $lang = $_GET['lang'] ?? 'en';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $attributes = $this->mobConf->getAttributeNames();
        $classes = $this->mobileStorage->selectAllforType((MobileRefDataItem::_CLASS));
        foreach ($classes as $class) {
            $features = $this->mobileStorage->selectItemByParentId(MobileRefDataItem::_FEATURE, $class->id);

            $feature[$class->key] = $features;
        }
        $data = [
            'langs' => $langs,
            'text' => $textLang,
            'queryParam' => 'features',
            'attributes' => $attributes,
            'classes' => $classes,
            'features' => $feature

        ];
        return view('classProperty', ['data' => $data]);
    }
    /**
     * Get All attributes fro  the db.
     * 
     * Get the selected language
     * Get attribute type for given attribute name
     * Get the values for given attribute name
     * 
     * 
     * @param string $attribute name of the attribute
     *  @return Application|Factory|View
     */
    public function getAttributes(string $attribute)
    {
        $langs = $this->mobConf->getLang();
        $lang = $_GET['lang'] ?? 'en';
        $textLang = $lang ? $this->mobConf->getText($lang) : 'TextEn';
        $attributes_arr = $this->mobConf->getAttributeNames();
        $attribue_val = $this->mobileStorage->selectAllforType($attributes_arr[$attribute]);
        $data = [
            'langs' => $langs,
            'text' => $textLang,
            'queryParam' => 'attributes/' . $attribute,
            'attributes' => $attributes_arr,
            'values' => $attribue_val,
            'attribute' => $attribute

        ];
        return view('attributes', ['data' => $data]);
    }
}
