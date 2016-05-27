/**
 * Created by Elsy on 27/05/2016.
 */

window.onload = initPrincipal;
function initPrincipal(){
    removeSplash();
    findViewById('bird').onclick = function(){
        if(this.src.split('/')[this.src.split('/').length-1] == 'space-bird-effect.png'){
            this.src = '../resources/images/icons/space-bird.png';
        }else{
            this.src = '../resources/images/icons/space-bird-effect.png'
        }
    };
}

function removeSplash() {
    //findViewById('splash').style.opacity = '0';
    setTimeout(function(){
        removeElement(findViewById('splash'));
    }, 700);
}