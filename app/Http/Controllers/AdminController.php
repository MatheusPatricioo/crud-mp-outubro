<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\Page;
use App\Models\Link;



class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin/login');
        }

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:7'
        ];

        $messages = [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 7 caracteres.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin');
        }

        return redirect()->back()->with('error', 'E-mail e/ou senha não conferem.');
    }

    public function loginAction(Request $request)
    {
        $creds = $request->only('email', 'password');

        if (Auth::attempt($creds)) {
            return redirect('/admin');
        } else {
            return redirect('/admin/login')->with('error', 'E-mail e/ou senha não conferem.');
        }
    }

    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('admin/register');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:7|confirmed'
        ];

        $messages = [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 7 caracteres.',
            'password.confirmed' => 'As senhas não conferem.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return redirect('/admin');
    }

    public function registerAction(Request $request)
    {
        $creds = $request->only('email', 'password', 'name');

        // Verifica se o email já existe
        $hasEmail = User::where('email', $creds['email'])->count();

        if ($hasEmail === 0) {
            // Criação do novo usuário
            $newUser = new User();
            $newUser->name = $creds['name'];
            $newUser->email = $creds['email'];
            $newUser->password = Hash::make($creds['password']);
            $newUser->save();

            // Criar uma nova página associada ao usuário
            $page = new Page();
            $page->id_user = $newUser->id; // ID do novo usuário
            $page->slug = 'pagina-inicial-' . $newUser->id; // Slug para a nova página
            $page->op_title = 'Minha Página Inicial'; // Título padrão
            $page->op_font_color = '#000000'; // Cor da fonte padrão
            $page->op_bg_type = 'solid'; // Tipo de fundo padrão
            $page->op_bg_value = '#FFFFFF'; // Cor de fundo padrão
            $page->op_profile_image = 'default_profile_image.jpg'; // Imagem de perfil padrão
            $page->op_description = 'Descrição padrão da página.'; // Descrição padrão
            $page->save(); // Salvar a nova página

            Auth::login($newUser); // Logar o novo usuário

            return redirect('/admin')->with('success', 'Usuário cadastrado com sucesso!');
        } else {
            return redirect('/admin/register')->with('error', 'Já existe um usuário com este e-mail.');
        }
    }

    public function index()
    {
        $user = Auth::user();

        $pages = Page::where('id_user', $user->id)->get();

        // $title = 'Dashboard Admin';
        // $bg = '#f4f4f4'; // Exemplo de cor de fundo
        // $font_color = '#333'; // Exemplo de cor da fonte
        // $profile_image = 'path/to/profile-image.jpg'; // Substitua pelo caminho da imagem de perfil
        // $description = 'Bem-vindo ao painel de pipipi popopo';
        // $links = [
        //     (object) ['url' => 'https://example.com', 'title' => 'Exemplo 1'],
        //     (object) ['url' => 'https://another-example.com', 'title' => 'Exemplo 2']
        // ];

        // return view('admin.index',
        //  compact('title', 'bg', 'font_color', 'profile_image', 'description', 'links'));
        return view('admin.index', [
            'pages' => $pages
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }

    public function pageLinks($slug)
    {
        $user = Auth::user();
        $page = Page::where('slug', $slug)
            ->where('id_user', $user->id)
            ->first();

        if ($page) {
            // Obtendo os links associados à página
            $links = DB::table('links')->where('id_page', $page->id)->get();

            return view('admin/page_links', [
                'menu' => 'links',
                'page' => $page,
                'links' => $links, // Adicionando a variável $links à view
            ]);
        } else {
            return redirect('/admin');
        }
    }

    public function linkOrderUpdate($linkid, $pos)
    {
        $user = Auth::user();
        $link = Link::find($linkid);

        $myPages = Page::where('id_user', $user->id)->pluck('id')->toArray();

        if (in_array($link->id_page, $myPages)) {
            if ($link->order > $pos) {
                // Subiu o item - jogando os próximos para baixo
                $afterLinks = Link::where('id_page', $link->id_page)
                    ->where('order', '>=', $pos)
                    ->get();
                foreach ($afterLinks as $afterLink) {
                    $afterLink->order++;
                    $afterLink->save();
                }
            } elseif ($link->order < $pos) {
                // Desceu o item - jogando os anteriores para cima
                $beforeLinks = Link::where('id_page', $link->id_page)
                    ->where('order', '<=', $pos)
                    ->get();
                foreach ($beforeLinks as $beforeLink) {
                    $beforeLink->order--; // Corrigido para beforeLink
                    $beforeLink->save();
                }
            }

            // Posicionando o item
            $link->order = $pos;
            $link->save();

            // Corrigindo as posições
            $allLinks = Link::where('id_page', $link->id_page)
                ->orderBy('order', 'ASC')
                ->get();
            foreach ($allLinks as $linkKey => $linkItem) {
                $linkItem->order = $linkKey;
                $linkItem->save();
            }
        }

        return [];
    }

    public function newLink($slug)
    {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();

        if ($page) {
            return view('admin/page_editlink', [
                'menu' => 'links',
                'page' => $page
            ]);
        } else {
            return redirect('/admin');
        }
    }

    public function newLinkAction($slug, Request $request)
    {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();

        if ($page) {
            $fields = $request->validate([
                'status' => ['required', 'boolean'],
                'title' => ['required', 'min:2'],
                'href' => ['required', 'url'],
                'op_bg_color' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                'op_text_color' => ['required', 'regex:/^[#][0-9A-F]{3,6}$/i'],
                'op_border_type' => ['required', Rule::in(['square', 'rounded'])],
                'label' => ['nullable', 'string']
            ]);

            $newLink = new Link();
            $newLink->id_page = $page->id;
            $newLink->status = $fields['status'];
            $newLink->border = 1;
            $newLink->title = $fields['title'];
            $newLink->href = $fields['href'];
            $newLink->op_bg_color = $fields['op_bg_color'];
            $newLink->op_text_color = $fields['op_text_color'];
            $newLink->op_border_type = $fields['op_border_type'];
            $newLink->id_user = $user->id;
            $newLink->url = $fields['href'];
            $newLink->label = $fields['label'] ?? 'Default Label';

            // Define o campo `order` com base no próximo valor disponível
            $newLink->order = Link::where('id_page', $page->id)->max('order') + 1;

            $newLink->save();

            return redirect('/admin/' . $page->slug . '/links');
        } else {
            return redirect('/admin');
        }
    }

    public function editLink($slug, $linkid)
    {
        $user = Auth::user();
        $page = Page::where('id_user', $user->id)
            ->where('slug', $slug)
            ->first();
    
        // Verifica se a página existe
        if (!$page) {
            return redirect('/admin');
        }
    
        // Agora busca o link associado à página
        $link = Link::where('id_page', $page->id)
            ->where('id', $linkid)
            ->first();
    
        // Verifica se o link existe
        if ($link) {
            return view('admin/page_editlink', [
                'menu' => 'links', // Corrigido para 'links'
                'page' => $page,
                'link' => $link
            ]);
        }
    
        // Se o link não for encontrado, redireciona para a área inicial
        return redirect('/admin');
    }
    

    public function pageDesign($slug)
    {
        return view('admin/page_design', [
            'menu' => 'design'
        ]);
    }

    public function pageStats($slug)
    {
        return view('admin/page_stats', [
            'menu' => 'stats'
        ]);
    }

}
