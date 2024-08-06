<?php 

include __DIR__ . '/RomanConverter.php';
class Main {
    public RomanConverter $romanConverter;

    public function __construct(){
        $this->romanConverter = new RomanConverter();
        
    }
}