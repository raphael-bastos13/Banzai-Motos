document.addEventListener('DOMContentLoaded', function() {
    const botoesCompra = document.querySelectorAll('.btn-compra');
  
    botoesCompra.forEach(function(botao) {
      botao.addEventListener('click', function(event) {
        event.preventDefault();
        const nomeEquipamento = this.parentElement.querySelector('.modelo-equipamento').innerText;
        
        // Adiciona o nome do equipamento ao modal
        const carrinhoLista = document.getElementById('carrinho-lista');
        const li = document.createElement('li');
        li.classList.add('list-group-item');
        li.innerText = nomeEquipamento;
        carrinhoLista.appendChild(li);
  
        // Abre o modal
        const modal = new bootstrap.Modal(document.getElementById('carrinhoModal'));
        modal.show();
      });
    });
  });
  