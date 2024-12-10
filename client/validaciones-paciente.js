document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-pedir-cita');
    const fechaCitaInput = document.getElementById('fecha-cita');
    const mensajeFecha = document.getElementById('mensaje-fecha');
    const sintomasInput = document.getElementById('sintomas');
    const sintomasError = document.getElementById('sintomas-error');
    const generalError = document.getElementById('general-error');
    const medicoInput = document.getElementById('medico');
    const medicoError = document.getElementById('medico-error');

    const errorSVG = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><style>@keyframes n-info-tri{0%,to{transform:rotate(0deg);transform-origin:center}10%,90%{transform:rotate(2deg)}20%,40%,60%{transform:rotate(-6deg)}30%,50%,70%{transform:rotate(6deg)}80%{transform:rotate(-2deg)}}.prefix__n-info-tri{animation:n-info-tri .8s cubic-bezier(.455,.03,.515,.955) both infinite}</style><path class="prefix__n-info-tri" style="animation-delay:1s" stroke="red" stroke-width="1.5" d="M11.134 6.844a1 1 0 011.732 0l5.954 10.312a1 1 0 01-.866 1.5H6.046a1 1 0 01-.866-1.5l5.954-10.312z"/><g class="prefix__n-info-tri"><path stroke="red" stroke-linecap="round" stroke-width="1.5" d="M12 10.284v3.206"/><circle cx="12" cy="15.605" r=".832" fill="red"/></g></svg>';

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el comportamiento predeterminado del formulario
        let valid = true;

        if (!validarMedico()) valid = false;
        if (!validarFechaCita()) valid = false;
        if (!validarSintomas()) valid = false;

        if (!valid) {
            generalError.innerHTML = errorSVG + ' Por favor, complete los campos correctamente.';
        } else {
            generalError.textContent = '';

            // Obtener el ID del paciente desde la URL
            const usuarioId = new URLSearchParams(window.location.search).get('id');

            // Enviar los datos del formulario al servidor
            const formData = new FormData(form);
            formData.append('id_paciente', usuarioId);

            // Verificar los datos del formulario
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            fetch('server/guardar-consulta.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    generalError.innerHTML = errorSVG + ' ' + data.error;
                } else {
                    generalError.innerHTML = 'Consulta guardada correctamente';
                    form.reset();
                }
            })
            .catch(error => {
                generalError.innerHTML = errorSVG + ' Error al guardar la consulta';
                console.error('Error:', error);
            });
        }
    });

    // * Añadir eventos de validación al perder el foco en los campos
    medicoInput.addEventListener('blur', validarMedico);
    fechaCitaInput.addEventListener('blur', validarFechaCita);
    sintomasInput.addEventListener('blur', validarSintomas);

    // ? Función para validar el campo de médico
    function validarMedico() {
        if (medicoInput.value === '') {
            medicoError.innerHTML = errorSVG + ' Por favor, seleccione un médico.';
            return false;
        }

        medicoError.textContent = '';
        return true;
    }

    // ? Función para validar el campo de fecha de cita
    function validarFechaCita() {
        const fechaCita = new Date(fechaCitaInput.value);
        const hoy = new Date();
        const diaSemana = fechaCita.getDay();
        const diferenciaDias = (fechaCita - hoy) / (1000 * 60 * 60 * 24);

        if (!fechaCitaInput.value) {
            mensajeFecha.innerHTML = errorSVG + ' Por favor, seleccione una fecha.';
            return false;
        }

        if (fechaCita < hoy) {
            mensajeFecha.innerHTML = errorSVG + ' Fecha no válida';
            return false;
        }

        if (diaSemana === 0 || diaSemana === 6) {
            mensajeFecha.innerHTML = errorSVG + ' Por favor, elija un día laborable';
            return false;
        }

        if (diferenciaDias > 30) {
            mensajeFecha.innerHTML = errorSVG + ' Tan malo no estarás. Pide una fecha como máximo 30 días en el futuro';
            return false;
        }

        mensajeFecha.textContent = '';
        return true;
    }

    // ? Función para validar el campo de síntomas
    function validarSintomas() {
        if (sintomasInput.value.trim() === '') {
            sintomasError.innerHTML = errorSVG + ' Por favor, describa sus síntomas.';
            return false;
        }

        sintomasError.textContent = '';
        return true;
    }
});