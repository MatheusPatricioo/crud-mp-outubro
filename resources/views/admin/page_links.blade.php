@extends('admin.page')

@section('body')
<a class="bigbutton" href="{{ url('/admin/' . $page->slug . '/newlink') }}">Novo Link</a>

<ul id="links">
    @foreach ($links as $link)
        <li class="link--item">
            <div class="link--item-order">
                <img src="{{ url('/assets/images/sort.png') }}" alt="Ordenar" width="18">
            </div>
            <div class="link--item-info">
                <div class="link--item-title">{{ $link->title }}</div>
                <div class="link--item-href">{{ $link->href }}</div>
            </div>
            <div class="link--item-buttons">
                <!-- Botão de editar -->
                <a href="{{ url('/admin/' . $page->slug . '/editlink/' . $link->id) }}" class="button-edit">Editar</a>

                <!-- Botão de excluir com formulário para envio de DELETE -->
                <form action="{{ url('/admin/' . $page->slug . '/dellink/' . $link->id) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button-delete"
                        onclick="return confirm('Tem certeza que deseja excluir este link?')">Excluir</button>
                </form>
            </div>
        </li>
    @endforeach
</ul>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    new Sortable(document.querySelector('#links'), {
        animation: 150,
        onEnd: async (e) => {
            let id = e.item.getAttribute('data-id');
            let link = "{{ url('/admin/linkorder') }}" + `/${id}/${e.newIndex}`;

            await fetch(link);
            window.location.href = window.location.href;
        }
    });
</script>


@endsection