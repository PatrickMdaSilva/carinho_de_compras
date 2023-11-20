<?php

class Model
{
    public function responseJSON(array $array)
    {

        return json_encode($array);
    }

    public function arrayJSON($array)
    {

        return json_decode($array);
    }

    public function arrayJSONARRAY($array)
    {

        return json_decode($array, true);
    }

    public function returnListFood(array $array)
    {

        foreach ($array as $key => $value) {

            $order[] = "";

            array_push($order, $value->alimento);
            $arrayTotal = $this->removeIndexPar($order);
            arsort($arrayTotal);
        }
        $format = $arrayTotal;
        $final = array_reverse($format);
        return $final;
    }

    public function removeIndexPar($array)
    {
        $arrayResultante = array();

        foreach ($array as $indice => $valor) {
            // Verifica se o índice é par
            if ($indice % 2 === 1) {
                $arrayResultante[$indice] = $valor;
            }
        }

        return $arrayResultante;
    }
}
