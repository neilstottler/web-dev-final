function required() {
    //itemname
    var empt = document.enterdata.itemname.value;
    if (empt === "") {
        document.getElementById("itemname_id").style.color = "red";
        return false;
    } else {
        console.log(" data")
        return true;
    }
}