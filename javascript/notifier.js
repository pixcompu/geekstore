/**
 * Modal message wrapper (Inspired by : http://www.w3schools.com/howto/howto_css_modals.asp) By PIXCOMPU.
 *      This class allows to show modal messages and confirm dialogs in screen.
 *
 * USAGE (IMPORTANT : Import the "notifier.css" in your header!):
 *  <header>
 *      <link href="notifier.css" rel="stylesheet"></link>
 *  <header>
 *  <body>...</body>
 *  <script src="notifier.js"></script>
 *  <script>
 * ------------------- CASE WITH HTML CONTENT , CUSTOM THEME AND CONFIRM FUNCTION  ------------------------
    notifier.setTheme( MODAL_GREEN );
    notifier.expectsHTMLContent();
    notifier.confirm(
        'Awesome Title',
        '<h1> ¿This is awesome? </h1>',
        function( confirm ){
           if( confirm ){
              alert('Told you! Yeah!');
           }else{
              alert('Too bad :( wait for the next update then..');
           }
        }
    );
 * ------------------- CASE WITH NORMAL CONTENT , DEFAULT THEME AND ALERT FUNCTION  ------------------------
    notifier.alert(
        'Awesome title',
        'I told you, this is awesome',
        function(){
            alert('You got it!');
        );
 *  </script>
 */

/**
 * Some common colors to use with the setTheme(color) function
 * @type {string}
 */
var MODAL_ORANGE = '#E82C0C';
var MODAL_BLUE = '#2A3DB2';
var MODAL_RED = '#D42B1E';
var MODAL_GREEN = '#32BA1D';
var MODAL_BLACK = '#000000';
var MODAL_YELLOW = '#F5DC00';
var MODAL_GRAY = '#39373E';

function Notifier(){

    var expectsHTMLContent = false;
    var currentColor = null;

    /**
     * Enable HTML interpretation of message (default : disabled).
     */
    this.expectsHTMLContent = function(){
        expectsHTMLContent = true;
    };

    /**
     * Disable HTML interpretation of message (default : disabled).
     */
    this.dontExpectsHTMLContent = function(){
        expectsHTMLContent = false;
    };

    /**
     * Sets the especified color to header and footer modal
     * @param hexColor String
     */
    this.setTheme = function( hexColor ){
        var isValidColor = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(hexColor);
        if( isValidColor ){
            currentColor = hexColor;
        }
    };

    /**
     * Sets the default color (GRAY) to header and footer modal.
     */
    this.resetTheme = function(){
        currentColor = null;
    };

    /**
     * Show newHyperLink modal window with only one option 'OK', this modal triggers the callback when user clicks the option.
     * @param title String
     * @param message String
     * @param onAlertAccept Callback
     */
    this.alert = function (title, message, onAlertAccept) {
        buildAlertModal(title, message, onAlertAccept);
    };

    /**
     * Show newHyperLink modal window with two options 'SI', 'NO' this modal triggers the callback with newHyperLink boolean value depending
     *      of the option pressed, 'SI' -> callback(true), 'NO' -> callback(false).
     * @param title String
     * @param message String
     * @param onResponse Callback
     */
    this.confirm = function(title, message, onResponse){
        buildConfirmModal(title, message, onResponse);
    };

    this.forceModalClose = function(){
        var modal = document.getElementById('modal_window');
        if( modal ){
            modal.style.display = 'none';
        }
    };
    // PRIVATE METHODS SECTION

    function buildConfirmModal(title, message, onResponse){
        var modal = getModal();
        var modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
        modalContent.appendChild(buildHeader(title));
        modalContent.appendChild(buildContent(message));
        modalContent.appendChild(buildConfirmFooter(onResponse));
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
        modal.style.display = 'block';
    }

    function buildAlertModal(title, message, onAlertAccept){
        var modal = getModal();
        var modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
        modalContent.appendChild(buildHeader(title));
        modalContent.appendChild(buildContent(message));
        modalContent.appendChild(buildAlertFooter(onAlertAccept));
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
        modal.style.display = 'block';
    }

    function buildHeader(titleMessage){
        var header = document.createElement('div');
        header.className = 'modal-header';
        if( currentColor != null ){
            header.style.backgroundColor = currentColor;
        }
        var title = document.createElement('h2');
        title.id = 'modal_window_header';
        var titleText = document.createTextNode(titleMessage);
        title.appendChild(titleText);
        header.appendChild(title);
        return header;
    }

    function buildContent(contentBody){
        var body = document.createElement('div');
        body.className = 'modal-body';
        body.id = 'modal_window_body';

        if( ! expectsHTMLContent ){
            var paragraph = document.createElement('p');
            var paragraphText = document.createTextNode(contentBody);
            paragraph.appendChild(paragraphText);
            body.appendChild(paragraph);
        }else{
            var content = document.createElement('div');
            content.innerHTML = contentBody;
            body.appendChild(content);
        }
        return body;
    }

    function buildAlertFooter(onAlertAccept){
        var footer = getFooter();
        var button = getButton('OK');
        button.onclick = function(){
            document.getElementById('modal_window').style.display = 'none';
            if( typeof onAlertAccept == 'function'){
                onAlertAccept();
            }
        };

        footer.appendChild(button);
        return footer;
    }

    function buildConfirmFooter(onResponse){
        var footer = getFooter();
        var buttonCancel = getButton('NO');
        buttonCancel.onclick = function(){
            document.getElementById('modal_window').style.display = 'none';
            if( typeof onResponse == 'function'){
                onResponse(false);
            }
        };

        var buttonConfirm = getButton('SI');
        buttonConfirm.onclick = function(){
            document.getElementById('modal_window').style.display = 'none';
            if( typeof onResponse == 'function'){
                onResponse(true);
            }
        };

        footer.appendChild(buttonCancel);
        footer.appendChild(buttonConfirm);
        return footer;
    }

    function getFooter(){
        var footer = document.createElement('div');
        footer.className = 'modal-footer';
        if( currentColor != null ){
            footer.style.backgroundColor = currentColor;
        }
        return footer;
    }

    function getButton(text){
        var button = document.createElement('button');
        button.className = 'modal-btn';
        var buttonCancelText = document.createTextNode(text);
        button.appendChild(buttonCancelText);
        return button;
    }

    function getModal(){
        validateModal();
        var modal = document.createElement('div');
        modal.className = 'modal';
        modal.id = 'modal_window';
        return modal;
    }

    function validateModal(){
        var modalWindow = document.getElementById('modal_window');
        if( modalWindow ){
            modalWindow.parentNode.removeChild(modalWindow);
        }
    }
}
var notifier = new Notifier();