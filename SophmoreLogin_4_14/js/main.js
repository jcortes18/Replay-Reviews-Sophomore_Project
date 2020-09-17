
$(document).ready(() => {
  $('#search-bar').on('submit', (e) => {
   let searchTitle = $('#searchTitle').val();
	  let radios = $(".search_type");
console.log(radios[2].checked);
	  if (radios[0].checked == true)
	{
		
		getMovies(searchTitle);
	}
	else if(radios[1].checked == true)
	{
			
		getGames(searchTitle);
	}
	else if(radios[2].checked == true)
	{
		getTVs(searchTitle);
	}
	
    e.preventDefault();
  });
});


///////////////////////////////////////////////////////////////////////////////////////////
//search results
///////////////////////////////////////////////////////////////////////////////////////////
function getMovies(searchTitle){
  axios.get('http://www.omdbapi.com/?apikey=754245a0&type=movie&s='+searchTitle)
    .then((response) => {
      console.log(response);
      let movies = response.data.Search;
      let output = '';
      $.each(movies, (index, movie) => {
        output += `
          <div class="col-md-3">
            <div class="well text-center">
              <img src="${movie.Poster}">
              <h5>${movie.Title}</h5>
              <a  onclick="movieSelected('${movie.imdbID}','${movie.Title}')" class="btn btn-primary" href="#"><span>Details</span></a>

            </div>
          </div>
        `;
      });
//onclick="movieSelected('${movie.imdbID}')"
      $('#titles').html(output);
    })
    .catch((err) => {
      console.log(err);
    });
}


function getGames(searchTitle){
  axios.get('https://api.rawg.io/api/games?page_size=3&search='+searchTitle)
    .then((response) => {
      console.log(response);

      let games = response.data.results;
	 
      let output = '';

      $.each(games, (index, game) => {

        output += `
          <div class="col-md-3">
            <div class="well text-center">
              <img src="${games[index].background_image}">
              <h5>${games[index].name}</h5>
              <a  onclick="gameSelected('${games[index].slug}')" class="btn btn-primary" href="#"><span>Details</span></a>
            </div>
          </div>
        `;

      });
//<p>${games[index].platforms[0].platform.name}<p>
      $('#titles').html(output);
    })
    .catch((err) => {
      console.log(err);
    });
}



function getTVs(searchTitle){
  axios.get('http://www.omdbapi.com/?apikey=754245a0&type=series&s='+searchTitle)
    .then((response) => {
      console.log(response);
      let movies = response.data.Search;
      let output = '';
      $.each(movies, (index, series) => {
        output += `
          <div class="col-md-3">
            <div class="well text-center">
              <img src="${series.Poster}">
              <h5>${series.Title}</h5>
              <a  onclick="tvSelected('${series.imdbID}','${series.Title}')" class="btn btn-primary" href="#"><span>Details</span></a>
            </div>
          </div>
        `;
      });
//onclick="movieSelected('${movie.imdbID}')"
      $('#titles').html(output);
    })
    .catch((err) => {
      console.log(err);
    });
}


//axios.get('http://www.omdbapi.com/?apikey=754245a0&type=series&s='+searchTitle)





function movieSelected(id, title){
  sessionStorage.setItem('movieId', id);
	sessionStorage.setItem('titleName', title);
	
	document.cookie="Title_Name=" + title;
  window.location = 'details.php';
  return false;
}
function tvSelected(id, title){
  sessionStorage.setItem('seriesId', id);
	sessionStorage.setItem('titleName', title);
	
  document.cookie="Title_Name=" + title;
  window.location = 'TVdetails.php';
  return false;
}
function gameSelected(games){
	sessionStorage.setItem('game', games);
	document.cookie="Title_Name=" + games;
	window.location = 'gameDetails.php';
	return false;
}





