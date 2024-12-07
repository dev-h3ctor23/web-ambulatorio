document.addEventListener('DOMContentLoaded', function() {
    // Obtener el ID del usuario desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const usuarioId = urlParams.get('id');

    if (!usuarioId) {
        console.error('ID de usuario no proporcionado');
        return;
    }

    fetch(`server/datos-paciente.php?id=${usuarioId}`)
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
                document.getElementById('nombre-paciente').textContent = `Nombre: ${data.nombre}`;
                document.getElementById('correo-paciente').textContent = `Correo: ${data.correo}`;
                document.getElementById('dni-paciente').textContent = `DNI: ${data.dni}`;
            }
        })
        .catch(error => console.error('Error:', error));
});