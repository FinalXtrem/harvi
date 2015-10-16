<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\helpers\Json;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionApi($method, $url, $data = false, $verbose = true)
    {
        echo 'data : '.$data."\n";
        //print_r(Json::decode($this->callAPI($method, $url, $data, $verbose)));
        echo "\n";
    }

    function callAPI($method, $url, $data = false, $verbose = true)
    {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data && (is_array($data) || is_object($data)) && $data != 'false') {
                    echo "masuk\n";
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        // Optional Authentication:
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        $arr_url = explode('/', $url);
        if (strpos($url, '//') != false) {
            $origin = $arr_url[0].'//'.$arr_url[2];
        }else{
            $origin = $arr_url[0];
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Origin: '.$origin,
            'Access-Control-Request-Method: '.$method,
            'Access-Control-Headers: X-Requested-With'
        ]);
        curl_setopt($curl, CURLOPT_VERBOSE, $verbose);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}
