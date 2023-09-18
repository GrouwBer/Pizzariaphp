const tabela = document.querySelector("table");
tabela.addEventListener("click", (event) => {
    let isBotaoExcluir = event.target.classList.contains("btn-excluir");
    if (isBotaoExcluir && !confirm("Tem certeza que deseja excluir este item?")) {
        event.preventDefault();
    }
});