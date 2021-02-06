<?php

    require('./PokeService.php');
    require('./WeatherService.php');

    try {
        $pokeApi = new PokeService();
        $weatherApi = new WeatherService();
        $cidade = $_GET['cidade'] ?? 'Campinas';
        $result = ($weatherApi->getWeatherByCity($cidade));
        $pokemon = '';
        $temp ='';
        $type = '';
        
        if($result){
            
            $weather = $result['weather'][0]['main'] ?? '';
            $temp = round($result['main']['temp'] - 273, 0);  
            $type = '';
            
            if ($temp < 5){
                $type = 'ice';
            } else if($temp >= 5 and $temp < 10){
                $type = 'water';
            } else if($temp >= 12 and $temp < 15){
                $type = 'grass';
            } else if($temp >= 15 and $temp < 21){
                $type = 'ground';
            } else if($temp >= 23 and $temp < 27){
                $type = 'bug';
            } else if($temp >= 27 and $temp <= 33){
                $type = 'rock';
            } else if($temp > 33){
                $type = 'fire';
            } else {
                $type = 'normal';
            }
            
            if($weather == 'Rain'){
                $type = 'electric';
            }

            $pokemonType = $pokeApi->getPokemonByType($type);
            $pokemonCount = count($pokemonType['pokemon']) - 1;            
            $randPoke = $pokemonType['pokemon'][rand(0, $pokemonCount)];
            $pokemon = $randPoke['pokemon']['name'];            
        };
            
    } 
    catch(Exception $ex){
            var_dump($ex->getMessage());
    }
        ?>

<!DOCTYPE html>

<html>
  <head>
    <title>Pokémon Clima</title>
    <link rel="stylesheet" href="./assets/styles.css">
    <script src="./assets/index.js"></script>    
  </head>
  <body>
    <form method="GET">
      <div id="logo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/International_Pok%C3%A9mon_logo.svg/640px-International_Pok%C3%A9mon_logo.svg.png" alt="Pokémon" width="320">
      </div>
      <label for="city-input">Insira uma <strong>cidade</strong> para visualizar um pokémon de acordo com o clima</label>
      <input type="text" name="cidade" id="city-input" placeholder="ex: Campinas">
      <button>Buscar</button>
      <p id="pokemon">
      <?php
      echo "Em <strong>$cidade</strong> faz <strong>$temp</strong> ºC, e 
      é possível encontrar pokémons do tipo <strong>$type</strong> e sua sorte te
       apareceu um <strong>$pokemon</strong>";
        ?>

      </p>
    </form>
    <div>
    </div>
  </body>
</html>