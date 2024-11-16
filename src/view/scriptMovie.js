async function registraMovie() {
    const movie = {
        nome: document.getElementById('nome').value,
        descricao: document.getElementById('descricao').value,
        rating: document.getElementById('rating').value,
    };

    let userId = localStorage.getItem('user_id');
    if (!userId) {
        alert("Usuário não autenticado. Faça login novamente.");
        return;
    }

    let response = await fetch("http://localhost:8080/src/api/movies", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ...movie })
    });

    if (response.ok) {
        alert("Filme cadastrado com sucesso!");
        window.location.href = "/src/view/home.html";
    } else {
        alert("Erro ao cadastrar filme.");
    }
}


async function fetchMovies() {
    let userId = localStorage.getItem('user_id');
    if (!userId) {
        alert("Usuário não autenticado. Faça login novamente.");
        return [];
    }

    let response = await fetch(`http://localhost:8080/src/api/movies`, {
        method: "GET",
        headers: { "Content-Type": "application/json" }
    });

    if (response.ok) {
        return await response.json();
    } else {
        alert("Erro ao carregar filmes.");
        return [];
    }
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
    tabela.innerHTML = "";

    let filmes = await fetchMovies();
    filmes.forEach((movie) => {
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