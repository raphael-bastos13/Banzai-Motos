document.getElementById('search').addEventListener('click', function () {
  // Obtém os valores dos campos de filtro
  const tipoFiltro = document.getElementById('tipo-filtro').value;
  const valorFiltro = document.getElementById('valor-pesquisa').value;

  // Cria um objeto para os dados do formulário
  const formData = new FormData();
  formData.append('tipoFiltro', tipoFiltro);
  formData.append('valorFiltro', valorFiltro);

  // Faz a requisição AJAX
  fetch('consulta_usuarios.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      // Atualiza a tabela com os resultados
      const tbody = document.getElementById('user-table-body');
      tbody.innerHTML = ''; // Limpa a tabela

      if (data.length > 0) {
          data.forEach(row => {
              const tr = document.createElement('tr');

              const idCell = document.createElement('td');
              idCell.textContent = row.id;
              tr.appendChild(idCell);

              const nomeCell = document.createElement('td');
              nomeCell.textContent = row.nome;
              tr.appendChild(nomeCell);

              const cpfCell = document.createElement('td');
              cpfCell.textContent = row.cpf;
              tr.appendChild(cpfCell);

              const emailCell = document.createElement('td');
              emailCell.textContent = row.email;
              tr.appendChild(emailCell);

              tbody.appendChild(tr);
          });
      } else {
          const tr = document.createElement('tr');
          const td = document.createElement('td');
          td.colSpan = 4;
          td.textContent = 'Nenhum registro encontrado.';
          tr.appendChild(td);
          tbody.appendChild(tr);
      }
  })
  .catch(error => console.error('Erro:', error));
});

Swal.fire({
    title: "Ação concluida",
    text: "Conta deleta com sucesso!",
    icon: "success"
  });