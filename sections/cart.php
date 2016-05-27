<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Carrito";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/cart.css">
</head>
<body>
<?php require_once('navbar.php'); ?>
<div id="cart">
    <h1>&iexcl;Tu carrito está vacio!</h1><br>
    <img id="game_over" src="../resources/images/icons/game_over.png" alt="game_over"><br>
    <button id="start_shopping"><img src="../resources/images/icons/1UP.png" alt=""> Empieza a Comprar</button>
</div>
<div id="options">
    <button id="btn_buy_cart_items"><img src="../resources/images/icons/buy-hand.png" alt="Hand"> Realizar Compra</button>
    <button id="btn_drop_cart"><img src="../resources/images/icons/trash_can.png" alt="Trash"> Vaciar Carrito</button>
    <button id="btn_shop"><img src="../resources/images/icons/tag.png" alt="Shop"> Seguir Comprando</button>
</div>
<?php require_once('scripts.php'); ?>
<script>

    function proccessSale(){
        var items = JSON.parse(cookieManager.getValue('cart'));
        var total = 0;
        var ticket = newDiv();
        var table = newTable();
        var headerRow = newTableHeader(['ID', 'NOMBRE', 'PRECIO', 'CANTIDAD', 'SUBTOTAL']);
        table.appendChild(headerRow);

        for (var key in items) {
            if (items.hasOwnProperty(key)) {
                var current = items[key];
                var row = newTableRow([current['id'], current['name'], current['price'], current['cart_quantity'], current['subtotal']]);
                total += current['subtotal'];
                table.appendChild(row);
            }
        }
        var paragraph = newParagraph('TOTAL A PAGAR : $' + total);

        ticket.appendChild(table);
        ticket.appendChild(paragraph);

        notifier.expectsHTMLContent();
        notifier.setTheme(MODAL_GREEN);
        notifier.confirm(
            '¿Desea realizar su compra?',
            ticket.outerHTML,
            function(confirm){
                if(confirm){
                    buyItems();
                }
            }
        );
    }

    function buyItems(){
        var cart = [];
        var cartItems = JSON.parse(cookieManager.getValue('cart'));
        for (var key in cartItems) {
            if (cartItems.hasOwnProperty(key)) {
                var cartItem = {};
                cartItem['id'] = cartItems[key]['id'];
                cartItem['quantity'] = cartItems[key]['cart_quantity'];
                cart.push(cartItem);
            }
        }
        var ticketData = {};
        ticketData['user'] = JSON.parse(cookieManager.getValue('user'))['username'];
        ticketData['products'] = JSON.stringify(cart);

        ajax.post(
            '../server/action/sale/new.php',
            ticketData,
            function(){
                notifier.alert(
                    'Gracias!',
                    'Gracias por tu compra',
                    function(){
                        dropCart();
                        refreshPage();
                    }
                );
            },
            function(error){
                notifier.setTheme(MODAL_RED);
                notifier.alert(
                    'Lo Sentimos!',
                    error,
                    function(){}
                );
            }
        );
    }

    function showCartItems(data) {
        var table = newTable( newTableHeader(['IMAGEN','ID','NOMBRE','PRECIO','CANTIDAD','SUBTOTAL','']) );
        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                var product = data[key];
                var deleteButton = newButton('X', deleteItem);
                deleteButton.setAttribute('data-id', product['id']);
                var image = newImg(product['image']);
                image.style.width = '50px';
                image.style.height = '50px';

                var numberPicker = newSelect('quantity_picker', 'quantity_picker');
                numberPicker.setAttribute('data-id', product['id']);
                numberPicker.onchange = changeQuantity;
                var options = [];
                for(var i=1; i <= parseInt(product['quantity']); i++)
                {
                    var option = newOption(i,i);
                    if(i == product['cart_quantity']){
                        option.selected = true;
                    }
                    options.push(option);
                }
                appendItemsTo(numberPicker, options);
                numberPicker.value = product['cart_quantity'];

                var td = newElement('td',product['subtotal']);
                td.id = product['id'] + '_subtotal';
                td.setAttribute('data-role', 'picker');
                
                var row =
                    newTableRow([ image, product['id'], product['name'], product['price'], numberPicker,td , deleteButton]);
                table.appendChild(row);
            }
        }
        findViewById('cart').appendChild(table);
    }

    function dropCart() {
        cookieManager.erase('cart');
        refreshPage();
    }

    function changeQuantity(){
        var productID = this.getAttribute('data-id');
        var subtotalCell = findViewById(productID + '_subtotal');
        clearElement(subtotalCell);
        var cart = cookieManager.getValue('cart');
        var cartItems = JSON.parse(cart);
        var product = cartItems[productID];
        var subtotal = product['price'] * this.value;
        appendText(subtotalCell, subtotal);
        product['subtotal'] = subtotal;
        product['cart_quantity'] = this.value;
        cartItems[productID] = product;
        cookieManager.setValue('cart', JSON.stringify(cartItems));
    }

    function deleteItem(){
        var keys = [];
        var id = this.getAttribute('data-id');
        var cart = JSON.parse(cookieManager.getValue('cart'));
        for (var key in cart) {
            if(cart.hasOwnProperty(key)){
                keys.push(key);
            }
        }
        var cartHasOneItem = keys.length == 1;
        if( cartHasOneItem ){
            dropCart();
        }else{
            delete cart[id];
            cookieManager.setValue('cart', JSON.stringify(cart));
            refreshPage();
        }
    }

    window.onload = function(){
        if( cookieManager.check('cart')){
            clearElement(findViewById('cart'));
            showCartItems(JSON.parse(cookieManager.getValue('cart')));

            findViewById('btn_buy_cart_items').onclick = function(){
                proccessSale();
            };

            findViewById('btn_drop_cart').onclick = function(){
                dropCart();
            };

            findViewById('btn_shop').onclick = function(){
                redirectTo('catalog.php');
            };
        }else{
            clearElement(findViewById('options'));
            findViewById('start_shopping').onclick = function () {
                redirectTo('catalog.php');
            }
        }
    }
</script>
</body>
</html>