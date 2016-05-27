<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $sectionTitle = "GeekStore - Productos";
    require_once('header.php');
    ?>
    <link rel="stylesheet" href="../style/floating_button.css">
    <style>
        a[href='manage_product.php']{
            color: white;
            background-color: black;
        }
        body{
            background-color: black;
        }
        #products tr:hover{
            cursor: pointer;
        }
        #products tr th{
            background-color: darkgray;
            padding: 1%;
        }
        #products table{
            margin-top: 5%;
        }
        #products table button{
            padding: 10px;
            border: 0;
            background-color: red;
            color: white;
            margin: 2px;
        }
        #products table button:hover{
            cursor: pointer;
            background-color: darkred;
        }
        #products tr td{
            text-align: center;
        }
        #products tr:nth-child(odd) {
            background-color: white;
        }
        #products tr:nth-child(even) {
            background-color: lightgrey;
        }
        #products{
            margin-left: 20%;
            margin-right: 20%;
            width: 60%;
        }
        #modal_window_body{
            margin: 1%;
        }
        #modal_window_body form input{
            border-bottom: 2px solid blue;
        }
        #modal_window_body label{
            font-size: 0.6em;
        }
        #modal_window_body input{
            font-size: 0.5em;
        }
        #modal_window_body textarea{
            border: none;
            width: 70%;
            height: 80px;
            font-family: game, sans-serif;
            font-size: 0.4em;
            border-bottom: 2px solid blue;
        }
        #description-wrapper label{
            display: block;
            vertical-align: middle;
            margin-top: 1%;
            margin-bottom: 1%;
        }
    </style>
    <link rel="stylesheet" href="../style/forms.css">
