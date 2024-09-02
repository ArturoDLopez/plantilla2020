<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body background=''>
    
    <div class="container">
        <div class=" d-flex justify-content-center bg-secondary rounded">
            <form action='<?= base_url('seccion/validate')?>' method='POST' id='frm_login'>
                <div class="form-group" id='email'>
                    <label for="exampleInputEmail1">Correo electronico</label>
                    <input type="email" name='email' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingresa tu correo">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                    <div class='invalid-feedback'>El correo es invalido</div>
                </div>
                <div class="form-group" id='password'>
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="password" name='password' class="form-control" id="exampleInputPassword1" placeholder="Ingres tu contraseña">
                    <div class='invalid-feedback'>La contraseña es requerida</div>
                </div>
                <!-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1"></label>
                </div> -->
                <button type="submit" class="btn btn-primary">Entrar</button>

                <div class="form-group" id='alert'>
                    
                </div>
            </form>
        </div>
    </div>
   
    
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   <script src='assets\js\login.js' ></script>
</body>
</html>