
<h2>Formulario de contacto</h2>
<form action={{route('contact')}} method="POST">
     {{ csrf_field() }}
    <div class="form-group">
        <label for="name">Nombre</label>
        <input name="name" type="text">
    </div>
    <div class="form-group">
        <label for="msg">Mensaje</label>
        <input name="msg" type="text">
    </div>
    <div class="form-group">
        <button type="submit" id='btn-contact' class="btn">Enviar</button>
    </div>
</form>
