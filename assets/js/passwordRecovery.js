const passwordInput = document.getElementsByName("password")[0];
const changeImage = document.getElementsByName("imagePassword")[0];

const repeatPasswordInput = document.getElementsByName("repeatpassword")[0];
const repeatChangeImage = document.getElementsByName("imagePassword")[1];

function mostrarSenha(passInput, alterateImage) {
    if (passInput.type === "password") {
        alterateImage.src = '../assets/images/eyeClose.png';
        passInput.type = "text";
    } else {
        passInput.type = "password";
        alterateImage.src = '../assets/images/eyeOpen.png';
    }
}

// Verifica se os elementos existem antes de adicionar os event listeners
if (changeImage && passwordInput) {
    changeImage.addEventListener("click", () => mostrarSenha(passwordInput, changeImage));
}

if (repeatChangeImage && repeatPasswordInput) {
    repeatChangeImage.addEventListener("click", () => mostrarSenha(repeatPasswordInput, repeatChangeImage));
}
