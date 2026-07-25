<!DOCTYPE html>
<html>
 <head>
  <title>Message</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <!-- Styles -->
  <style>
      html, body {
          background-color: #fff;
          color: #636b6f;
          font-family: 'Nunito', sans-serif;
          font-weight: 200;
          height: 100vh;
          margin: 0;
      }
      .content { text-align: center; }
      .title { font-size: 84px; }
  </style>
 </head>
 <body>
  <br />
  <div class="container box" style="width: 970px;">
    
   <p>Estimado(a) {{ $data['name'] }},
       Recuerda que tu próxima cita en Imagenes Orales es el {{ $data['date'] }} a las {{ $data['time'] }}.
    </p>
    <h4>Información de contacto:</h4>
    <p>Imagenes Orales<br>
    Teléfono: {{ $data['phone'] }}<br>
    Email: {{ $data['email'] }}</p>

    <p>Te agradecemos que nos confirmes tu asistencia. Te esperamos. Que tengas un excelente día!!.</p>  
   
  </div>
 </body>
</html>