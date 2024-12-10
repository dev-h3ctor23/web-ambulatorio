document.addEventListener('DOMContentLoaded', function() {
    const consultaId = new URLSearchParams(window.location.search).get('id');

    // Obtener la información de la consulta
    fetch(`server/datos-consulta.php?id=${consultaId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error(data.error);
                alert('Error: ' + data.error);
            } else {
                document.getElementById('nombre-medico').textContent = data.nombre_medico;
                document.getElementById('nombre-paciente').textContent = data.nombre_paciente;
                document.getElementById('fecha-consulta').textContent = data.fecha;
                document.getElementById('sintomatologia').value = data.sintomas;
                document.getElementById('diagnostico').value = data.diagnostico;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });

    // Obtener los doctores y llenar el select
    fetch('server/obtener-doctores.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error(data.error);
                alert('Error: ' + data.error);
            } else {
                const selectEspecialista = document.getElementById('especialista');
                data.forEach(doctor => {
                    const option = document.createElement('option');
                    option.value = doctor.id_doctor;
                    option.textContent = doctor.nombre_doctor;
                    selectEspecialista.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });

    // Actualizar la consulta con el especialista y la fecha
    document.getElementById('pedir-cita').addEventListener('click', function() {
        const idEspecialista = document.getElementById('especialista').value;
        const fechaCita = document.getElementById('fecha-cita').value;

        fetch('server/actualizar-consulta-especialista.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id_consulta=${consultaId}&id_especialista=${idEspecialista}&fecha_cita=${fechaCita}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                alert('Error: ' + data.error);
            } else {
                alert('Consulta actualizada correctamente');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        });
    });
});