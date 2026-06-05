/* Konami Code Easter Egg */
/* messed up by one and only vista */

const konamiCode = [
    "ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "b", "a", "Enter"
];
let konamiCodeIndex = 0;

//let the magic happen
function changeFontToComicSans() {
    document.body.style.fontFamily = "Comic Sans MS, cursive";
}

//Handle The Keys
function handleKonamiCode(event) {
    const keyPressed = event.key;
    const expectedKey = konamiCode[konamiCodeIndex];

    if (keyPressed === expectedKey) {
        konamiCodeIndex++;

        if (konamiCodeIndex === konamiCode.length) {
            changeFontToComicSans();
            konamiCodeIndex = 0; // reset index for next use
        }
    } else {
        konamiCodeIndex = 0; // reset index when user did something wrong
    }
}

//shh... let's not leak our hard work
document.addEventListener("keydown", handleKonamiCode);