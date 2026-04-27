<?php

namespace App\Http\Controllers;

use App\Http\Requests\Oficio\OficioPostRequest;
use App\Models\Oficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;

class OficioController extends Controller
{
    public function index(Request $request)
    {
        $oficios = Oficio::all()->sortByDesc(['ano', 'numero']);
        $data = [];
        foreach ($oficios as $key => $oficio) {
            $value = $oficio->toArray();
            $value['numeroCompleto'] = $oficio->numeroCompleto;
            $value['dataExtenso'] = \Carbon\Carbon::parse($oficio->data)->format('d/m/Y');
            $value['autor'] = $oficio->autor();
            $data[] = $value;
        }
        $id = $request->input('id', null);
        $clonar = $request->input('clonar', null);
        $openPDF = $request->session()->get('openID', null);
        $request->session()->forget('openID');
        return Inertia::render('oficios/index', [
            'oficios' => $data,
            'openID' => Inertia::always($openPDF),
            'oficio' => Inertia::optional(function() use ($id, $clonar) {
                $oficio = Oficio::find($id);
                if ($clonar) {
                    $oficio->id = null;
                    $oficio->data = now();
                }
                return [...$oficio->toArray(), 'numeroCompleto' => $oficio->numeroCompleto];
            }),
        ]);
    }

    public function edit($id)
    {
        $oficio = Oficio::find($id);
        return Inertia::render('oficios/form', [
            'oficio' => $oficio,
        ]);
    }

    public function create()
    {
        $oficio = new Oficio([
            'data' => date('Y-m-d'),
            'assunto' => '',
            'tratamento' => '',
            'destinatario' => '',
            'cargo' => '',
            'municipio' => '',
            'conteudo' => '',
        ]);
        return Inertia::render('oficios/form', [
            'oficio' => $oficio,
        ]);
    }

    public function store(OficioPostRequest $request, $id=null)
    {
        $validated = $request->validated();
        $oficio = null;

        $user = Auth::user();
        $validated['updated_by'] = $user->cpf;
        $validated['data'] = date('Y/m/d', strtotime($validated['data']));

        if ($id ?? null) {
            Oficio::find($id)->update($validated);
            $oficio = Oficio::find($id);
        } else {
            $oficio = new Oficio($validated);
            $oficio->ano = date('Y', strtotime($validated['data']));
            $oficio->numero = Oficio::generateNumber($oficio->ano);
            $oficio->created_by = $user->cpf;
            $oficio->save();
        }

        $openPDF = $request->input('openPDF', null);
        if ($openPDF=='1') $request->session()->put('openID', $oficio->id);

        return response()->redirectToRoute('oficio');
    }

    public function view(Request $request, $id)
    {
        $oficio = Oficio::find($id);
        $url = $this->renderPDF($oficio);

        return response()->file(public_path(Storage::url($url)));
    }

    public function previewId(Request $request, $id)
    {
        $oficio = Oficio::find($id);
        $url = $this->renderPDF($oficio);
        return response()->json([
            'url' => $url
        ]);
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable',
            'data'   => ['required'],
            'assunto'   => 'nullable',
            'conteudo'   => ['required'],
            'tratamento' => 'nullable',
            'destinatario' => ['required'],
            'cargo' => 'nullable',
            'municipio' => ['required'],
        ]);

        if ($validated['id'] ?? null) {
            $oficio = Oficio::find($validated['id'])->fill($validated);
        } else {
            $oficio = new Oficio($validated);
        }
        $url = $this->renderPDF($oficio, 'temp/' . strtotime(now()) . '.pdf');

        return response()->json([
            'url' => Storage::url($url)
        ]);
    }

    public function renderPDF(Oficio $oficio, $pdf = null)
    {
        $pdf = $pdf ?? "oficios/of_{$oficio->numero}_scm_{$oficio->ano}.pdf";
        $top = 42;
        $right = 20;
        $bottom = 20;
        $left = 20;

        Pdf::view('oficio.renderPDF', ['oficio' => $oficio])
            ->headerView('oficio.header')
            ->footerView('oficio.footer', ['oficio' => $oficio])
            ->format(Format::A4)
            ->margins($top, $right, $bottom, $left)
            ->disk('public')->save($pdf);

        return $pdf;
    }

    public function deletePreview(Request $request)
    {
        $pdf = Str::replaceFirst('/storage', '', $request->input('pdfFile'));
        $res = Storage::disk('public')->delete($pdf);
        return response()->json([
            'res' => $res,
        ]);
    }
}
