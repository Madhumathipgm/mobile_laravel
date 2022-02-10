<?php

namespace App\Http\Controllers;

class MobileRefServiceController extends Controller
{
    private $httpRequest;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->httpRequest = new HttpRequestController();
    }

    /**
     * Fetch class references from the website
     *
     * @param string $lang language
     * @return array of the  class references
     */
    public function fetchClasses(string $lang): array
    {
        return $this->httpRequest->readUrl('/refdata/sites/GERMANY/classes', $lang);
    }

    /**
     * Fetch category references from the website
     *
     * @param string $class name of the class
     * @param string $lang language
     * @return array of the references
     */
    public function fetchCategories(string $class, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/categories", $lang);
    }

    /**
     * Fetch make references from the website
     *
     * @param string $class name of the class
     * @param string $lang language
     * @return array of the references
     */
    public function fetchMakes(string $class, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/makes", $lang);
    }

    /***
     * Fetch model references from the website
     *
     * @param string $class name of the class
     * @param string $make name of the make
     * @param string $lang language
     * @return array of the references
     */
    public function fetchModels(string $class, string $make, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/makes/{$make}/models", $lang);
    }

    /**
     * Fetch modelGroup references from the website
     *
     * @param string $class name of the class
     * @param string $make name of the make
     * @param string $lang language
     * @return array of the references
     */
    public function fetchModelGroups(string $class, string $make, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/makes/{$make}/modelgroups", $lang);
    }

    /***
     * Fetch model of model Group references from the website
     *
     * @param string $class name of the class
     * @param string $make name of the make
     * @param string $modelGroup name of the model group
     * @param string $lang language
     * @return array of the references
     */
    public function fetchModelOfModelGroups(string $class, string $make, string $modelGroup, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/makes/{$make}/modelgroups/{$modelGroup}/models", $lang);
    }

    /**
     * Fetch  model Range references from the website
     *
     * @param string $class name of the class
     * @param string $make name of the make
     * @param string $model name of the model
     * @param string $date date of the reference
     * @param string $lang language
     * @return array of the references
     */
    public function fetchModelRanges(string $class, string $make, string $model, string $date, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/makes/{$make}/models/{$model}/modelranges?firstregistration={$date}", $lang);
    }

    /**
     * Fetch  trimline references from the website
     *
     * @param string $class name of the class
     * @param string $make name of the make
     * @param string $model name of the model
     * @param string $date date of the reference
     * @param string $lang language
     * @return array of the references
     */
    public function fetchTrimLines(string $class, string $make, string $model, string $date, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/makes/{$make}/models/{$model}/trimlines?firstregistration={$date}", $lang);
    }

    /**
     * Fetch used car seal references from the website
     *
     * @param string $class name of the class
     * @param string $lang language
     * @return array of the references
     */
    public function fetchUsedCarSeals(string $class, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/usedcarseals", $lang);
    }

    /**
     * Fetch feature references from the website
     *
     * @param string $class name of the class
     * @param string $lang language
     * @return array of the references
     */
    public function fetchFeatures(string $class, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/sites/GERMANY/classes/{$class}/features", $lang);
    }
    /**
     * Fetch all the attribute references from the website.
     * 
     *@param string $attribute name of the attribute
     * @param string $lang language
     * @return array of the references
     */
    public function fetchAttributes(string $attribute, string $lang): array
    {
        return $this->httpRequest->readUrl("/refdata/{$attribute}", $lang);
    }
}
