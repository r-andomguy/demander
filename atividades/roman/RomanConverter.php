<?php

class RomanConverter {
    public array $romanLetters;
    public function __construct() {
        $this->romanLetters = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];
    }

    public function convertToRoman(int $number): string {
        if ($number === 0) {
            return 'Impossível converter valor zero.';
        } elseif ($number < 0){
            return 'Os algarismos romanos não representam números negativos.';
        } elseif (empty($number)){
            return 'Por favor, insira um valor para ser convertido.';
        }

        $integer = $number;
        $converted = '';
        
        foreach ($this->romanLetters as $romanLetter => $value) {
            $matches = intval($number / $value);
            $converted .= str_repeat($romanLetter, $matches);
            $number %= $value;
        }

        return 'O número ' . $integer . ' convertido para algarismo romano: ' . $converted;
    }
    
    public function convertToInteger(string $roman): string {
        $converted = 0;

        foreach ($this->romanLetters as $romanLetter => $value){
            while(strpos($roman, $romanLetter) === 0){
                $converted += $value;
                $roman = substr($roman, strlen($romanLetter));
            }
        }

        return 'O algarismo romano ' . $roman . ' convertido para inteiro: ' . $converted;
    }
}
