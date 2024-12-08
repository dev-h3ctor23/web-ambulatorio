document.addEventListener('DOMContentLoaded', function() {
    const usuarioId = new URLSearchParams(window.location.search).get('id');
    console.log(`Usuario ID: ${usuarioId}`); // Verifica el valor de usuarioId

    if (!usuarioId) {
        console.error('Error: ID de usuario no válido');
        return;
    }

    // Obtener la información del paciente
    fetch(`server/datos-paciente.php?id=${usuarioId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                document.getElementById('nombre-paciente').textContent = `Nombre: ${data.nombre}`;
                document.getElementById('correo-paciente').textContent = `Correo: ${data.correo}`;
                document.getElementById('dni-paciente').textContent = `DNI: ${data.dni}`;
            }
        })
        .catch(error => console.error('Error:', error));

    // Obtener el médico asignado al paciente
    fetch(`server/obtener-medico.php?id_paciente=${usuarioId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                console.log(`Medico: ${data.nombre_doctor}`); // Verifica los datos del médico
                const medicoSelect = document.getElementById('medico');
                const option = document.createElement('option');
                option.value = data.id_doctor;
                option.textContent = data.nombre_doctor;
                medicoSelect.appendChild(option);
            }
        })
        .catch(error => console.error('Error:', error));

    // Obtener las próximas consultas del paciente
    fetch(`server/obtener-consultas.php?id_paciente=${usuarioId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                const listaCitas = document.getElementById('lista-citas');
                data.forEach(consulta => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${consulta.nombre_doctor}</td>
                        <td>${consulta.fecha}</td>
                        <td>${consulta.sintomas}</td>
                    `;
                    listaCitas.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error:', error));

    // Obtener las consultas pasadas del paciente
    fetch(`server/obtener-consultas-pasadas.php?id_paciente=${usuarioId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                const listaConsultas = document.getElementById('lista-consultas');
                data.forEach(consulta => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${consulta.fecha}</td>
                        <td>${consulta.sintomas}</td>
                    `;
                    listaConsultas.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error:', error));
});