<?php
require_once('../../autoloader.php');

try{
    //$products = '"sale":{"user":"pix", "products":[{"id":1, "quantity":1},{"id":9, "quantity":2}]}';
    $saleAttributes = json_decode($_POST['sale'], true);
    $username = $saleAttributes["user"];
    $today = date("Y-m-d");

    $sale = new Sale();
    $saleID = $sale->getLastSale() + 1;
    $total = 0;

    foreach ($saleAttributes["products"] as $saleItem){

        $product = new Product();
        $product->setId($saleItem['id']);
        $productAttributes = $product->getById();
        $product->setQuantity($productAttributes['quantity'] - $saleItem['quantity']);
        $product->update();


        $itemSubtotal = $productAttributes["price"] * $saleItem['quantity'];
        $total += $itemSubtotal;;


        $item = new SaleItem();
        $item->setFpId($saleItem['id']);
        $item->setQuantity($saleItem['quantity']);
        $item->setSubtotal($itemSubtotal);
        $item->save();

        $sale->setId($saleID);
        $sale->setFsiId($item->getId());
        $sale->save();
    }

    $ticket = new SaleTicket();
    $ticket->setFsId($saleID);
    $ticket->setFuUsername($username);
    $ticket->setDate($today);
    $ticket->setTotal($total);
    $ticket->save();

    respondWithSuccess("Se almaceno la compra correctamente");
}catch(Exception $e){
    respondWithError($e->getMessage());
}