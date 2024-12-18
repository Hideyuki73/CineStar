async function registrauser() {
    const user = {
        nickname: document.getElementById('nickname').value,
        email: document.getElementById('email').value,
        senha: document.getElementById('senha').value
    };
    let data = await fetch("http://localhost:8080/src/api/users", {
        method: "POST",
        body: JSON.stringify(user)
    }).then(resp => resp.text());

    window.location.href = "/src/view/login.html"
}

async function logaruser() {
    const user = {
        email: document.getElementById('login-email').value,
        senha: document.getElementById('login-password').value
    };
    let response = await fetch("http://localhost:8080/src/api/users/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(user)
    });

    if (response.ok) {
        let data = await response.json();
        localStorage.setItem('user_id', data.user_id); 
        window.location.href = "/src/view/home.html";
    } else {
        alert("Erro ao fazer login. Verifique suas credenciais.");
    }
}

async function logout() {
    let response = await fetch("http://localhost:8080/src/api/users/logout", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
    });

    console.log(response);

    window.location.href='/src/view/';
}


async function fetchUsers() {
    let users = await fetch(`http://localhost:8080/src/api/users`, {
        method: "GET",
    }).then(response => response);
    return users.json();
}

async function fetchUser(id) {
    let users = await fetch(`http://localhost:8080/src/api/users?id=${id}`, {
        method: "GET",
    }).then(response => response);
    return users.json();
}

async function removeUser(meuId) {
    let data = await fetch("http://localhost:8080/src/api/users", {
        method: "DELETE",
        body: JSON.stringify({
            id: meuId
        })
    }).then(resp => resp.text());
    window.location.reload();
}

async function onUpdate() {
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        let id = parseInt(fromGet.get("id"));
        let userData = await fetchUser(id);
        document.getElementById('nickname').value = userData["nickname"]
        document.getElementById('email').value = userData["email"]
        document.getElementById('senha').value = userData["senha"]
    }
}

async function editUser(id){
    const user = {
        id: id,
        nickname: document.getElementById('nickname').value,
        email: document.getElementById('email').value,
        senha: document.getElementById('senha').value,
    };
    let data = await fetch("http://localhost:8080/src/api/user", {
        method: "PUT",
        body: JSON.stringify(user)
    }).then(resp => resp.text());
}

function detectType(){
    let fromGet = new URLSearchParams(window.location.search);
    if (fromGet.size != 0) {
        editUser(fromGet.get("id"));
    }else {
        registrauser();
    }
}

onUpdate();