///////////////////////////////////////////////////////////////////////////////////////////
//Details Page
///////////////////////////////////////////////////////////////////////////////////////////
function getGame(){

	 let game = sessionStorage.getItem('game');

	
 axios.get('https://api.rawg.io/api/games/'+game)
    .then((response) => {
      let games = response.data;
      
	  console.log(games.name);
    
        output = `
    <div class="row">
          <div class="detail_poster">
            <img src="${games.background_image}" class="thumbnail">
          </div>
          <div class="details_list">
            <h2>${games.name}</h2>
			<li class="list-group-item"><strong>Released:</strong>${games.platforms[0].platform.name}</li>
              <li class="list-group-item"><strong>Released:</strong> ${games.released}</li>
              <li class="list-group-item"><strong>Rated:</strong> ${games.rating}</li>
          </div>
        </div>
        <div class="row">
          <div class="well">
            <h3>Plot</h3>
            ${games.description}


		<section id="site_buttons">
              <h3>Compare more ratings and reviews on these sites:</h3>

              <a href="https://www.gamespot.com/games/${games.slug}/reviews/" target="_blank" class="btn btn-primary">View Gamespot.com</a>

              <a href="https://www.ign.com/articles/${games.slug.replace(/[^A-Z0-9]+/ig, "-")}-review" target="_blank" class="btn btn-primary">View IGN.com</a>

              <a href="https://www.metacritic.com/game/${games.platforms[0].platform.name.toLowerCase()}/${games.slug.replace(/[^A-Z0-9]+/ig, "-").toLowerCase()}" target="_blank" class="btn btn-primary">View MetaCritic.com</a>

              <a href="https://www.gamezone.com/games/${games.slug.replace(/[^A-Z0-9]+/ig, "-").toLowerCase()}" target="_blank" class="btn btn-primary">View Gamezone.com</a>

            </section>

              <div style="text-align:center;">

              <a href="HomePage.php" class="btn btn-default" ">Go Back To Search</a>
            </div>


          </div>
        </div>
        `;

     
//
      $('#movie').html(output);
    })
    .catch((err) => {
      console.log(err);
    });

}

function getMovie(){

  let movieId = sessionStorage.getItem('movieId');

  axios.get('http://www.omdbapi.com/?apikey=754245a0&i='+movieId)
    .then((response) => {
      console.log(response);
      let movie = response.data;



      let output =`
        <div class="row">

          <div class="detail_poster">
            <img src="${movie.Poster}" class="thumbnail">
          </div>

          <div class="details_list">

            <h1>${movie.Title}</h1>

            <ul class="list-group">
              <li class="list-group-item"><strong>Released:</strong> ${movie.Released}</li>
              <li class="list-group-item"><strong>Length:</strong> ${movie.Runtime}</li>
              <li class="list-group-item"><strong>Rated:</strong> ${movie.Rated}</li>
              <li class="list-group-item"><strong>Genre(s):</strong> ${movie.Genre}</li>
            </ul>

            <h3>Overview</h3>
            <p>${movie.Plot}</p>

          </div>
        </div>

        <div class="row1">

          <div class="well">

            <ul class="list-group">
              <li class="list-group-item"><strong>Top Actors:</strong> ${movie.Actors}</li>
              <li class="list-group-item"><strong>Director:</strong> ${movie.Director}</li>
              <li class="list-group-item"><strong>Writer:</strong> ${movie.Writer}</li>
              <li class="list-group-item"><strong>Awards:</strong> ${movie.Awards}</li>
              <br><h3>Top Ratings</h3>
              <li class="list-group-item"><strong>IMDB:</strong> ${movie.imdbRating}</li>
              <li class="list-group-item"><strong>Rotten Tomatoes:</strong> ${movie.Ratings[1].Value}</li>
              <li class="list-group-item"><strong>MetaCritic:</strong> ${movie.Ratings[2].Value}</li>
            </ul>

            <section id="site_buttons">
              <h3>Compare more ratings and reviews on these sites:</h3>

              <a href="http://imdb.com/title/${movie.imdbID}" target="_blank" class="btn btn-primary">View IMDB.com</a>

              <a href=${"https://www.rottentomatoes.com/m/"}${movie.Title.replace(/[^A-Z0-9]+/ig, "_")} target="_blank" class="btn btn-primary">View RottonTomatoes.com</a>

              <a href="https://www.metacritic.com/movie/${movie.Title.replace(/[^A-Z0-9]+/ig, "-").toLowerCase()}" target="_blank" class="btn btn-primary">View MetaCritic.com</a>

              <a href="https://www.rogerebert.com/reviews/${movie.Title.replace(/[^A-Z0-9]+/ig, "-").toLowerCase()+"-"+movie.Year}" target="_blank" class="btn btn-primary">View RogerEbert.com</a>

            </section>

              <div style="text-align:center;">

              <a href="HomePage.php" class="btn btn-default" ">Go Back To Search</a>
</div>

          </div>
        </div>
      `;
      //https://www.rogerebert.com/reviews
      //.replace(/\s/g, "_");
      $('#movie').html(output);
    })
    .catch((err) => {
      console.log(err);
    });
}


