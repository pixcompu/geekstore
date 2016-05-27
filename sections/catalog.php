<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Catálogo";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/catalog.css">
    <style>
        a[href='catalog.php']{
            color: white;
            background-color: black;
        }
    </style>
</head>
<body>
<?php require_once('navbar.php'); ?>
<div id="catalog"></div>
<?php require_once('scripts.php'); ?>
<script>
    window.onload = init;
    function init(){
        ajax.expectJsonProperties(['status']);
        ajax.get(
                '../server/action/product/get.php',
                onFetchSuccess,
                onFetchFailure
        );
    }

    function onFetchSuccess(response){
        if( response.status == 'success') {
            var data = response.data;
            showCatalog( data );
        }else{
            onFetchFailure(response.description);
        }
    }

    function onFetchFailure(error){
        appendLog('FETCH-CATALOG', error);
    }

    function showCatalog(data) {
        var catalog = document.getElementById('catalog');
        catalog.style.display = 'inline-block';
        for(var i = 0; i < data.length; i++){
            var current = data[i];
            var card = getCard( current );
            catalog.appendChild(card);
        }
    }

    function getCard( product ){
        var card = newDiv();
        addClassTo(card, 'card');
        addClassTo(card, 'shadow-depth-light');

        var image = newImg(product['image']);
        addClassTo(image, 'border-tlr-radius');
        addClassTo(image, 'card-image');

        var title = newH4(product['name']);
        var price = newParagraph('$' + product['price']);
        var buttonCart = newButton('Agregar al carrito', addItem);
        addClassTo(buttonCart, 'action-button')
        buttonCart.setAttribute( 'data-item', JSON.stringify(product) );

        var buttonDetails = newButton('Detalles', showDetails);
        addClassTo(buttonDetails, 'action-button')
        buttonDetails.setAttribute('data-item', JSON.stringify(product));

        appendItemsTo( card, [image, title, price, buttonCart, buttonDetails] );
        return card;
    }

    function addItem(){
        var jsonItem = this.getAttribute('data-item');
        if( !cookieManager.check('cart')){
            cookieManager.create('cart', JSON.stringify({}), 60 )
        }
        var items = JSON.parse(cookieManager.getValue('cart'));
        var item = JSON.parse(jsonItem);
        item['cart_quantity'] = 1;
        item['subtotal'] = item['cart_quantity'] * item['price'];
        items[item['id']] = item;
        cookieManager.setValue('cart', JSON.stringify(items));
        redirectTo('cart.php');
    }

    function showDetails(){
        var product = JSON.parse(this.getAttribute('data-item'));
        var detailsPanel = newDiv();
        var image = newImg(product['image']);
        var title = newH2(product['name']);
        var description = newParagraph(product['description']);
        var price = newParagraph('Precio : $' + product['price']);
        var existance = newParagraph('En existencia : ' + product['quantity']);
        var buttonCart = newButton('Agregar a mi carrito', null);
        buttonCart.setAttribute( 'data-item', JSON.stringify(product) );
        buttonCart.onclick = addItem;

        addClassTo(detailsPanel, 'details-panel');
        addClassTo(image, 'details-panel-image');

        appendItemsTo(
            detailsPanel,
            [image, title, description, price, existance, buttonCart]
        );

        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_YELLOW );
        notifier.alert( 'Detalles del producto', detailsPanel.outerHTML );
    }
</script>
</body>
</html>
