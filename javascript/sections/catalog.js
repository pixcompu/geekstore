/**
 * Created by Elsy on 27/05/2016.
 */
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

 function onSearchSuccess(response){
     var catalog = document.getElementById('catalog');
     clearElement(catalog);
     onFetchSuccess(response);
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

     var addImage = newImg('../resources/images/icons/cart-plus.png');
     addClassTo(addImage, 'button-image');
     var buttonCart = newButton('', addItem);
     buttonCart.appendChild(addImage);
     addClassTo(buttonCart, 'action-button')
     buttonCart.setAttribute( 'id' , 'addToCart' );
     buttonCart.setAttribute( 'data-item', JSON.stringify(product) );

     var detailImage = newImg('../resources/images/icons/eye.png');
     addClassTo(detailImage, 'button-image');
     var buttonDetails = newButton('', showDetails);
     buttonDetails.appendChild(detailImage);
     addClassTo(buttonDetails, 'action-button')
     buttonDetails.setAttribute( 'id' , 'viewDetails' );
     buttonDetails.setAttribute('data-item', JSON.stringify(product));

     appendItemsTo( card, [image, title, price, buttonCart, buttonDetails] );
     return card;
 }

 function addItem(){

     var itemSelected = JSON.parse(this.getAttribute('data-item'));
     var selectedID = itemSelected['id'];
     if( !cookieManager.check('cart')){
         cookieManager.create('cart', JSON.stringify({}), 60 )
     }
     var cartItems = JSON.parse(cookieManager.getValue('cart'));

     var isInCart = false;
     for ( var id in cartItems ) {
         if( cartItems.hasOwnProperty(id) ){
             if(id == itemSelected['id']){
                isInCart = true;
                 break;
             }
         }
     }

     if( isInCart ){
         var cartItem = cartItems[selectedID];
         itemSelected['cart_quantity'] = cartItem['cart_quantity'] + 1;
         itemSelected['subtotal'] = parseFloat(cartItem['subtotal']) + parseFloat(itemSelected['price']);
     }else{
         itemSelected['cart_quantity'] = 1;
         itemSelected['subtotal'] = itemSelected['price'];
     }
     cartItems[selectedID] = itemSelected;
     cookieManager.setValue('cart', JSON.stringify(cartItems));
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

 function search(){
     var params = {};
     params['search'] = findViewById('search').value;
     ajax.expectJsonProperties(['status']);
     ajax.post(
             '../server/action/product/get.php',
             params,
             onSearchSuccess,
             onFetchFailure
     );
 }
