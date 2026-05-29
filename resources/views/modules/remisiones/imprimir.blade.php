<!DOCTYPE html>
<html>
<head>

<title>Remisión</title>

<style>

body{
font-family: Arial;
font-size:14px;
}

table{
width:100%;
border-collapse:collapse;
}

td,th{
border:1px solid #000;
padding:6px;
}

.sin-borde{
border:none;
}

.total{
font-size:22px;
font-weight:bold;
text-align:right;
}

@media print{

.no-print{
display:none;
}

}

</style>

</head>

<body>

<div class="no-print" style="text-align:right;margin-bottom:20px">

<button onclick="window.print()" style="padding:10px 20px">
🖨 Imprimir
</button>

</div>

<h2 style="text-align:center">
{{ strtoupper($remision->empresa->nombre) }}
</h2>

<p style="text-align:center">
NIT: {{ $remision->empresa->nit }}
</p>

<table class="sin-borde">

<tr class="sin-borde">

<td class="sin-borde">

<b>Fecha:</b> {{ $remision->fecha }} <br>
<b>Periodo:</b> {{ date('m/Y', strtotime($remision->fecha)) }} <br>
<b>Nombre:</b> {{ $remision->afiliado->primer_nombre }} {{ $remision->afiliado->primer_apellido }} <br>
<b>Dirección:</b> {{ $remision->afiliado->direccion }}

</td>

<td class="sin-borde" style="text-align:right">

<b>Remisión N°:</b> {{ $remision->numero }} <br>
<b>CC:</b> {{ $remision->afiliado->numero_documento }} <br>
<b>Teléfono:</b> {{ $remision->afiliado->telefono }}

</td>

</tr>

</table>

<br>

<table>

<thead>

<tr>

<th>Concepto</th>
<th>Valor</th>

</tr>

</thead>

<tbody>

@foreach($remision->detalles as $d)

<tr>

<td>{{ $d->concepto }}</td>

<td style="text-align:right">
${{ number_format($d->valor) }}
</td>

</tr>

@endforeach

<tr>

<td><b>TOTAL</b></td>

<td class="total">

${{ number_format($remision->total) }}

</td>

</tr>

</tbody>

</table>

<br>

<div style="border:1px dashed #999;padding:10px">

CRA 9 # 9 - 49  
Tel: 8818282  

No cuenta: 017070235944  
Banco DAVIVIENDA CTA AHORROS  

Enviar consignación por WHATSAPP  

3152041979  
3183375879  

</div>

</body>
</html>