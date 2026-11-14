<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Consultas - Sistema Pré-Natal </title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            margin: 1cm 0.5cm;
            color: #000;
        }
        .texto-marca-dagua {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 7em;
            color: #888;
            opacity: 0.3;
            pointer-events: none;
            white-space: nowrap;
        }
        .texto-restrito-cima,
        .texto-restrito-baixo {
            border: 1px solid #999;
            color: #999;
            font-weight: bolder;
            text-align: center;
            padding: 1px 8px;
            position: fixed;
            left: 130px;
        }
        .texto-restrito-cima { top: 0px; font-size: 18px; }
        .texto-restrito-baixo { bottom: 0px; font-size: 20px; }
        .header { text-align: center; margin-bottom: 0.5rem; font-weight: bold; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
        }
        th { text-transform: uppercase; background-color: #eee; }
    </style>
</head>
<body>

    <div class="texto-marca-dagua"> GESTAPGUA - PR </div>
    <div class="texto-restrito-cima"> DOCUMENTO GERADO PELO SISTEMA PRÉ-NATAL </div>

    <hr>

    <table style="width: 100%;">
        <tr>
            <td style="width: 75px;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/img/logo.png'))) }}" width="90" height="90">
            </td>
            <td style="text-align: center;">
                <div style="font-size: 18px;">GOVERNO FEDERAL DO BRASIL</div>
                <div style="font-size: 18px;">MINISTÉRIO DA SAÚDE</div>
                <div style="font-size: 18px; font-weight: bold;">GESTAPGUA</div>
                <div style="font-size: 18px; font-weight: bold;">PARANÁ</div>
            </td>
            <td style="width: 75px;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/img/logo.png'))) }}" width="90" height="90">
            </td>
        </tr>
    </table>

    <hr>

    <h3 style="text-align:center; margin-top:10px;">Relatório de Consultas</h3>

    <table>
        <thead>
            <tr>
                <th>Consulta</th>
                <th>Nome da Gestante</th>
                <th>Local</th>
                <th>Data</th>
                <th>Horário</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach($consultas as $consulta)
                <tr>
                    <td>{{ $consulta->tipo_consulta }}</td>
                    <td>{{ $consulta->gestante->nome }}</td>
                    <td>{{ $consulta->local ?? 'Não informado' }}</td>
                    <td>{{ \Carbon\Carbon::parse($consulta->data)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($consulta->horario)->format('H:i') }}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="texto-restrito-baixo"> DOCUMENTO GERADO PELO SISTEMA PRÉ-NATAL </div>

</body>
</html>
