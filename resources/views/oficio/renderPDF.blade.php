@use('Carbon\Carbon')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ofício {{ $oficio->numeroCompleto }}</title>
    <style>
        body {
            font-family: "Helvetica","Arial",sans-serif;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .content {
            text-indent: 0mm;
        }
    </style>
</head>
<body>
    <table style="width: 100%; margin-bottom: 50px;">
        <tr>
            <td style="text-align: left; font-weight: bold">
                Ofício {{ $oficio->numero ? 'nº ' . str_pad($oficio->numero, 3, '0', STR_PAD_LEFT) . '/SCM/' . $oficio->ano : 's/nº SCM/' . date('Y')}}
            </td>
            <td style="text-align: right;">
                {{ Carbon::parse($oficio->data)->isoFormat('[Florianópolis (SC)], D [de] MMMM [de] YYYY.') }}
            </td>
        </tr>
    </table>
    <div class="content">
        {!! $oficio->conteudo !!}
    </div>
</body>
</html>
