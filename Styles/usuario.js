document.addEventListener('DOMContentLoaded', function () {
    const userNameElement = document.querySelector('.user-name');
    const userEmailElement = document.querySelector('.user-email');
    const saveButton = document.querySelector('button');

    saveButton.addEventListener('click', function () {
        const newName = userNameElement.innerText;
        const newEmail = userEmailElement.innerText;

        // Aquí puedes guardar newName y newEmail en el almacenamiento local o enviarlos a un servidor
        // Ejemplo guardando en localStorage:
        localStorage.setItem('username', newName);
        localStorage.setItem('email', newEmail);

        alert('Cambios guardados correctamente');
    });
});
