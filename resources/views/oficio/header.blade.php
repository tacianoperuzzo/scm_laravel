@php $logo = public_path('assets/brasao_sc.png'); @endphp

<style>
    header {
        font-size: 12px;
        margin-left: 20mm;
        margin-right: 20mm;
        margin-top: 8mm;
        width: 100%;
    }
    .logo {
        float: left;
        width: 80px;
    }
    .logo img {
        width: 60px;
    }
    p {
        margin: 6px 0;
        padding: 0;
    }
</style>

<header>
    <div class="logo">
        @inlinedImage($logo)
    </div>
    <div style="width: 100%">
        <p>ESTADO DE SANTA CATARINA</p>
        <P>GABINETE DO GOVERNADOR</P>
        <P>SECRETARIA EXECUTIVA DA CASA MILITAR</P>
    </div>
</header>
