const passwordInput = document.getElementsByName("password")[0];
const changeImage = document.getElementsByName("imagePassword")[0];

function mostrarSenha(passInput, alterateImage) {
    if (passInput.type === "password") {
        alterateImage.src = './assets/images/eyeClose.png';
        passInput.type = "text";
    } else {
        passInput.type = "password";
        alterateImage.src = './assets/images/eyeOpen.png';
    }
}

if (changeImage && passwordInput) {
    changeImage.addEventListener("click", () => mostrarSenha(passwordInput, changeImage));
}
