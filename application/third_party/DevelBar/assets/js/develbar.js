var HideDevelBar = function() {
    var develbar = document.getElementById('develbar-container');
    var develbar_off = document.getElementById('develbar-off');
    develbar.style.display = 'none';
    develbar_off.style.display = 'block';
},
ShowDevelBar = function(){
    var develbar = document.getElementById('develbar-container');
    var develbar_off = document.getElementById('develbar-off');
    develbar_off.style.display = 'none';
    develbar.style.display = 'block';
}
