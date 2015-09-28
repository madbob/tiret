@extends($theme_layout)

@section('content')
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }}">Pannello Amministrazione</a></li>
    <li class="active">Utenti</li>
</ol>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 options">
            <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#createUser">Aggiungi Utente</button>
            <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#importCSV">Importa CSV Utenti</button>
        </div>

        <div class="col-md-8 contents">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome e Mail</th>
                        <th>Username</th>
                        <th>Ultimo Accesso</th>
                        <th>Stato</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            {{ $user->name }} {{ $user->surname }}<br/>
                            {{ $user->email }}
                        </td>
                        <td>{{ $user->username }}</td>
                        <td><?php if($user->lastlogin == '0000-00-00') echo "Mai"; else echo $user->lastlogin ?></td>
                        <td>
                            @if($user->suspended == true)
                            <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                            @endif
                        </td>
                        <td class="text-right"><a class="btn btn-default" href="{{ url('admin/show/' . $user->id) }}">Modifica</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.edituser', ['id' => 'createUser', 'title' => 'Aggiungi Utente', 'user' => null])

<div class="modal fade" id="importCSV" tabindex="-1" role="dialog" aria-labelledby="importCSVLavel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Aggiungi Utente</h4>
            </div>
            <form method="POST" action="{{ url('admin/import') }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-body">
                    <p>
                        Nota bene: il file deve essere in formato CSV (no XLS!), formattato con<br/>
                        nome,cognome,username,indirizzo mail,nome del gruppo di riferimento
                    </p>
                    <p>
                        Si raccomanda di togliere eventuali righe di intestazione in cima al file.
                    </p>
                    <p>
                        I nuovi utenti generati riceveranno una mail con le credenziali di accesso.
                    </p>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection