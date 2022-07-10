"use strict";

var apiUrl = "http://pokerom_rebirth.test/public/api";
var token = "__API_TOKEN__";

function loadRomsData() {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", apiUrl + "/roms", true);
    xhr.setRequestHeader("Accept", "application/json");
    xhr.setRequestHeader("Authorization", "Bearer " + token);

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
