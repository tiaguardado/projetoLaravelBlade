import './bootstrap';

window.confirmdDelete = function (id) {
    Swal.fire({
        title: "Tem a certeza?",
        text: "Não será possível reverter esta ação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3185d5",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, eliminar!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

