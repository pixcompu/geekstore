<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 24/04/2016
 * Time: 12:15 AM
 */
require_once 'autoloader.php';

$product = new Product();
//$product->setName('Capa de invisibilidad');
//$product->setDescription('Capa de invisivilidad usada en la pelicula de Harry Potter');
//$product->setSlug('p-0');
//$product->setImage('resources/images/catalog/capa_harry.jpg');
//$product->setQuantity(10);
//$product->setPrice(99);
//
//$product->save();
//
//$product->setName('Pokebola Normal');
//$product->setDescription('Pokebola de pokemón lista para atraparlo newHyperLink todos');
//$product->setSlug('p-1');
//$product->setImage('resources/images/catalog/pokebola.jpg');
//$product->setQuantity(10);
//$product->setPrice(150);
//
//$product->save();

$product->setName('Mascara de Loki');
$product->setDescription('La máscara usada por Jim Carrey en la película, La máscara');
$product->setSlug('p-2');
$product->setImage('resources/images/catalog/mascara.jpg');
$product->setQuantity(20);
$product->setPrice(500);

$product->save();

//$product = new Product();
//$products = $product->all();
//foreach ($products as $product){
//    echo json_encode($product, JSON_UNESCAPED_SLASHES, JSON_UNESCAPED_UNICODE);
//}