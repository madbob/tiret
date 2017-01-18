@extends($theme_layout)

@section('content')
<ol class="breadcrumb">
    <li class="pull-right"><a href="{{ url('/auth/logout') }}">Logout</a></li>
</ol>

<div class="container-fluid">
    @if(!empty($user->group->message))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                {{ $user->group->message }}
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <input type="text" class="form-control" id="textfilter" autocomplete="off" placeholder="Cerca...">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @if(count($files) == 0)
                <p class="alert alert-info">Non hai files assegnati</p>
            @else
                @if(env('GROUPING_RULE', '') != '')
                    <?php

                        $file_groups = [];

                        foreach($files as $file) {
                            preg_match(env('GROUPING_RULE'), basename($file), $matches);
                            if (isset($matches['key']))
                                $name = $matches['key'];
                            else
                                $name = '?';

                            if (isset($file_groups[$name]) == false)
                                $file_groups[$name] = [];
                            $file_groups[$name][] = $file;
                        }

                    ?>

                    <ul class="nav nav-tabs" role="tablist">
                        <?php $index = 0 ?>
                        @foreach($file_groups as $name => $files)
                            <li role="presentation" {!! $index++ == 0 ? 'class="active"' : '' !!}><a href="#{{ $name }}" aria-controls="{{ $name }}" role="tab" data-toggle="tab">{{ $name }}</a></li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        <?php $index = 0 ?>
                        @foreach($file_groups as $name => $files)
                            <div role="tabpanel" class="tab-pane {{ $index++ == 0 ? 'active' : '' }}" id="{{ $name }}">
                                <table class="table filelist filteratable">
                                    <tbody>
                                        @foreach($files as $file)
                                            <tr>
                                                <td><a href="{{ url('file/' . $file) }}">{{ basename($file) }}</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                @else
                    <table class="table filelist filteratable">
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td><a href="{{ url('file/' . $file) }}">{{ basename($file) }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        </div>
        <div class="col-md-6">
            @if(count($groupfiles) == 0)
                <p class="alert alert-info">Il tuo gruppo non ha files assegnati</p>
            @else
                <table class="table filelist filteratable">
                    <tbody>
                        @foreach($groupfiles as $file)
                            <tr>
                                <td><a href="{{ url('file/' . $file) }}">{{ basename($file) }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
