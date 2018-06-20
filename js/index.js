(function(){
    onload = function(){
    const $modal = $('[data-js="modal"]');
    const $formLogin = $('[data-js="form-login"]');//document.querySelector('[data-js="form-login"]');
    const $ModalText = $('[data-js="modal-text"]');
    
    $formLogin.on('submit', function(e){
        e.preventDefault();
        $.ajax({
        url: "controller.php",
        type: "POST",
        data: $formLogin.serialize(),
        success: function( data ) {
            if ( data == 0 ) {
                $ModalText.text('Dados inválidos');
                $modal.modal();
            } else {
                location = "loja.php?clientid="+data;
            }
        }});
    });
   }
})();