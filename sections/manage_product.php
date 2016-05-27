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
            background-color: white;
        }
    </style>
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
        var form = newForm('', 'POST', 'form');
        var name = newFormGroupInput('Nombre : ', 'text', 'name', 'name');
        var description = newFormGroupTextArea('Descripcion : ', 'description', 'description');
        var price = newFormGroupInput('Precio : ', 'number', 'price', 'price');
        var quantity = newFormGroupInput('Cantidad en Stock : ', 'number', 'quantity', 'quantity');
        var file = newFormGroupInput('Imagen : ', 'file', 'image', 'image');
        appendItemsTo(
                form,
                [name, description, price, quantity, file]
        );
        return form;
    }
    function showRegister(){
        notifier.expectsHTMLContent();
        notifier.setTheme( MODAL_GREEN );
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

    function getProductFormData() {
        var file = findViewById('image').files[0];
        var formData = new FormData();
        formData.append('image', file);
        formData.append('name', findViewById('name').value);
        formData.append('description', findViewById('description').value);
        formData.append('price', findViewById('price').value);
        formData.append('quantity', findViewById('quantity').value);
        return formData;
    }

    function register(){
        var formData = getProductFormData();
        ajax.postWithProgress(
                '../server/action/product/new.php',
                formData,
                onRegisterSuccess,
                onRegisterFailure,
                onRegisterProgress
        );
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
            row.onmouseover = function(){
                this.style.backgroundColor = 'lightgray';
                this.style.cursor = 'pointer';
            };
            row.onmouseout = function () {
                this.style.backgroundColor = 'white';
                this.style.cursor = 'arrow';
            };
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

    function updateProduct( data ) {
        var formData = getProductFormData();
        ajax.postWithProgress(
                '../server/action/product/update.php',
                formData,
                onUpdateSuccess,
                onUpdateFailure,
                onUpdateProgress
        );

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
                        updateProduct();
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
                '../server/proccess_delete_product.php',
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