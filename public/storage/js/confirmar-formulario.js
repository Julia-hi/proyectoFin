/**
 * Modal para confirmar formularios
 * 
 * usado libreria https://sweetalert2.github.io
 */
$(document).ready(function () {
    document.getElementById('submit-button').addEventListener("click", showModal());
});

function showModal() {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })
      
      swalWithBootstrapButtons.fire({
        title: 'Publicar anuncio?',
        text: "(puedes editar antes de publicar)",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, publicar!',
        cancelButtonText: 'No, volver!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire(
            'Publicato!',
            'Puedes gestionar tus anuncios en area personal',
            'success'
          )
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
          )
        }
      })
}