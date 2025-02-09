document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginButton").addEventListener("click", function () {
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        fetch("https://localhost/api/login_check", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                username: email,
                password: password
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.token) {
                localStorage.setItem("jwt_token", data.token);
                console.log("Zapisano JWT:", data.token);
                window.location.href = "/dashboard"; // Przekierowanie po zalogowaniu
            } else {
                console.error("Błąd logowania:", data.message);
            }
        })
        .catch(error => console.error("Błąd:", error));
    });

    // Automatyczne dodanie JWT do wszystkich żądań do API
    if (localStorage.getItem("jwt_token")) {
        fetch("https://localhost/api/users/show", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + localStorage.getItem("jwt_token")
            }
        })
        .then(response => response.json())
        .then(data => console.log("Dane użytkownika:", data))
        .catch(error => console.error("Błąd:", error));
    } else {
        console.warn("Brak tokena JWT w localStorage!");
    }
});
