import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone',{
    dictDefaultMessage: "Sube tu imagen Aqui",
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,

    // Mantiene la imagen si enviarmos los datos del formulario incompletos

    init: function(){
        if (document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada = {}
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call(this, imagenPublicada);

            this.options.thumbnail.call(
                this,
                imagenPublicada,
                `/uploads/${imagenPublicada.name}`
            );

            imagenPublicada.previewElement.classList.add(
                "dz-success",
                "dz-complete"
            );
        }
    }


});

// const dropzone = new dropzone('#dropzone', {
//     dictDefaultMessage: "Sube tu imagen Aqui",
//     acceptedFiles: ".png,.jpg,.jpeg,.gif",
//     addRemoveLinks: true,
//     dictRemoveFile: "Borrar Archivo",
//     maxFiles: 1,
//     uploadMultiple: false,
// });

//  Borramos el valor del input al borrar la imagen
dropzone.on("removedfile", function(){
    document.querySelector('[name="imagen"]').value = ""
});

dropzone.on("sending", function (file, xhr, formData){
    console.log(formData);
    
});

dropzone.on("success", function (file, response){
    console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
    
});

dropzone.on("error", function (file, message){
    console.log(message);
    
});

dropzone.on("removedfile", function (){
    console.log("Mensaje eliminado");

});