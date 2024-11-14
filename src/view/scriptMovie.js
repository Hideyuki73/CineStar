async function registraMovie() {
    const movie = {
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        rating: document.getElementById('rating').value,
    };
    let data = await fetch("http://localhost:8080/src/api/movies", {
        method: "POST",
        body: JSON.stringify(movie)
    }).then(resp => resp.text());
    console.log(data)
}

async function fetchMovies() {
    let movies = await fetch(`http://localhost:8080/src/api/movies`, {
        method: "GET",
    }).then(response => response);
    return movies.json();
}


async function fetchMovie(id) {
    let movies = await fetch(`http://localhost:8080/src/api/movies?id=${id}`, {
        method: "GET",
    }).then(response => response);
    return movies.json();
}

async function removeMovie(meuId) {
    let data = await fetch("http://localhost:8080/src/api/movies", {
        method: "DELETE",
        body: JSON.stringify({
            id: meuId
        })
    }).then(resp => resp.text());
    window.location.reload();
}

async function carregarMovies() {
    const tabela = document.querySelector('#movieTable tbody');
    let dado = await fetchMovies();
        dado.forEach((movie) => {
            const linha = `<tr>
            <td>${movie.nome}</td>
            <td>${movie.descricao}</td>
            <td>${movie.rating}</td>
            <td><button onclick="removeMovie(${movie.id})">Deletar</button></td>
            <td><button onclick="window.location.href='/src/view/registermovie.html?id=${movie.id}'">Editar</button></td>

        </tr>`;
            tabela.innerHTML += linha;
        });
}

carregarMovies()

async function onUpdate() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        let id = parseInt(fromGet.get("id"));
        let movieData = await fetchMovie(id);
        console.log(movieData)
        document.getElementById('nome').value = movieData["nome"]
        document.getElementById('descricao').value = movieData["descricao"]
        document.getElementById('rating').value = movieData["rating"]
    }
}

async function editMovie(id) {
    const movie = {
        id: id,
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        rating: document.getElementById('rating').value,
    };
    let data = await fetch("http://localhost:8080/src/api/movies", {
        method: "PUT",
        body: JSON.stringify(movie)
    }).then(resp => resp.text());
    console.log(data);
}

function detectType() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        editMovie(fromGet.get("id"));
    } else {
        registraMovie();
    }
}