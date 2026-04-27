<style>
    footer {
        font-size: 12px;
        margin-left: 20mm;
        margin-right: 20mm;
        margin-bottom: 10mm;
        width: 100%;
    }
    .destinatario {
        font-size: 14px;
        width: 100%;
        text-align: left;
        margin-bottom: 20px;
    }
    .destinatario p {
        margin: 2px 0;
        padding: 0;
    }
    .endereco {
        border-top: 1px solid #ccc;
        padding-top: 5px;
    }
    .endereco, .email {
        font-size: 10px;
        width: 100%;
        text-align: center;
        margin: 2px 0;
    }
</style>
<footer>
    <div class="destinatario">
        <p>{{$oficio->tratamento}}</p>
        <p>{{$oficio->destinatario}}</p>
        <p>{{$oficio->cargo}}</p>
        <p>{{$oficio->municipio}}</p>
    </div>
    <div class="endereco">
        Rodovia SC 401 - km 5, nº4600 - Saco Grande - Florianópolis/SC - CEP 88032-900
    </div>
    <div class="email">
        E-mail: scm@casamilitar.sc.gov.br - Fone: (048) 3665-2042
    </div>
</footer>
