function enviarLocalizacao(event) {
    event.preventDefault(); // Previne o envio do formulário sem antes obter a localização

    if (!navigator.geolocation) {
      alert('Geolocalização não é suportada por este navegador.');
      return;
    }

    navigator.geolocation.getCurrentPosition(function(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;

      fetch('/send-message-localizacao', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                latitude: latitude,
                longitude: longitude
            })
        })
      .then(response => response.json())
      .then(data => {
        //alert('Localização enviada com sucesso!');
        // Após enviar localização, envie o formulário
            document.getElementById('latitude').value = latitude;
            document.getElementById('longitude').value = longitude;
            event.target.submit();
      })
      .catch(error => {
        alert('Erro ao enviar localização.');
        console.error('Erro:', error);
      });
    }, function(error) {
      alert('Erro ao obter localização: ' + error.message);
    });

    return false; // Impede o envio do formulário até terminar o processo de geolocalização

  }

  window.enviarLocalizacao = enviarLocalizacao;