<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
        }
    </style>

</head>
<body>
    
    <div class="container">
        <div class="form-container bg-secondary rounded p-4">
            <form action='<?= base_url('seccion/validate')?>' method='POST' id='frm_login'>
                <div class="form-group" id='email'>
                    <label for="exampleInputEmail1">Correo electronico</label>
                    <input type="email" name='email' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingresa tu correo">
                    <div class='invalid-feedback'>El correo es invalido</div>
                </div>
                <div class="form-group" id='password'>
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="password" name='password' class="form-control" id="exampleInputPassword1" placeholder="Ingresa tu contraseña">
                    <div class='invalid-feedback'>La contraseña es requerida</div>
                </div>
                <button type="submit" class="btn btn-primary">Entrar</button>

                <div class="form-group" id='alert'>
                    
                </div>
            </form>
        </div>
    </div>
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
   <script src='assets\js\login.js'></script>
</body>
</html>