function getTV(){
	  let seriesId = sessionStorage.getItem('seriesId');

  axios.get('http://www.omdbapi.com/?apikey=754245a0&i='+seriesId)
    .then((response) => {
      console.log(response);
      let series = response.data;
console.log(series.Title);




      let output =`
        <div class="row">
          <div class="detail_poster">
            <img src="${series.Poster}" class="thumbnail">
          </div>
          <div class="details_list">

            <h1>${series.Title}</h1>

            <ul class="list-group">

              <li class="list-group-item"><strong>Released:</strong> ${series.Released}</li>
              <li class="list-group-item"><strong>Rated:</strong> ${series.Rated}</li>
              <li class="list-group-item"><strong>Genre(s):</strong> ${series.Genre}</li>
              <li class="list-group-item"><strong>Seasons:</strong> ${series.totalSeasons}</li>
              <li class="list-group-item"><strong>IMDB Rating:</strong> ${series.imdbRating}</li>

              <h3>Overview</h3>
              ${series.Plot}

            </ul>
          </div>
        </div>

        <div class="row1">
          <div class="well">
            <ul class="list-group">
              <li class="list-group-item"><strong>Top Actors:</strong> ${series.Actors}</li>
              <li class="list-group-item"><strong>Director:</strong> ${series.Director}</li>
              <li class="list-group-item"><strong>Writer:</strong> ${series.Writer}</li>
              <li class="list-group-item"><strong>Awards:</strong> ${series.Awards}</li>

            </ul>
            <section id="site_buttons">
              <h3>Compare more ratings and reviews on these sites:</h3>

              <a href="http://imdb.com/title/${series.imdbID}" target="_blank" class="btn btn-primary">View IMDB.com</a>

              <a href=${"https://www.rottentomatoes.com/tv/"}${series.Title.replace(/[^A-Z0-9]+/ig, "_")} target="_blank" class="btn btn-primary">View RottonTomatoes.com</a>

              <a href="https://www.metacritic.com/tv/${series.Title.replace(/[^A-Z0-9]+/ig, "-").toLowerCase()}" target="_blank" class="btn btn-primary">View MetaCritic.com</a>

              <a href="https://www.rogerebert.com/reviews/${series.Title.replace(/[^A-Z0-9]+/ig, "-").toLowerCase()+"-"+series.Year}" target="_blank" class="btn btn-primary">View RogerEbert.com</a>

              </section>
 <div style="text-align:center;">

              <a href="HomePage.php" class="btn btn-default" ">Go Back To Search</a>
</div>


          </div>
        </div>
      `;
      //https://www.rogerebert.com/reviews
//.replace(/\s/g, "_");
      $('#series').html(output);
    })
    .catch((err) => {
      console.log(err);
    });
}


