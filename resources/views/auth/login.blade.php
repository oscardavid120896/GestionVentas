<!DOCTYPE html>
<html lang="es">
<head>
	<title>Gestión de Calificaciones</title>
	<link rel="stylesheet" type="text/css" href="../css/estiloLogin.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="../img/wave.png">
	<div class="container">
		<div class="img">
			<img src="../img/login.svg">
		</div>
		<div class="login-content">
			<form method="POST" action="{{ route('login') }}" id="login">
            {{!! crsf_field() !!}}
				<img src="../img/profile.svg">
				<h2 class="title">Bienvenido</h2>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong style="color:red;">{{ $message }}</strong>
                    </span> <br> <br>
                @enderror
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-envelope"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Correo Electrónico</h5>
           		   		<input id="email" type="email" class="input @error('email') is-invalid @enderror"name="email" required autocomplete="email" maxlength="50"><br><br>
                        <div id="feedback-email" style="color:red;"></div>

           		   </div>
                </div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Contraseña</h5>
           		    	<input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" maxlength="8"><br><br>
                        <div id="feedback-password" style="color:red;"></div>

            	   </div>
            	</div>
                <br>
            	<div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        @if (Route::has('password.request'))
                            <a  href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif
                        <button type="submit" value="submit" id="btn1" class="btn btn-primary">
                            {{ __('Ingresar') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/validaciones.js"></script>
    
</body>
</html>
