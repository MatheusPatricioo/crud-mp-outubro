<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa Auth para pegar o usuário autenticado
use App\Models\Page;
use App\Models\Link;
use App\Models\View;

class PageController extends Controller
{
    // Método de exibição de página existente
    public function index($slug)
    {
        $page = Page::where('slug', $slug)->first();

        if ($page) {
            // Background
            $bg = '#ffffff';
            switch ($page->op_bg_type) {
                case 'image':
                    $bg = "url('" . url('/media/uploads') . '/' . $page->op_bg_value . "')";
                    break;

                case 'color':
                    $colors = explode(',', $page->op_bg_value);
                    $bg = 'linear-gradient(90deg, ';
                    $bg .= $colors[0] . ',';
                    $bg .= !empty($colors[1]) ? $colors[1] : $colors[0];
                    $bg .= ')';
                    break;
            }

            // Links
            $links = Link::where('id_page', $page->id)
                ->where('status', 1)
                ->orderBy('order')
                ->get();

            // Registrar a visualização
            $view = View::firstOrNew(
                ['id_page' => $page->id, 'view_date' => date('Y-m-d')]
            );
            $view->total = ($view->exists ? $view->total : 0) + 1;
            $view->save();

            return view('page', [
                'font_color' => $page->op_font_color,
                'profile_image' => $page->op_profile_image ? url('/media/uploads') . '/' . $page->op_profile_image : null,
                'title' => $page->op_title,
                'description' => $page->op_description ?? 'Sem descrição disponível',
                'fb_pixel' => $page->op_fb_pixel ?? null,
                'bg' => $bg,
                'links' => $links,
            ]);
        } else {
            return view('notfound');
        }
    }

    // Método para criar uma nova página associada ao usuário logado
    public function createPage(Request $request)
    {
        $user = Auth::user(); // Obtém o usuário autenticado

        $page = new Page();
        $page->id_user = $user->id; // Define o id_user como o ID do usuário logado
        $page->op_title = $request->input('op_title');
        $page->slug = $request->input('slug');
        $page->op_bg_type = $request->input('op_bg_type', 'color'); // Exemplo de preenchimento com valor padrão
        $page->op_bg_value = $request->input('op_bg_value', '#ffffff');
        $page->op_font_color = $request->input('op_font_color', '#000000');
        $page->op_description = $request->input('op_description', 'Descrição padrão');

        $page->save(); // Salva a nova página no banco

        return redirect('/admin')->with('success', 'Página criada com sucesso!');
    }
}
