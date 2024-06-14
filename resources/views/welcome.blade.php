<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Trechos</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f5f5f5;
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .container {
      display: flex;
      flex-direction: column;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      max-width: 900px;
      width: 100%;
    }

    .form-wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .form-container {
      flex: 1;
    }

    .map-container {
      flex: 1;
      height: 400px;
      border-radius: 8px;
      overflow: hidden;
    }

    h1 {
      margin-bottom: 20px;
    }

    form div {
      margin-bottom: 15px;
      text-align: left;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input, select, button {
      width: 100%;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }

    #map {
      width: 100%;
      height: 100%;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Cadastro de Trechos</h1>
    <div class="form-wrapper">
      <div class="form-container">
        <form id="trecho-form">
          <div>
            <label for="data_referencia">Data de Referência</label>
            <input id="data_referencia" type="date" required>
          </div>
          
          <div>
            <label for="uf_id">Unidade da Federação</label>
            <select id="uf_id" required>
              <option value="1">AC</option>
              <option value="2">AL</option>
              <option value="3">AM</option>
              <option value="4">AP</option>
              <option value="5">BA</option>
              <option value="6">CE</option>
              <option value="7">DF</option>
              <option value="8">ES</option>
              <option value="9">GO</option>
              <option value="10">MA</option>
              <option value="11">MG</option>
              <option value="12">MS</option>
              <option value="13">MT</option>
              <option value="14">PA</option>
              <option value="15">PB</option>
              <option value="16">PE</option>
              <option value="17">PI</option>
              <option value="18">PR</option>
              <option value="19">RJ</option>
              <option value="20">RN</option>
              <option value="21">RO</option>
              <option value="22">RR</option>
              <option value="23">RS</option>
              <option value="24">SC</option>
              <option value="25">SE</option>
              <option value="26">SP</option>
              <option value="27">TO</option>
            </select>
          </div>
          
          <div>
            <label for="rodovia_id">Rodovia</label>
            <select id="rodovia_id" required>
              <!-- Os valores das opções devem ser preenchidos dinamicamente -->
              <option value="1">Rodovia 1</option>
              <option value="2">Rodovia 2</option>
            </select>
          </div>
          
          <div>
            <label for="tipo">Tipo de Trecho</label>
            <select id="tipo" required>
              <option value="B">Tipo B</option>
            </select>
          </div>
          
          <div>
            <label for="quilometragem_inicial">Quilometragem Inicial</label>
            <input id="quilometragem_inicial" type="number" step="0.1" required>
          </div>
          
          <div>
            <label for="quilometragem_final">Quilometragem Final</label>
            <input id="quilometragem_final" type="number" step="0.1" required>
          </div>
          
          <button type="button" onclick="submitForm()">Salvar</button>
        </form>
      </div>

      <div class="map-container" id="map-container">
        <h2>Mapa do Trecho</h2>
        <div id="map"></div>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
    async function submitForm() {
      const form = document.getElementById('trecho-form');
      const data_referencia = form.data_referencia.value;
      const uf_id = form.uf_id.value;
      const rodovia_id = form.rodovia_id.value;
      const tipo = form.tipo.value;
      const quilometragem_inicial = form.quilometragem_inicial.value;
      const quilometragem_final = form.quilometragem_final.value;

      // Substituir as strings abaixo com os valores corretos obtidos do backend
      const ufNome = form.uf_id.options[form.uf_id.selectedIndex].text; // Nome da UF
      const rodoviaNome = 'Rodovia Nome'; // Valor de exemplo, substituir pelo valor correto

      try {
        const response = await axios.get('https://servicos.dnit.gov.br/sgplan/apigeo/rotas/espacializarlinha', {
          params: {
            br: rodoviaNome,
            tipo: tipo,
            uf: ufNome,
            cd_tipo: null,
            data: data_referencia,
            kmi: quilometragem_inicial,
            kmf: quilometragem_final,
          }
        });

        const geo = response.data;
        console.log(geo); // Verifique o retorno da API

        document.getElementById('map-container').style.display = 'block';

        const map = L.map('map').setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19
        }).addTo(map);

        const geoLayer = L.geoJSON(geo);
        geoLayer.addTo(map);
        map.fitBounds(geoLayer.getBounds());
      } catch (error) {
        console.error('Erro ao buscar os dados da API:', error);
      }
    }
  </script>
</body>
</html>
