<?php
class CarFood
{
    public function add($alimento, $kcal, $proteina, $lipideo, $carbohidrato){
        if(!isset($_SESSION['alimento'])){
            $_SESSION['alimento'] = [];
            
        }

        if(!isset($_SESSION['alimento'][$alimento])){
            $_SESSION['alimento'][$alimento] = [$alimento, $kcal, $proteina, $lipideo, $carbohidrato];
            
        }else {

            $_SESSION['alimento'][$alimento][1] += $kcal;
            $_SESSION['alimento'][$alimento][2] += $proteina;
            $_SESSION['alimento'][$alimento][3] += $lipideo;
            $_SESSION['alimento'][$alimento][4] += $carbohidrato;

        }
    }  

    public function list($values, $number){
        $total = [];
        foreach($values as $item => $index) {

            array_push($total, $index[$number]);
                    
        }
        return $total;
    }

    public function remove($alimento){
        if(isset($_SESSION['alimento'][$alimento])){
            unset($_SESSION['alimento'][$alimento]);
            
        }
    }

    public function sumAll($values, $number){

        $total = [];
        foreach($values as $item => $index) {

            array_push($total, $index[$number]);
                    
        }
        return array_sum($total);
    }

    public function clear(){
        if(isset($_SESSION['alimento'])){
            unset ($_SESSION['alimento']);
        }
    }

    public function cart(){
        if(isset($_SESSION['alimento'])){
            return $_SESSION['alimento'];
        } else {
            return [];
        }
    }

    public function dump(){
        if(isset($_SESSION['alimento'])){
            echo'<pre>';
            var_dump($_SESSION['alimento']);
            echo'</pre>';
        }
    }
}