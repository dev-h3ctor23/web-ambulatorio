document.addEventListener('DOMContentLoaded', function() {
    const medicoId = new URLSearchParams(window.location.search).get('id');
    console.log(`Medico ID: ${medicoId}`); // Verifica el valor de medicoId

    fetch(`server/datos-medico.php?id=${medicoId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                document.getElementById('nombre-medico').textContent = `Nombre: ${data.nombre}`;
                document.getElementById('correo-medico').textContent = `Correo: ${data.correo}`;
                document.getElementById('especialidad-medico').textContent = `Especialidad: ${data.especialidad}`;
                document.getElementById('numero-consultas').textContent = `Número de Consultas: ${data.numero_consultas}`;

                const listaConsultasHoy = document.getElementById('lista-consultas-hoy');
                data.consultas_hoy.forEach(consulta => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${consulta.id}</td>
                        <td>${consulta.paciente}</td>
                        <td>${consulta.sintomas.substring(0, 100)}</td>
                        <td><button onclick="pasarConsulta(${consulta.id})">Pasar Consulta</button></td>
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