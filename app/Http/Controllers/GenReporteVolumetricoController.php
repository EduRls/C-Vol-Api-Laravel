<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformacionGeneralReporte;

use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;

class GenReporteVolumetricoController extends Controller
{

    public function consultarCFDI(){
        // Creación de la FIEL, puede leer archivos DER (como los envía el SAT) o PEM (convertidos con openssl)
        $fiel = Fiel::create(
            file_get_contents('C:/Users/su_13/OneDrive/Documentos/Documentos/FIEL_RUCE021213JS2_20220818124034/ruce021213js2.cer'),
            file_get_contents('C:/Users/su_13/OneDrive/Documentos/Documentos/FIEL_RUCE021213JS2_20220818124034/Claveprivada_FIEL_RUCE021213JS2_20220818_124034.key'),
            '12345678a'
        );

        // verificar que la FIEL sea válida (no sea CSD y sea vigente acorde a la fecha del sistema)
        if (! $fiel->isValid()) {
            return;
        }

        // creación del web client basado en Guzzle que implementa WebClientInterface
        // para usarlo necesitas instalar guzzlehttp/guzzle, pues no es una dependencia directa
        $webClient = new GuzzleWebClient();

        // creación del objeto encargado de crear las solicitudes firmadas usando una FIEL
        $requestBuilder = new FielRequestBuilder($fiel);

        // Creación del servicio
        $service = new Service($requestBuilder, $webClient);

        // Crear la consulta
        $request = QueryParameters::create(
            DateTimePeriod::createFromValues('2019-01-13 00:00:00', '2019-01-13 23:59:59'),
        );

        // presentar la consulta
        $query = $service->query($request);

        // verificar que el proceso de consulta fue correcto
        if (! $query->getStatus()->isAccepted()) {
            echo "Fallo al presentar la consulta: {$query->getStatus()->getMessage()}";
            return;
        }

        // el identificador de la consulta está en $query->getRequestId()
        echo "Se generó la solicitud {$query->getRequestId()}", PHP_EOL;
    }
    /**
     * Display a listing of the resource.
     */
    public function generarReporte($idPlanta, $monthAndYear)
    {
        // Obtención de las reglas del SAT
        date_default_timezone_set('America/Mexico_City');
        $json_reglas_sat = file_get_contents(public_path('docs\Mensual.schema.json'));
        $reglas = json_decode($json_reglas_sat, true);

        // Obtención del parametro hora y fecha
        $parts = explode('-', $monthAndYear);
        $year = $parts[0];
        $month = $parts[1];

        

        
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
                    "TANQUE" => []
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
