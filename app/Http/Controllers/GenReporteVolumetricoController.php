<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformacionGeneralReporte;

class GenReporteVolumetricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generarReporte($idPlanta)
    {
        date_default_timezone_set('America/Mexico_City');

        // Obtención de las reglas del SAT
        $json_reglas_sat = file_get_contents(public_path('docs\Mensual.schema.json'));

        $reglas = json_decode($json_reglas_sat, true);

        
        try {
            $dataReporteGeneral = InformacionGeneralReporte::where('id_planta', $idPlanta)->get();

            // Obtención de informaicón
            $reporteVolumetrico = [
                "Version" => 1.0,
                "RfcContribuyente" => $dataReporteGeneral[0]['rfc_contribuyente'],
                "RfcProveedor" => $dataReporteGeneral[0]['rfc_representante_legal'],
                "Caracter" => $dataReporteGeneral[0]['tipo_caracter'],
                "ClaveInstalacion" => $dataReporteGeneral[0]['clave_instalacion'],
                "DescripcionInstalacion" => $dataReporteGeneral[0]['descripcion_instalacion'],
                "NumeroPozos" => $dataReporteGeneral[0]['numero_pozos'],
                "NumeroTanques" => $dataReporteGeneral[0]['numero_tanques'],
                "NumeroDuctosEntradaSalida" => $dataReporteGeneral[0]['numero_ductos_entrada_salida'],
                "NumeroDuctosTransporteDistribucion" => $dataReporteGeneral[0]['numero_ductos_transporte'],
                "NumeroDispensarios" => $dataReporteGeneral[0]['numero_dispensarios'],
                "FechaYHoraReporteMes" => date("Y-m-d H:i:s"),
                "Producto" => [
                    "ClaveProducto" => "PR12",
                    "GasLP" => [
                        "ComposDePropanoEnGasLP" => 60.00,
                        "ComposDeButanoEnGasLP" => 40.00
                    ],
                    "MarcaComercial" => "Gas Butano Zacatecas S.A de C.V",
                    "TANQUE" => [],
                    "DISPENSARIO" => []
                ],
                "BitacoraMensual" => [
                    "NumeroRegistro" => 1,
                    "FechaYHoraEvento" => date("Y-m-d H:i:s"),
                    "UsuarioResponsable" => "Juan Manual Zepeda Martinez",
                    "TipoEvento" => 1,
                    "DescripcionEvento" => "Declaración mensual de control volumétrico"
                ]
            ];

            return response()->json($reporteVolumetrico);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
