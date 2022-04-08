function tables() {
    var tables = document.getElementsByClassName("editable");
    console.log(tables);
}

/*
window.onload=init;
function init() {
    document.getElementById("editor").addEventListener("input", function() {
        console.log("input event fired");
    }, false);
}
*/

function testtable() {
    var printdata = document.getElementById("edit_data");
    console.log(printdata.outerHTML);
}