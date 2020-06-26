<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeatherController extends AbstractController

{
    /**
     * 
     * @Route("/", name = "homepage")
     *Ville par défaut : Toulouse
     * @return Response
     */
    public function home()
    {

        if (isset($_GET["cityName"]) && !empty($_GET["cityName"])) {
            $city = $_GET["cityName"];
        } else {
            $city = "toulouse";
        }

        $apikey = "414b257404b288f8c01d872b852f8ede";
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&lang=fr&units=metric&appid={$apikey}";

        $contents = file_get_contents($url);
        $data = json_decode($contents);


        // print_r($url);

        return $this->render(
            'weather.html.twig',
            [
                "cityName" => $city,
                "description" => $data->weather[0]->description,
                "temperature" => $data->main->temp,
                "tempMin" => $data->main->temp_min,
                "tempMax" => $data->main->temp_max,
                "date" => date("Y-m-d H:i:s")
            ]
        );
    }
}
