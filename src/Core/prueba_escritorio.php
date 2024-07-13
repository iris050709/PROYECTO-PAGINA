<?php

//1. Función callable
function myFunction() {
    echo "Hola, soy una función callable!";//FUNCION QUE IMPRIME UN MENSAJE
}
//SE ASIGNA LA FUNCION A LA VARIABLE
$mw = 'myFunction';
//CODIGO
if (is_callable($mw)) {
    call_user_func($mw);
} else {
    echo "Error: \$mw no es una función callable";
} //SOLO IMPRIME  "Hola, soy una función callable!".



/*
//2. Array con clase y método
//SE CREA UNA CLASE CON UN MÉTODO
class Clase1 {
    public function Metodo1() {
        echo "Hola, soy un método de una clase!";
    }
}
//SE ASIGNA EL ARREGLO Y EL METODO A LA VARIABLE

$mw = [Clase1::class, 'Metodo1'];

if (is_callable($mw)) {
   // No se llama a call_user_func aquí porque $mw no es una función callable
   echo "Error: \$mw no es una función callable";
} else if (is_array($mw) && count($mw) == 2) {
    list($class, $method) = $mw;
    if (class_exists($class) && method_exists($class, $method)) {
        $obj = new $class;
        call_user_func([$obj, $method]);
    } else {
        echo "Error: el método $method no existe en la clase $class";
    }
} else {
    echo "Error: \$mw no es un arreglo válido"; 
} //SOLO IMPRIME "Hola, soy un método de una clase!".
*/


/*
//3. Array con clase y método no existente
class MyClass { 
    public function myMethod() { 
        echo "Hola, soy un método de una clase!"; 
    } 
} 
$mw = [MyClass::class, 'noexisteelmetodo']; 
if (is_callable($mw)) { 
    // No se llama a call_user_func aquí porque $mw no es una función callable 
    echo "Error: \$mw no es una función callable"; 
} else if (is_array($mw) && count($mw) == 2) { 
    list($class, $method) = $mw; 
    if (class_exists($class) && method_exists($class, $method)) { 
        // No se llama a call_user_func aquí porque el método no existe 
        echo "Error: el método $method no existe en la clase $class"; 
    } else { 
        echo "Error: el método $method no existe en la clase $class"; } 
} else { 
    echo "Error: \$mw no es un arreglo válido"; 
} // AL EJECUTAR EL CODIGO SE DEBE DE MOSTRAR "Error: el método noexisteelmetodo no existe en la clase MyClass"
*/


/*
//4. Valor no callable ni arreglo
$mw = 'no es una función ni un array'; 
if (is_callable($mw)) { 
    call_user_func($mw); 
} else if (is_array($mw) && count($mw) == 2) { 
    call_user_func_array($mw[0], $mw[1]); 
} else { 
    echo "Error: \$mw no es una función callable ni un array"; 
} //AL EJECUTAR EL CODIGO MUESTRA ESO "Error: \$mw no es una función callable ni un array"; 
*/

//http://localhost/dsm31%20proyecto2/src/Core/prueba_escritorio.php