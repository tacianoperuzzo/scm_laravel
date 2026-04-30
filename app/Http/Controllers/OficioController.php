<?php

namespace App\Http\Controllers;

use App\Http\Requests\Oficio\OficioPostRequest;
use App\Repositories\OficioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class OficioController extends Controller
{
    protected OficioRepository $repository;
    public function __construct(OficioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $oficios = $this->repository->getAll();
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
                $oficio = $clonar ? $this->repository->getClone($id) : $this->repository->getOne($id);
                return [...$oficio->toArray(), 'numeroCompleto' => $oficio->numeroCompleto];
            }),
        ]);
    }

    public function store(OficioPostRequest $request)
    {
        $oficio = $this->repository->create($request->validated());

        $openPDF = $request->input('openPDF', null);
        if ($openPDF=='1') $request->session()->put('openID', $oficio->id);

        return response()->redirectToRoute('oficios.index');
    }

    public function update(OficioPostRequest $request, int $id)
    {
        $oficio = $this->repository->update($id, $request->validated());

        $openPDF = $request->input('openPDF', null);
        if ($openPDF=='1') $request->session()->put('openID', $id);

        return response()->redirectToRoute('oficios.index');
    }

    public function show($id)
    {
        $oficio = $this->repository->getOne($id);
        $url = $this->repository->renderPDF($oficio);

        return response()->file(public_path(Storage::url($url)));
    }

    public function preview(OficioPostRequest $request, ?int $id=null)
    {
        $oficio = $this->repository->newPreview($id, $request->validated());
        $url = $this->repository->renderPDF($oficio);

        return response()->json([
            'url' => Storage::url($url)
        ]);
    }

    public function deletePreview(Request $request)
    {
        $res = $this->repository->deletePreview($request->input('pdfFile'));
        return response()->json([
            'res' => $res,
        ]);
    }
}
