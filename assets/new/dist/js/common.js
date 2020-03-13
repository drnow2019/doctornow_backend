function msgerror(message) {
    // Get the snackbar DIV
    var x = document.getElementById("errordiv")
	document.getElementById("errordiv").innerHTML = message;

    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
function msgsuccess(message) {
    // Get the snackbar DIV
    var x = document.getElementById("successdiv")
	document.getElementById("successdiv").innerHTML = message;

    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}