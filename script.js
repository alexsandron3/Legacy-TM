const buttonEnviar = document.getElementById('buttonEviaDataPasseio');
// synchronous
buttonEnviar.addEventListener('click', (event) => {
  event.preventDefault();
  const divAdd = document.getElementById('tbodyTeste');
  const inicioDataPasseio = document.getElementById('inicioDataPasseio');
  const fimDataPasseio = document.getElementById('fimDataPasseio');
  // console.log(inicioDataPasseio.value, fimDataPasseio.value)
  $.get("backend-search.php", {
    inicio: inicioDataPasseio.value,
    fim: fimDataPasseio.value,
  }).done(function(data) {
    divAdd.innerHTML = data;
  });
})

// Asynchronous
$(document).ready(function() {
  const intervalId = window.setInterval(function() {
    const divAdd = document.getElementById('tbodyTeste');
    // const qttOfElements = document.querySelectorAll('#tbodyTeste tr');
    const inicioDataPasseio = document.getElementById('inicioDataPasseio');
    const fimDataPasseio = document.getElementById('fimDataPasseio');
    if (inicioDataPasseio.value && fimDataPasseio.value){
        let contador = 30;
        setInterval(()=> {
          const refreshText = document.getElementById('refreshText');
          refreshText.innerHTML = `Próxima atualização em: ${contador -= 1} segundos`;
          if (contador === 0 ){
            contador = 30;
            $.get("backend-search.php", {
              inicio: inicioDataPasseio.value,
              fim: fimDataPasseio.value
            }).done(function(data) {
              divAdd.innerHTML = data;
            });
          }
        }, 1000)
      }
  }, 30000);
});