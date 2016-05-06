/**
 * General DOM manipulation Wrapper By PIXCOMPU.
 * 
 * This functions save precious time when the page is creating DOM elements dinamically.
 * Comparation:
 * ----------------------------CREATE A <BUTTON> AND APPEND IT TO THE DOM WITHOUT FACTORY -----------------------------
 * var btn = document.createElement('button');
 * var btnText = document.createTextNode('I am a button');
 * btn.appendChild( btnText );
 * btn.onclick = function(){ console.log('print something'); };
 * document.getElementById('my_wrapper').appendChild(btn);
 * --------------------------- AND WITH FACTORY ----------------------------------------------------------------------
 * <script src="factory.js"></script>
 * findViewById('my_wrapper').appendChild( newButton('I am a button', function(){ console.log('print something')} ) );
 */

addClassTo = function(element, className){
    var classes = className.split(' ');

    for(var i=0; i < classes.length; i++){
        var current = classes[i];
        if( element.className.indexOf(current) == -1 ){
            element.className += " " + current;
        }
    }
    return element;
};

removeClassFrom = function(element, className){
    var classes = className.split(' ');

    for(var i=0; i < classes.length; i++){
        var current = classes[i];
        element.className.replace(current, '');
    }
    return element;
};

appendItemsTo = function(element, array){
    for(var i = 0; i<array.length; i++){
        var current = array[i];
        element.appendChild( current );
    }
    return element;
};

findViewById = function (id) {
    if(document.getElementById){
        return document.getElementById(id);
    }else{
        return document.all(id);
    }
};

clearElement = function (element) {
    element.innerHTML = '';
};

refreshPage = function(){
    window.location.reload();
};

redirectTo = function(page){
    window.location = page;
};

appendLog = function( tag, item ){
    var text = "";

    if( typeof item === 'string' ){
        text = item;
    }else{
        try{
            text = JSON.stringify( item );
        }catch(error){
            try{
                text = item.outerHTML;
            }catch(error){
                text = 'Not defined';
            }
        }
    }

    console.log(tag + " : " + text);

};

newElement = function(tag, item){
    var element = document.createElement(tag);

    if( typeof item !== 'undefined'){
        try{
            element.appendChild(item);
        }catch(error){
            var elementText = document.createTextNode(item);
            element.appendChild(elementText);
        }
    }

    return element;
};

removeElement = function(item){
  item.parentNode.removeChild(item);
};

newButton = function(item, callback){
    var button = newElement('button', item);
    button.onclick = callback;
    return button;
};

newParagraph = function(item){
    return newElement('p', item);
};

newTableRow = function(array){
    return makeRowWith('td', array);
};

newTableHeader = function(array){
    return makeRowWith('th', array);
};

newImg = function(imagePath){
    var image = document.createElement('img');
    image['src'] = imagePath;
    return image;
};

newHyperLink = function(text, url){
    var link = newElement('a', text);
    link['href'] = url;
    return link;
};

newLi = function(item){
    return newElement('li', item);
};

newTd = function(item){return newElement('td', item);};

newH1 = function(item){ return newElement('h1', item); };
newH2 = function(item){ return newElement('h2', item); };
newH3 = function(item){ return newElement('h3', item); };
newH4 = function(item){ return newElement('h4', item); };
newH5 = function(item){ return newElement('h5', item); };
newH6 = function(item){ return newElement('h6', item); };
newH7 = function(item){ return newElement('h7', item); };
newSpan = function(item){
    return newElement('span', item);
};

newDiv = function(item){
    return newElement('div', item);
};

newTable = function(item){
    return newElement('table', item);
};

newForm = function(action, method, name){
    var form = newElement('form');
    form['action'] = action;
    form['method'] = method;
    form['name'] = name;
    return form;
};

newInput = function(type, name, id){
    var input = newElement('input');
    input['type'] = type;
    input['name'] = name;
    input['id'] = id;
    return input;
};
newTextArea = function(name, id){
    var textarea = newElement('textarea');
    textarea['name'] = name;
    textarea['id'] = id;
    return textarea;
};
newLabel = function(item){
    return newElement('label', item);
};
newSelect = function(name, id){
    var select = newElement('select');
    select['name'] = name;
    select['id'] = id;
    return select;
};
newFormGroupInput = function(labelText, inputType, name, id ){
    var input = newInput(inputType, name, id);
    var label = newLabel(labelText);
    label['for'] = id;
    return appendItemsTo(
        newDiv(),
        [label, input]
    );
};
newFormGroupTextArea = function(labelText, name, id ){
    var textarea = newTextArea(name, id);
    var label = newLabel(labelText);
    label['for'] = id;
    return appendItemsTo(
        newDiv(),
        [label, textarea]
    );
};
newFormGroupSelect = function(labelText, optionsArray, name, id ){
    var select = newSelect(name, id);
    for(var i = 0; i<optionsArray.length; i++){
        var option = newElement('option', optionsArray[i]);
        option['value'] = optionsArray[i];
        select.appendChild(option);
    }
    var label = newLabel(labelText);
    label['for'] = id;
    return appendItemsTo(
        newDiv(),
        [label, select]
    );
};

function makeRowWith(cellTag, array){
    var row = document.createElement('tr');
    for(var i = 0; i<array.length; i++){
        var current = array[i];
        var cell = newElement(cellTag, current);
        row.appendChild(cell);
    }
    return row;
}
