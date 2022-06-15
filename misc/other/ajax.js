"use strict";

var apiUrl = "http://pokerom_v3.test/public/api/dev";

function loadRomsData() {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", apiUrl + "/roms", true);
    xhr.setRequestHeader("Accept", "application/json");

    xhr.onprogress = function () {
        console.log("Fetching data...");
    };

    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var roms = JSON.parse(this.responseText);
            console.log(roms);
        }
    };

    xhr.onerror = function () {
        console.error("Error", this.responseText);
    };

    xhr.send();
}
