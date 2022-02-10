"use strict";

function getCategoryAndMake(currentid, currentName, lang, idCategory, idMake) {
    const classParam = document.getElementById(currentid).value;

    getJSON(
        "/category_make/" + lang + "?" + currentName + "=" + classParam,
        "Page not found"
    )
        .then(function (data) {
            const text = data["text"];
            loadValues(data["categories"], text, idCategory);
            loadValues(data["makes"], text, idMake);
        })
        .catch((err) => {
            renderError(`Something went wrong ${err.message}`);
        });
}

function getModelsWithGroup(currentid, currentName, lang, idClass, idModel) {
    let classParam = document.getElementById(idClass).value;
    classParam = classParam === null || classParam === "" ? "Car" : classParam;
    const make = document.getElementById(currentid).value;
    getJSON(
        "/model/" + lang + "/" + classParam + "?" + currentName + "=" + make,
        "Page not found"
    )
        .then(function (items) {
            const text = items["text"];
            if (items["modelGroups"].length > 0) {
                loadValueswithOptGroup(
                    items["models"],
                    items["modelGroups"],
                    text,
                    idModel,
                    make,
                    classParam,
                    lang
                );
            } else {
                loadValues(items["models"], text, idModel);
            }
        })
        .catch((err) => renderError(`Something went wrong ${err.message}`));
}

function getModelRangeAndTrimLine(
    currentid,
    currentName,
    lang,
    idClass,
    idMake,
    idModelRange,
    idTrimLine
) {
    let classParam = document.getElementById(idClass).value;
    let make = document.getElementById(idMake).value;
    classParam = classParam === null || classParam === "" ? "Car" : classParam;
    make = make === null || make === "" ? "Audi" : make;
    const model = document.getElementById(currentid).value;
    getJSON(
        "/modelRange-trimLine/" +
            lang +
            "/" +
            classParam +
            "/" +
            make +
            "?" +
            currentName +
            "=" +
            model,
        "Page not found"
    )
        .then(function (items) {
            const text = items["text"];
            loadValues(items["modelRanges"], text, idModelRange);
            loadValues(items["trimLines"], text, idTrimLine);
        })
        .catch((err) => renderError(`Something went wrong ${err.message}`));
}
function loadValueswithOptGroup(
    itemsModel,
    itemsModelGroup,
    text,
    idModel,
    make,
    classParam,
    lang
) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/make/" + lang + "/" + classParam + "?make=" + make, true);
    xhr.onload = function () {
        const models = JSON.parse(this.responseText);
        const itemsModelOfModel = models["modelOfModelGroups"];
        document.getElementById(idModel).innerHTML = "";
        for (const itemGroup of itemsModelGroup) {
            //let optGroup = $('<optgroup label="' + itemGroup[text] + '"/>');
            let optGroup = $("#" + idModel).append(
                '<option value="' +
                    itemGroup["key"] +
                    '"style="font-weight:bold" >' +
                    itemGroup[text] +
                    "</option>"
            );
            const keyList = Object.keys(itemsModelOfModel);
            if (keyList.includes(itemGroup["key"])) {
                const items_model = itemsModelOfModel[itemGroup["key"]];
                itemsModel = itemsModel.filter(function (item) {
                    return (
                        items_model.filter(function (item2) {
                            return item["key"] === item2["key"];
                        }).length === 0
                    );
                });
                items_model.forEach((element) => {
                    optGroup.append(
                        '<option value="' +
                            element["key"] +
                            '">' +
                            "&nbsp;&nbsp;&nbsp;&nbsp;" +
                            element[text] +
                            "</option>"
                    );
                    //$("#" + idModel).append(optGroup);
                });
            }
        }
        itemsModel.forEach((item) => {
            $("#" + idModel).append(
                '<option value="' +
                    item["key"] +
                    '">' +
                    item[text] +
                    "</option>"
            );
        });
    };
    xhr.send();
}

function loadValues(items, text, idNext) {
    document.getElementById(idNext).innerHTML = "";
    for (const item of items) {
        $("#" + idNext).append(
            '<option value="' + item["key"] + '">' + item[text] + "</option>"
        );
    }
}
function getJSON(url, errorMsg = "something went wrong") {
    return fetch(url).then((response) => {
        if (!response.ok) throw new Error(`${errorMsg} ${response.status}`);
        return response.json();
    });
}
function renderError(msg) {
    const div = document.getElementsByTagName("body")[0];
    const html = `<h3 class="error_msg">${msg}</h3>`;
    div.insertAdjacentHTML("beforebegin", html);
    div.style.opacity = 0;
}