</head>
<body>
<?php require_once('navbar.php'); ?>
<div id="products"></div>
<button class="floating-button" onclick="showRegister()">+</button>
<?php
require_once('scripts.php');
?>
<script src="../javascript/adminSession.js"></script>
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
        var data = response.data;
        showProducts( data );
    }

    function onFetchFailure(error){
        appendLog('FETCH', error);
    }

    function getProductForm() {
        var container = newDiv();
        container.setAttribute('id', 'container');
        var formDiv = newDiv();
        formDiv.setAttribute('id', 'form');

        var form = newForm('', 'POST', 'form');
        var name = newFormGroupInput('Nombre : ', 'text', 'name', 'name');
        var description = newFormGroupTextArea('Descripcion : ', 'description', 'description');
        description.id = 'description-wrapper';
        var price = newFormGroupInput('Precio : ', 'number', 'price', 'price');
        var quantity = newFormGroupInput('Cantidad en Stock : ', 'number', 'quantity', 'quantity');
        var file = newFormGroupInput('Imagen : ', 'file', 'image', 'image');
        appendItemsTo(
            form,
            [name, description, price, quantity, file]
        );

        formDiv.appendChild(form);
        container.appendChild(formDiv);
        return container;
    }
    function showRegister(){
        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_BLUE );
        var form = getProductForm();
        notifier.confirm(
            'Registrar Producto',
            form.outerHTML,
            function( confirm ){
                if( confirm ){
                    register();
                }
            }
        );
        findViewById('image').setAttribute("accept", ".jpg,.png,.jpeg,.mp4");
    }

    function getProductFormData(id) {
        var formData = new FormData();
        var file = findViewById('image').files[0];
        formData.append('image', file);
        formData.append('id', id);
        formData.append('name', findViewById('name').value);
        formData.append('description', findViewById('description').value);
        formData.append('price', findViewById('price').value);
        formData.append('quantity', findViewById('quantity').value);
        return formData;
    }

    function validateFormData(){
        if( findViewById('name').value.length > 0 ) {
            if( findViewById('description').value.length > 0 ) {
                if( findViewById('price').value.length > 0 ) {
                    if( findViewById('quantity').value.length > 0) {
                        return true;
                    }else{
                        alert('La cantidad debe ser mayor a cero');
                    }
                }else{
                    alert('El precio debe ser mayor a cero');
                }
            }else{
                alert('La descripciòn no debe ser vacia');
            }
        }else{
            alert('El campo de nombre no puede ser vacio');
        }
        return false;
    }

    function register(){
        if ( validateFormData() ) {
            var formData = getProductFormData();
            ajax.postWithProgress(
                    '../server/action/product/new.php',
                    formData,
                    onRegisterSuccess,
                    onRegisterFailure,
                    onRegisterProgress
            );
        }
    }

    function onRegisterSuccess( data ){
        notifier.setTheme( MODAL_GREEN );
        notifier.dontExpectsHTMLContent();
        notifier.alert(
            'Éxito',
            'El producto ha sido registrado exitosamente',
            refreshPage
        );
    }

    function onRegisterFailure( error ){
        appendLog('REGISTER', error);
    }

    function onRegisterProgress( total, current ){
        appendLog('REGISTER', 'Total : ' + total + ' Current : ' + current);
    }

    function showProducts( data ){
        var table = newTable( newTableHeader(['ID','NOMBRE','PRECIO','CANTIDAD','']) );
        table.border = '1';
        for( var i = 0; i < data.length; i++ ){
            var product = data[i];
            var deleteButton = newButton('X', showDeleteDialog);
            deleteButton.setAttribute('data-id', product['id']);
            var row = newTableRow([ product['id'], product['name'], product['price'], product['quantity'], deleteButton]);
            row.setAttribute('data-product', JSON.stringify(product));
            row.onclick = showUpdateForm;
            table.appendChild(row);
        }
        findViewById('products').appendChild(table);
    }

    function showDeleteDialog(event){
        event.stopPropagation();
        var id = this.getAttribute('data-id');
        notifier.dontExpectsHTMLContent();
        notifier.setTheme( MODAL_RED );
        notifier.confirm(
            'Eliminar',
            'A continuación se eliminara el producto con id =' + id + ', ¿Desea Continuar?',
            function(confirm){
                if( confirm ){
                    deleteProduct(id);
                }
            }
        );
    }

    function updateProduct( id ) {
        if ( validateFormData() ) {
          var formData = getProductFormData( id );
          ajax.postWithProgress(
                  '../server/action/product/update.php',
                  formData,
                  onUpdateSuccess,
                  onUpdateFailure,
                  onUpdateProgress
          );
        }
    }

    function onUpdateProgress( total, current) {
        appendLog('UPDATE', total + 'of' + current);
    }

    function onUpdateFailure( error ){
        appendLog('UPDATE', error);
    }

    function onUpdateSuccess(){
        notifier.setTheme( MODAL_GREEN );
        notifier.dontExpectsHTMLContent();
        notifier.alert(
            'Éxito',
            'El producto ha sido actualizado exitosamente',
            refreshPage
        );
    }

    function showUpdateForm() {
        var product = JSON.parse(this.getAttribute('data-product'));
        var form = getProductForm();
        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_BLUE );
        notifier.confirm(
            'Actualizar',
            form.outerHTML,
            function(confirm){
                if( confirm ){
                    updateProduct(product['id']);
                }
            }
        );
        findViewById('name').value = product.name;
        findViewById('description').value = product.description;
        findViewById('price').value = product.price;
        findViewById('quantity').value = product.quantity;
    }

    function deleteProduct(id){
        var params = {};
        params['id'] = id;
        ajax.post(
            '../server/action/product/delete.php',
            params,
            onDeleteSuccess,
            onDeleteFailure
        );
    }

    function onDeleteSuccess(){
        notifier.dontExpectsHTMLContent();
        notifier.setTheme( MODAL_ORANGE );
        notifier.alert(
            'Eliminacion Exitosa',
            'El producto ha sido eliminado con exito',
            refreshPage
        );
    }

    function onDeleteFailure( error ){
        appendLog('DELETE', error);
    }
</script>
</body>
</html>
