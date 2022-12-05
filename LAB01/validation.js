let selectedButton = null;
function chooseX(button) {
    if (selectedButton !== null) {
        selectedButton.disabled = false;
    }
    selectedButton = button;
    selectedButton.disabled = true;
    document.getElementById("chosen-button").value = button.value;
}

let y = null
function validateY(){
    let yElem = document.getElementById("y");
    yElem.value= yElem.value.replace(",",".");
    let warning = document.getElementById("y-warning");
    if (isNaN(yElem.value) || yElem.value === "" || +yElem.value < -3 || 5 < +yElem.value) {
        warning.innerText = "Координата Y должна быть числом из диапазона (-3; 5)"
        warning.style.display = "inline-block"
        warning.style.color = "red"
        y = null
    } else {
        warning.style.display = "none"
        y = yElem.value
    }
}

let r = null
function validateR(){
    let rElem = document.getElementById("r");
    rElem.value= rElem.value.replace(",",".");
    let warning = document.getElementById("r-warning");
    if (isNaN(rElem.value) || rElem.value === "" || +rElem.value < 1 || 4 < +rElem.value) {
        warning.innerText = "Значение R должна быть числом из диапазона (1; 4)"
        warning.style.display = "inline-block"
        warning.style.color = "red"
        r = null
    } else {
        warning.style.display = "none"
        r = rElem.value
    }
}

function isCorrect() {
    let kx = document.getElementById("chosen-button");
    let ky = document.getElementById("y");
    let kr = document.getElementById("r");

    if (kx == null) return false;
    if (isNaN(kx.value) || kx.value === "") return false;
    if (isNaN(ky.value) || ky.value === "" || +ky.value < 1 || 4 < +ky.value) return false;
    return !(isNaN(kr.value) || kr.value === "" || +kr.value < 1 || 4 < +kr.value);

}


