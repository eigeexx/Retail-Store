var duration = 1000;
setInterval(updateTimer, 1000);
var jsvar = '<?= $_SESSION[\'username\'] ?>';
console.log(jsvar);
function updateTimer() {
    if (window.location.href != "http://localhost:8080/CMSC-127/session/RetailProject/client/register.php" &&  jsvar  ) {
        duration--;
    if (duration<1) {
        sessionStorage.removeItem('username');
        sessionStorage.clear();
        window.location="../login.php";
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    } 
    }
    console.log(duration);
    
}

window.addEventListener("mousemove", resetTimer);

function resetTimer() {
    duration =1000;
}