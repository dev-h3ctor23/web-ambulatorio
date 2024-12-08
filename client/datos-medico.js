document.addEventListener('DOMContentLoaded', function() {
    const medicoId = new URLSearchParams(window.location.search).get('id');
    console.log(`Medico ID: ${medicoId}`); // Verifica el valor de medicoId

    // Obtener la información del médico
    fetch(`server/datos-medico.php?id=${medicoId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                document.getElementById('nombre-medico').textContent = `Nombre: ${data.nombre}`;
                document.getElementById('correo-medico').textContent = `Correo: ${data.correo}`;
                document.getElementById('especialidad-medico').textContent = `Especialidad: ${data.especialidad}`;
                document.getElementById('numero-consultas').textContent = `Número de Consultas: ${data.numero_consultas}`;
            }
        })
        .catch(error => console.error('Error:', error));

    // Obtener las consultas de hoy del médico
    fetch(`server/obtener-consultas-hoy.php?id_doctor=${medicoId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verifica los datos recibidos
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                const listaConsultasHoy = document.getElementById('lista-consultas-hoy');
                listaConsultasHoy.innerHTML = ''; // Asegúrate de limpiar la tabla antes de agregar nuevas filas
                data.forEach(consulta => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${consulta.id_consulta}</td>
                        <td>${consulta.nombre_paciente}</td>
                        <td>${consulta.sintomas}</td>
                        <td><button onclick="pasarConsulta(${consulta.id_consulta})">Pasar Consulta</button></td>
                    `;
                    listaConsultasHoy.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error:', error));
});

function pasarConsulta(id) {
    window.open(`consulta.html?id=${id}`, '_blank');
}