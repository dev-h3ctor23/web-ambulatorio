// ? Listener para validar campos de formulario de inicio de sesión

document.addEventListener('DOMContentLoaded', function() {

    // ? Constantes y variables para validar campos de formulario
        // * form: formulario de inicio de sesión
        // * dniInput: campo DNI
        // * passwordInput: campo contraseña
        // * generalError: mensaje de error general
    
    const form = document.querySelector('form');
    const dniInput = document.getElementById('dni');
    const passwordInput = document.getElementById('password');
    const generalError = document.getElementById('general-error');

    // ? Eventos para validar campos de formulario
        // * submit: al enviar el formulario

    form.addEventListener('submit', function(event) {

        // * let valid: variable para validar campos de formulario

        let valid = true; 
        if (!validarDNI()) valid = false; // * Si la función validarDNI() devuelve false no es válido
        if (!validarPassword()) valid = false; // * Si la función validarPassword() devuelve false no es válido
        if (!valid) {
            event.preventDefault(); // * Evita el envío del formulario si hay errores
            generalError.textContent = 'Por favor, complete los campos correctamente.';
        } else {
            generalError.textContent = ''; // * Limpiar mensaje de error si es válido
        }
    });

    // ? Eventos para validar campos de formulario al salir de los campos
        // * blur: al salir del campo DNI o contraseña se activa la validación
    dniInput.addEventListener('blur', validarDNI);
    passwordInput.addEventListener('blur', validarPassword);
});

// ? validarDNI(): función para validar campo DNI

function validarDNI() {

    // * dni: valor del campo DNI
    // * dniError: mensaje de error del campo DNI
    // * dniRegex: expresión regular para validar DNI
    // * errorSVG: icono de error animado

    const dni = document.getElementById('dni').value;
    const dniError = document.getElementById('dni-error');
    const dniRegex = /^\d{8}$/; // ! Validación: 8 dígitos
    const errorSVG = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><style>@keyframes n-info-tri{0%,to{transform:rotate(0deg);transform-origin:center}10%,90%{transform:rotate(2deg)}20%,40%,60%{transform:rotate(-6deg)}30%,50%,70%{transform:rotate(6deg)}80%{transform:rotate(-2deg)}}.prefix__n-info-tri{animation:n-info-tri .8s cubic-bezier(.455,.03,.515,.955) both infinite}</style><path class="prefix__n-info-tri" style="animation-delay:1s" stroke="red" stroke-width="1.5" d="M11.134 6.844a1 1 0 011.732 0l5.954 10.312a1 1 0 01-.866 1.5H6.046a1 1 0 01-.866-1.5l5.954-10.312z"/><g class="prefix__n-info-tri"><path stroke="red" stroke-linecap="round" stroke-width="1.5" d="M12 10.284v3.206"/><circle cx="12" cy="15.605" r=".832" fill="red"/></g></svg>';

    if (dni === '') { // * Si el campo DNI está vacío
        dniError.innerHTML = `El campo DNI no puede estar vacío. ${errorSVG}`;
        return false;
    }
    if (!dniRegex.test(dni)) { // * Si el campo DNI no cumple con la expresión regular
        dniError.innerHTML = `Por favor, ingrese un DNI válido de 8 dígitos. ${errorSVG}`;
        return false;
    }
    dniError.innerHTML = ''; // * Limpiar mensaje de error si es válido
    return true;
}

// ? validarPassword(): función para validar campo contraseña

function validarPassword() {

    // * password: valor del campo contraseña
    // * passwordError: mensaje de error del campo contraseña
    // * passwordRegex: expresión regular para validar contraseña

    const password = document.getElementById('password').value;
    const passwordError = document.getElementById('password-error');
    const passwordRegex = /^[A-Za-z0-9]{6,}$/; // ! Validación: 6 dígitos, sin caracteres especiales
    const errorSVG = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><style>@keyframes n-info-tri{0%,to{transform:rotate(0deg);transform-origin:center}10%,90%{transform:rotate(2deg)}20%,40%,60%{transform:rotate(-6deg)}30%,50%,70%{transform:rotate(6deg)}80%{transform:rotate(-2deg)}}.prefix__n-info-tri{animation:n-info-tri .8s cubic-bezier(.455,.03,.515,.955) both infinite}</style><path class="prefix__n-info-tri" style="animation-delay:1s" stroke="red" stroke-width="1.5" d="M11.134 6.844a1 1 0 011.732 0l5.954 10.312a1 1 0 01-.866 1.5H6.046a1 1 0 01-.866-1.5l5.954-10.312z"/><g class="prefix__n-info-tri"><path stroke="red" stroke-linecap="round" stroke-width="1.5" d="M12 10.284v3.206"/><circle cx="12" cy="15.605" r=".832" fill="red"/></g></svg>';

    if (password === '') { // * Si el campo contraseña está vacío
        passwordError.innerHTML = `El campo contraseña no puede estar vacío. ${errorSVG}`;
        return false;
    }
    if (!passwordRegex.test(password)) { // * Si el campo contraseña no cumple con la expresión regular
        passwordError.innerHTML = `La contraseña debe tener 6 digitos y no tener caracteres especiales. ${errorSVG}`;
        return false;
    }
    passwordError.innerHTML = ''; // * Limpiar mensaje de error si es válido
    return true;
}