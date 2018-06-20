(function(){
    onload = function(){
    const $modal = $('[data-js="modal2"]');
    const $formLogin = $('[data-js="form-compra"]');//document.querySelector('[data-js="form-login"]');
    const $ModalText = $('[data-js="modal2-text"]');
    
    $formLogin.on('submit', function(e){
        e.preventDefault();
        $.ajax({
        url: "controller.php",
        type: "POST",
        data: $formLogin.serialize(),
        success: function( data ) {
            if ( data == 0 ) {
                $ModalText.text('Erro, a tabela deve estar ocupada ou o estoque esgotou para essa quantidade de itens.');
                $modal.modal();
            } else {
                $ModalText.text('Compra Realizada Com Sucesso!');
                $modal.modal();
            }
        }});
    });
   }
})();

function comprar(elemento){
    
    const $id = $(elemento).parent().prev().prev().prev().prev().prev().prev();
    const $preco = $(elemento).parent().prev().prev().prev().prev().prev();
    const $descricao = $(elemento).parent().prev().prev().prev().prev();
    const $qtd = $(elemento).parent().prev().children();

    const $modal = $('[data-js="modal2"]');
    const $ModalText = $('[data-js="modal2-text"]');

    $.ajax({
        url: "controller.php",
        type: "POST",
        data: {
            action:"bloquear",
            id: $id.val(),
            qtd: $qtd.val(),
            preco: $preco.val(),
            descricao: $descricao.val()
        },
        success: function( data ) {
            const obj = JSON.parse(data);
            $('[data-js="produtoid"]').val(obj.id);
            $('[data-js="precototal"]').val(obj.preco);
            $('[data-js="descricao"]').val(obj.descricao);
            $('[data-js="qtd"]').val(obj.qtd);
            $('[data-js="modal"]').modal();
            if ( obj.msg == 0 ) {
                $ModalText.text('Erro no bloqueio');
                $modal.modal();
            } else {
                $ModalText.text('Bloqueado com sucesso!');
                $modal.modal();
            }
    }});
}