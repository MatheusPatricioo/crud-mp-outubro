@extends('admin.template')

@section('title', 'Patricio - ' . $page->op_title . ' - Links')

@section('content')

<div class="preheader">
    Página: {{$page->op_title}}
</div>

<div class="area">
    <div class="leftside">
        <header>
            <header>
                <ul>
                    <li @if ($menu == 'links') class="active" @endif><a
                            href="{{url('/admin/' . $page->slug . '/links')}}">Links</a></li>
                    <li @if ($menu == 'design') class="active disabled" @endif><a
                            href="{{url('/admin/' . $page->slug . '/design')}}" class="disabled">Aparência</a></li>
                    <li @if ($menu == 'stats') class="active disabled" @endif><a
                            href="{{url('/admin/' . $page->slug . '/stats')}}" class="disabled">Estatísticas</a></li>
                </ul>
            </header>

        </header>
        @yield('body')
    </div>
    <div class="rightside">
        <iframe frameborder="0" src="{{url('/' . $page->slug)}}"></iframe>
    </div>
</div>

@endsection