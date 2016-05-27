<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Catálogo";
    require_once('header.php');
    ?>
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
        card.style.textAlign = 'center';
        card.style.width = '20%';
        card.style.borderRadius = '5px';
        card.style.margin = '10px';
        card.style.padding = '10px';
        card.style.border = 'solid';
        card.style.float = 'left';

        var image = newImg(product['image']);
        image.style.width = '80%';

        var title = newH4(product['name']);
        var price = newParagraph('Precio : $' + product['price']);

        var buttonCart = newButton('Agregar a mi carrito', addItem);
        buttonCart.setAttribute( 'data-item', JSON.stringify(product) );

        var buttonDetails = newButton('Ver Detalles', showDetails);
        buttonDetails.setAttribute('data-item', JSON.stringify(product));

        appendItemsTo( card,
                [image, title, price, buttonCart, buttonDetails] );

        return card;
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

        detailsPanel.style.overflow = 'hidden';
        image.style.width = '40%';
        image.style.float = 'left';

        appendItemsTo(detailsPanel,
                [image, title, description, price, existance, buttonCart]
        );

        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_YELLOW );
        notifier.alert(
                'Detalles del producto',
                detailsPanel.outerHTML
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

    function onFetchFailure(error){
        appendLog('FETCH', error);
    }
</script>
</body>
</html>