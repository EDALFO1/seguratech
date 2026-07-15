<?php

namespace App\Helpers;

class PagoSimpleCodigos
{
    // Códigos de departamento según CAJA (PAGO SIMPLE)
    public static function obtenerCodigoDepartamentoPorCaja($nombreCaja)
    {
        $caja = strtoupper(trim($nombreCaja ?? ''));

        // COMFIAR: departamento 81
        if (str_contains($caja, 'COMFIAR')) {
            return '81';
        }

        // Todas las demás cajas: departamento 76 (Valle)
        return '76';
    }

    // Códigos de municipios/departamentos DIAN
    public static function obtenerCodigoDepartamento($nombre)
    {
        $mapeo = [
            'CALI' => '76',
            '1' => '76',
            'CL1' => '76',
            'VALLE' => '76',
            'VALLE DEL CAUCA' => '76',
            'BOGOTÁ' => '11',
            'BOGOTÁ D.C.' => '11',
            'ANTIOQUIA' => '05',
            'CUNDINAMARCA' => '25',
            'BOLÍVAR' => '13',
            'CÓRDOBA' => '23',
            'SANTANDER' => '68',
            'NORTE DE SANTANDER' => '54',
            'CAUCA' => '19',
            'MAGDALENA' => '47',
            'HUILA' => '41',
            'TOLIMA' => '73',
            'NARIÑO' => '52',
            'RISARALDA' => '66',
            'QUINDÍO' => '63',
            'CALDAS' => '17',
            'CASANARE' => '85',
            'META' => '50',
            'ARAUCA' => '81',
            'CAQUETÁ' => '18',
            'PUTUMAYO' => '62',
            'GUAVIARE' => '95',
            'VICHADA' => '99',
            'GUAINÍA' => '94',
            'AMAZONA' => '91',
        ];

        $nombre = strtoupper(trim($nombre ?? 'CALI'));
        return $mapeo[$nombre] ?? '76'; // Defecto: Valle
    }

    // Códigos de municipios DIAN (formato 5 dígitos: DDMMM)
    public static function obtenerCodigoMunicipio($municipio, $departamento = null)
    {
        $mapeo = [
            'CALI' => '76001',
            '1' => '76001',
            'CL1' => '76001',
            'PALMIRA' => '76520',
            'YUMBO' => '76834',
            'JAMUNDÍ' => '76318',
            'CARTAGO' => '76130',
            'BUGA' => '76109',
            'BUENAVENTURA' => '76109',
            'BOGOTÁ' => '11001',
            'BOGOTÁ D.C.' => '11001',
            'MEDELLÍN' => '05001',
            'BARRANQUILLA' => '08001',
            'CARTAGENA' => '13001',
            'SANTA MARTA' => '47001',
            'CÚCUTA' => '54001',
            'BUCARAMANGA' => '68001',
            'MANIZALES' => '17001',
            'PEREIRA' => '66001',
            'ARMENIA' => '63001',
            'IBAGUÉ' => '73001',
            'NEIVA' => '41001',
            'VILLAVICENCIO' => '50001',
            'POPAYÁN' => '19001',
            'PASTO' => '52001',
            'VALLEDUPAR' => '20001',
            'MONTERÍA' => '23001',
            'SINCELEJO' => '70001',
            'TUNJA' => '15001',
            'YOPAL' => '85001',
            'ARAUCA' => '81001',
            'QUIBDÓ' => '27001',
            'LETICIA' => '91001',
            'PUERTO INÍRIDA' => '94001',
            'INÍRIDA' => '94001',
        ];

        $municipio = strtoupper(trim($municipio ?? 'CALI'));
        $codigo = $mapeo[$municipio] ?? '76001';

        // Validar formato: debe ser DDMMM (5 dígitos)
        if (strlen($codigo) < 5) {
            $codigo = str_pad($codigo, 5, '0', STR_PAD_RIGHT);
        }

        return $codigo;
    }

    // Códigos de EPS (según PAGO SIMPLE habilitadas)
    public static function obtenerCodigoEps($nombre)
    {
        $mapeo = [
            'EPS SURA (ANTES SUSALUD)' => 'EPS010',
            'EPS SURA' => 'EPS010',
            'SURA' => 'EPS010',
            'COMFENALCO VALLE' => 'EPS010',
            'COMFENALCO' => 'EPS010',
            'COOSALUD EPS' => 'EPS010',
            'COOSALUD' => 'EPS010',
            'A.I.C.' => 'EPS010',
            'AIC' => 'EPS010',
            'ASMET SALUD EPS SAS' => 'EPS010',
            'ASMET SALUD' => 'EPS010',
            'ASMET' => 'EPS010',
            'COMPENSAR' => 'EPS007',
            'EMSSANAR' => 'EPS010',
            'EMSSANAR EPS' => 'EPS010',
            'FAMISANAR' => 'EPS010',
            'MALLAMAS' => 'EPS010',
            'NUEVA E.P.S.' => 'EPS010',
            'NUEVA EPS' => 'EPS010',
            'S.O.S. SERVICIO OCCIDENTAL DE SALUD S.A.' => 'EPS010',
            'SOS' => 'EPS010',
            'SALUD TOTAL' => 'EPS010',
            'SANITAS' => 'EPS002',
            'NINGUNA' => '',
        ];

        $nombre = strtoupper(trim($nombre ?? 'NINGUNA'));
        return $mapeo[$nombre] ?? 'EPS010';
    }

    // Códigos de ARL (según nivel)
    public static function obtenerCodigoArl($nombre)
    {
        $mapeo = [
            'SURA' => 'ARL001',
            'COLMENA' => 'ARL002',
            'SEGUROS BOLÍVAR' => 'ARL003',
            'ZURICH' => 'ARL004',
            'ROYAL & SUN ALLIANCE' => 'ARL005',
            'MAPFRE' => 'ARL006',
            'LIBERTY' => 'ARL007',
            'SEGUROS MONTERREY' => 'ARL008',
            'ALIANZA' => 'ARL009',
            'SEGUROS LAFISE' => 'ARL010',
            'NINGUNA' => '',
        ];

        $nombre = strtoupper(trim($nombre ?? 'NINGUNA'));
        return $mapeo[$nombre] ?? '';
    }

    // Códigos de CCF/Caja (según PAGO SIMPLE habilitadas)
    public static function obtenerCodigoCaja($nombre)
    {
        $mapeo = [
            'COMFIAR' => 'CCF68',
            'COMFANDI' => 'CCF57',
            'COMFANDI VALLE' => 'CCF57',
            'CAFAM' => 'CCF57',
            'COMPENSAR' => 'CCF57',
            'COLSUBSIDIO' => 'CCF57',
            'ANDI' => 'CCF57',
            'ASOFONDOS' => 'CCF57',
            'CAJA SOCIAL' => 'CCF57',
            'CONSTRUCCIÓN' => 'CCF57',
            'NINGUNA' => '',
        ];

        $nombre = strtoupper(trim($nombre ?? 'NINGUNA'));
        return $mapeo[$nombre] ?? 'CCF57';
    }
}
