<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class HttpRequestController extends Controller
{

    private static $url="https://services.mobile.de";

    /**
     * Read given url.
     *
     * Indicate the return content and add the header parameters
     * Issue get request for given url
     * Get the body of the reference
     *
     * @param string $subUrl string url
     * @param string $language language for the http header
     * @return array|null array of items
     */
    public static function readUrl(string $subUrl,string $language): ?array
    {
        $response=Http::accept('application/vnd.de.mobile.api+json')->withHeaders(['Accept-Language'=>$language])->get(self::$url.$subUrl);
        if($response){
            $content=$response->body();
            if($content){
                return (new HttpRequestController)->decode($content);
            }
        }
        return null;
    }

    /**
     * Decode the string.
     *
     * Decode the given content and get the values
     *
     * @param string $content
     * @return array of items
     */
    private function decode(string $content): array
    {
        $data=[];
        $content=json_decode($content,true);
        if($content!=null){

            $json=$content['values'];
            foreach ($json as $item){
                $data[$item['name']]=$item['description']??$item['name'];
            }
        }
        return $data;
    }

}
