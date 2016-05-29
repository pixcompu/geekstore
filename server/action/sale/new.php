<?php
require_once('../../autoloader.php');

$executor = null;
try{

    validateFields(array(
        'user' => 'Tuvimos un problema accediendo a tu cuenta',
        'products' => 'Tuvimmos un problema accediendo a tu pedido'
    ));

    $username = $_POST["user"];
    $today = date("Y-m-d");

    $sale = new Sale();
    $saleID = $sale->getLastSale() + 1;
    $total = 0;

    $saleItems = json_decode($_POST["products"], true);
    $executor = $sale->getExecutor();
    $executor->startTransaction();

    foreach ($saleItems as $saleItem){

        $product = new Product();

        $product->setId($saleItem["id"]);
        $productAttributes = $product->getById();

        if($productAttributes["quantity"] < $saleItem["quantity"]){
            throw new SystemException(SALE_ABORTED, 'No tenemmos suficientes ' . $productAttributes["name"] . ' para registrar tu compra en este momento, nos quedan ' . $productAttributes["quantity"]);
        }
        $product->setQuantity($productAttributes["quantity"] - $saleItem["quantity"]);
        $product->update();

        $itemSubtotal = $productAttributes["price"] * $saleItem['quantity'];
        $total += $itemSubtotal;

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

    $executor->endTransaction(WITH_SUCCESS);
    respondWithSuccess("Se almaceno la compra correctamente");

}catch(Exception $e){
    if($executor != null){
        $executor->endTransaction(WITH_FAILURE);
    }
    if( $e->getCode() == SALE_ABORTED || $e->getCode() == NOT_FOUND || $e->getCode() == FIELD_NOT_FOUND) {
        respondWithError($e->getMessage());
    }else{
        respondWithError('Revisa tu conexion a internet');
    }
}