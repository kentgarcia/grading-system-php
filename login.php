</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMJS Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css
">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            background-color: rgb(251, 222, 135);
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            background: #fff;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
            overflow: hidden;
        }

        .sidebar {
            background-color: maroon;
            color: white;
            width: 300px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .sidebar img {
            width: 150px;
            margin-bottom: 20px;
        }

        .login-form {
            padding: 50px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-control {
            border-radius: 30px;
            padding: 12px;
            font-size: 16px;
        }

        .btn-primary {
            background-color: maroon;
            border: none;
            border-radius: 30px;
            padding: 12px;
            font-size: 18px;
        }

        .btn-primary:hover {
            background-color: #9b93c4;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 50px;
            }

            .sidebar img {
                width: 250px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="sidebar">
            <img src="kmjs.png" alt="KMJS Logo">
        </div>
        <div class="login-form">
            <h3 class="mb-4 text-center"><b>LOG-IN</b></h3>
            <form id="loginForm">

                <div class="mb-3">
                    <input type="text" class="form-control" id="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enter</button>
            </form>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');

        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username === "kent" && password === "password") {
                window.location.href = "index.php";
            } else if (username === "michelle" && password === "password") {
                window.location.href = "index.php";
            } else if (username === "jasper" && password === "password") {
                window.location.href = "index.php";
            } else if (username === "admin" && password === "password") {
                window.location.href = "index.php";
            } else if (username === "esmasin" && password === "password") {
                window.location.href = "index.php";
            } else {
                alert("Invalid username or password. Please try again.");
            }
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>