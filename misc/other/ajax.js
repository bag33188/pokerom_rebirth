"use strict";

var apiUrl = "http://pokerom_rebirth.test/public/api";

function loadRomsData() {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", apiUrl + "/dev/roms", true);
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

loadRomsData();
