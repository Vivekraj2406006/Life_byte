const logo=document.getElementById('user-logo');
const side_bar=document.getElementById('side-bar');
const main=document.getElementsByTagName('main');
const body=document.querySelector('body');

function showNav(){
    side_bar.style.left=0;
    body.style.backgroundColor="rgba(0, 0, 0, 0.218)";
}
function hideNav(){
    side_bar.style.left='-100%';
    body.style.backgroundColor="white";

}