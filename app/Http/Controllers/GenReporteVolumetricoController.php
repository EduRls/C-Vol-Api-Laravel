<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformacionGeneralReporte;
use App\Models\RegistroEntradasSalidasPipa;
use App\Models\Pipa;
use App\Models\BitacoraEventos;

use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;
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

        if (! $fiel->isValid()) {
            return;
        }

        $webClient = new GuzzleWebClient();

        $requestBuilder = new FielRequestBuilder($fiel);

        // Creación del servicio
        $service = new Service($requestBuilder, $webClient);

        $service = new Service($requestBuilder, $webClient, null, ServiceEndpoints::cfdi());

        return $service;
    }
    
    public function generarReporteMensual($idPlanta, $year, $month){
        try {
            // INFORMAICÓN GENERAL PARA EL REPORTE VOLUMÉTRICO
            $dataReporteGeneral = InformacionGeneralReporte::where('id_planta', $idPlanta)->get();

            // INFORMACIÓN GENERAL DE LAS PIPAS
            $dataPipasGeneral = Pipa::where('id_planta', $idPlanta)->get();

            $dataEntradasYSalidasPipas = RegistroEntradasSalidasPipa::with('pipa')
                ->selectRaw('id_pipa, SUM(inventario_inical) as inventario_inicial, SUM(compra) as total_compra, SUM(venta) as total_venta, SUM(inventario_final) as inventario_final, COUNT(*) as cantidad_registros')
                ->where('id_planta', $idPlanta)
                ->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->groupBy('id_pipa')
                ->get();

            $dataBitacoraEventos = BitacoraEventos::where('id_planta', $idPlanta)
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();

            $dataAlmacenimiento;


            if(count($dataReporteGeneral) != 0){

                $reporteVolumetrico = [
                    "Version" => 1.0,
                    "RfcContribuyente" => $dataReporteGeneral[0]['rfc_contribuyente'],
                    "RfcProveedor" => $dataReporteGeneral[0]['rfc_representante_legal'],
                    "Caracter" => [],
                    "ClaveInstalacion" => $dataReporteGeneral[0]['clave_instalacion'],
                    "DescripcionInstalacion" => $dataReporteGeneral[0]['descripcion_instalacion'],
                    "NumeroPozos" => $dataReporteGeneral[0]['numero_pozos'],
                    "NumeroTanques" => $dataReporteGeneral[0]['numero_tanques'],
                    "NumeroDuctosEntradaSalida" => $dataReporteGeneral[0]['numero_ductos_entrada_salida'],
                    "NumeroDuctosTransporteDistribucion" => $dataReporteGeneral[0]['numero_ductos_transporte'],
                    "NumeroDispensarios" => $dataReporteGeneral[0]['numero_dispensarios'],
                    "FechaYHoraReporteMes" => date("Y-m-d H:i:s"),
                    "PRODUCTO" => [
                        "ClaveProducto" => "PR12",
                        "GasLP" => [
                            "ComposDePropanoEnGasLP" => 60.00,
                            "ComposDeButanoEnGasLP" => 40.00
                        ],
                        "MarcaComercial" => "Gas Butano Zacatecas S.A de C.V",
                        "REPORTEDEVOLUMENMENSUAL" => [
                            "CONTROLDEEXISTENCIAS" => [
                                "VolumenExistenciasMes" => NULL,
                                "FechaYHoraEstaMedicionMes" => NULL
                            ],
                            "RECEPCIONES" => [
                                "TotalRecepcionesMes" => NULL,
                                "SumaVolumenRecepcionMes" => [
                                    "ValorNumerico" => NULL,
                                    "UM" => NULL
                                ],
                                "PoderCalorifico" => [
                                    "ValorNumerico" => NULL,
                                    "UM" => NULL
                                ],
                                "TotalDocumentosMes" => NULL,
                                "ImporteTotalRecepcionesMensual" => NULL, 
                                "Complemento" => []
                            ],
                            "ENTREGAS" => [
                                "TotalEntregasMes" => NULL,
                                "SumaVolumenEntregadoMes" => [
                                    "ValorNumerico" => NULL,
                                    "UM" => NULL
                                ],
                                "PoderCalorifico" => [
                                    "ValorNumerico" => NULL,
                                    "UM" => NULL
                                ],
                                "TotalDocumentosMes" => NULL,
                                "ImporteTotalEntregasMes" => NULL,
                                "Complemento" => []
                            ]
                        ]
                    ],
                    "BITACORAMENSUAL" => [
                        "NumeroRegistro" => null,
                        "FechaYHoraEvento" => null,
                        "UsuarioResponsable" => null,
                        "TipoEvento" => null,
                        "DescripcionEvento" => null
                    ]
                ];

                // CARACTERA
                $caracter = [];
                switch ($dataReporteGeneral[0]['tipo_caracter']) {
                    case 'permisionario':
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'ModalidadPermiso' => $dataReporteGeneral[0]['modalidad_permiso'],
                            'NumPermiso' => $dataReporteGeneral[0]['numero_permiso']
                        ];
                        break;
                    case 'asignatario':
                    case 'contratista':
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'NumContratoOAsignacion' => $dataReporteGeneral[0]['numero_contrato_asignacion']
                        ];
                        break;
                    case 'usuario':
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'InstalacionAlmacenGasNatural' => $dataReporteGeneral[0]['instalacion_almacen_gas']
                        ];
                        break;
                    default:
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'Mensaje' => 'Tipo de caracter no reconocido'
                        ];
                        break;
                }
                $reporteVolumetrico["Caracter"] = $caracter;

                // INFORMACIÓN GENERAL BITACORA

                $bitacora = [];
                foreach ($dataBitacoraEventos as $bitacoraEvento) {
                    $bitacora[] = [
                        "NumeroRegistro" => $bitacoraEvento->NumeroRegistro,
                        "FechaYHoraEvento" => $bitacoraEvento->FechaYHoraEvento,
                        "UsuarioResponsable" => $bitacoraEvento->UsuarioResponsable,
                        "TipoEvento" => $bitacoraEvento->TipoEvento,
                        "DescripcionEvento" => $bitacoraEvento->DescripcionEvento
                    ];
                }
                $reporteVolumetrico["BITACORAMENSUAL"] = $bitacora;


                return response()->json($reporteVolumetrico);
            }else{
                $respuesta = [
                    'error' => 'No se encontró registro, favor de llenar la infromaicón general'
                ];
                return response()->json($respuesta);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function generarReportesDiarios($idPlanta, $year, $month){
        try {
            // INFORMAICÓN GENERAL PARA EL REPORTE VOLUMÉTRICO
            $dataReporteGeneral = InformacionGeneralReporte::where('id_planta', $idPlanta)->get();

            // INFORMACIÓN GENERAL DE LAS PIPAS
            $dataPipasGeneral = Pipa::where('id_planta', $idPlanta)->get();

            $dataEntradasYSalidasPipas = RegistroEntradasSalidasPipa::with('pipa')
                ->selectRaw('id_pipa, SUM(inventario_inical) as inventario_inicial, SUM(compra) as total_compra, SUM(venta) as total_venta, SUM(inventario_final) as inventario_final, COUNT(*) as cantidad_registros, DATE_FORMAT(CONVERT_TZ(created_at, "+00:00", "-01:00"), "%H:%i:%s") AS HoraRecepcionAcumulado')
                ->where('id_planta', $idPlanta)
                ->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->groupBy('id_pipa', 'created_at')
                ->get();

            $dataAlmacenimiento;


            if(count($dataReporteGeneral) != 0){

                $reporteVolumetrico = [
                    "Version" => 1.0,
                    "RfcContribuyente" => $dataReporteGeneral[0]['rfc_contribuyente'],
                    "RfcProveedor" => $dataReporteGeneral[0]['rfc_representante_legal'],
                    "Caracter" => [],
                    "ClaveInstalacion" => $dataReporteGeneral[0]['clave_instalacion'],
                    "DescripcionInstalacion" => $dataReporteGeneral[0]['descripcion_instalacion'],
                    "NumeroPozos" => $dataReporteGeneral[0]['numero_pozos'],
                    "NumeroTanques" => $dataReporteGeneral[0]['numero_tanques'],
                    "NumeroDuctosEntradaSalida" => $dataReporteGeneral[0]['numero_ductos_entrada_salida'],
                    "NumeroDuctosTransporteDistribucion" => $dataReporteGeneral[0]['numero_ductos_transporte'],
                    "NumeroDispensarios" => $dataReporteGeneral[0]['numero_dispensarios'],
                    "FechaYHoraReporteMes" => date("Y-m-d H:i:s"),
                    "PRODUCTO" => [
                        "ClaveProducto" => "PR12",
                        "GasLP" => [
                            "ComposDePropanoEnGasLP" => 60.00,
                            "ComposDeButanoEnGasLP" => 40.00
                        ],
                        "MarcaComercial" => "Gas Butano Zacatecas S.A de C.V",
                        "TANQUE" => []
                    ],
                    "BITACORA" => [
                        "NumeroRegistro" => null,
                        "FechaYHoraEvento" => null,
                        "UsuarioResponsable" => null,
                        "TipoEvento" => null,
                        "DescripcionEvento" => null
                    ]
                ];
                $caracter = [];
                switch ($dataReporteGeneral[0]['tipo_caracter']) {
                    case 'permisionario':
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'ModalidadPermiso' => $dataReporteGeneral[0]['modalidad_permiso'],
                            'NumPermiso' => $dataReporteGeneral[0]['numero_permiso']
                        ];
                        break;
                    case 'asignatario':
                    case 'contratista':
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'NumContratoOAsignacion' => $dataReporteGeneral[0]['numero_contrato_asignacion']
                        ];
                        break;
                    case 'usuario':
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'InstalacionAlmacenGasNatural' => $dataReporteGeneral[0]['instalacion_almacen_gas']
                        ];
                        break;
                    default:
                        $caracter = [
                            'TipoCaracter' => $dataReporteGeneral[0]['tipo_caracter'],
                            'Mensaje' => 'Tipo de caracter no reconocido'
                        ];
                        break;
                }
                $reporteVolumetrico["Caracter"] = $caracter;
                $tanques = [];
                foreach($dataPipasGeneral as $pipaObject){

                    $taqnuesTemporales = [];

                    $taqnuesTemporales['ClaveIdentificacionTanque'] = $pipaObject['clave_pipa'];
                    $taqnuesTemporales['LocalizacionY/ODescripcionTanque'] = $pipaObject['localizacion_descripcion_pipa'];
                    $taqnuesTemporales['VigenciaCalibracionTanque'] = $pipaObject['vigencia_calibracion_tanque'];
                    $taqnuesTemporales['CapacidadTotalTanque'] = [
                        'ValorNumerico' => $pipaObject['capacidad_pipa'],
                        'UM' => 'UM03'
                    ];
                    $taqnuesTemporales['CapacidadOperativaTanque'] = [
                        'ValorNumerico' => $pipaObject['capacidad_operativa'],
                        'UM' => 'UM03'
                    ];
                    $taqnuesTemporales['CapacidadUtilTanque'] = [
                        'ValorNumerico' => $pipaObject['capacidad_util'],
                        'UM' => 'UM03'
                    ];
                    $taqnuesTemporales['CapacidadFondajeTanque'] = [
                        'ValorNumerico' => $pipaObject['capacidad_fondaje'],
                        'UM' => 'UM03'
                    ];
                    $taqnuesTemporales['VolumenMinimoOperacion'] = [
                        'ValorNumerico' =>  $pipaObject['volumen_minimo_operacion'],
                        'UM' => 'UM03'
                    ];
                    $taqnuesTemporales['EstadoTanque'] = $pipaObject['estado_tanque'];

                    foreach($dataEntradasYSalidasPipas as $objeto) {
                        $pipa = $objeto['pipa'];
    
                        if($pipa['id'] == $pipaObject['id']){
                            $taqnuesTemporales['EXISTENCIAS'] = [
                                'VolumenExistenciasAnterior' => intval($objeto['inventario_inicial']),
                                'VolumenAcumOpsRecepcion' => [
                                    'ValorNumerico' =>  intval($objeto['total_compra']),
                                    'UM' => 'UM03'
                                ],
                                'HoraRecepcionAcumulado' => $objeto['HoraRecepcionAcumulado'] . '-01:00',
                                'VolumenAcumOpsEntrega' => [
                                    'ValorNumerico' =>  intval($objeto['total_venta']),
                                    'UM' => 'UM03'
                                ],
                                'HoraEntregaAcumulado' => $objeto['HoraRecepcionAcumulado'] . '-01:00',
                                'VolumenExistencias' => intval($objeto['inventario_inicial']) + intval($objeto['total_compra']) - intval($objeto['total_venta']),
                                'FechaYHoraEstaMedicion' => $objeto['HoraRecepcionAcumulado'] . '-01:00'
                            ];
                            $taqnuesTemporales['RECEPCIONES'] = [
                                'TotalRecepciones' => NULL,
                                'SumaVolumenRecepcion' => [
                                    'ValorNumerico' =>  NULL,
                                    'UM' => 'UM03'
                                ],
                                'TotalDocumentos' => intval($objeto['cantidad_registros']),
                                'SumaCompras' => NULL,
                                'RECEPCION' => [
                                    'NumeroDeRegistro' => NULL,
                                    'TipoDeRegistro' => NULL,
                                    'VolumenInicialTanque' => [
                                        'ValorNumerico' =>  NULL,
                                        'UM' => 'UM03'
                                    ],
                                    'VolumenFinalTanque' => [
                                        'ValorNumerico' =>  NULL,
                                        'UM' => 'UM03'
                                    ],
                                    'VolumenRecepcion' => [
                                        'ValorNumerico' =>  NULL,
                                        'UM' => 'UM03'
                                    ],
                                    'Temperatura' => NULL,
                                    'PresionAbsoluta' => NULL,
                                    'FechaYHoraInicioRecepcion' => NULL,
                                    'FechaYHoraFinalRecepcion' => NULL
                                ]
                            ];
                            $taqnuesTemporales['ENTREGAS'] = [
                                'TotalEntregas' => NULL,
                                'SumaVolumenEntregado' => [
                                    'ValorNumerico' =>  NULL,
                                    'UM' => 'UM03'
                                ],
                                'TotalDocumentos' => NULL,
                                'SumaVentas' => NULL,
                                'ENTREGA' => [
                                    'NumeroDeRegistro' => NULL,
                                    'TipoDeRegistro' => NULL,
                                    'VolumenInicialTanque' => [
                                        'ValorNumerico' =>  NULL,
                                        'UM' => 'UM03'
                                    ],
                                    'VolumenFinalTanque' => [
                                        'ValorNumerico' =>  NULL,
                                        'UM' => 'UM03'
                                    ],
                                    'VolumenEntregado' => [
                                        'ValorNumerico' =>  NULL,
                                        'UM' => 'UM03'
                                    ],
                                    'Temperatura' => NULL,
                                    'PresionAbsoluta' => NULL,
                                    'FechaYHoraInicioEntrega' => NULL,
                                    'FechaYHoraFinalEntrega' => NULL
                                ]
                            ];
                        }
                    }

                    $tanques[] = $taqnuesTemporales;

                }
                $reporteVolumetrico['PRODUCTO']['TANQUE'] = $tanques;

                return response()->json($reporteVolumetrico);
            }else{
                $respuesta = [
                    'error' => 'No se encontró registro, favor de llenar la infromaicón general'
                ];
                return response()->json($respuesta);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function generarReporte($idPlanta, $yearAndMonth, $tipoDM)
    {
        // Obtención de las reglas del SAT
        date_default_timezone_set('America/Mexico_City');
        $json_reglas_sat = file_get_contents(public_path('docs\Mensual.schema.json'));
        $reglas = json_decode($json_reglas_sat, true);

        // Obtención del parametro hora y fecha
        $parts = explode('-', $yearAndMonth);
        $year = $parts[0];
        $month = $parts[1];

        if($tipoDM == 0){
            return $this->generarReporteMensual($idPlanta, $year, $month);
            
        }else if($tipoDM == 1){
            return $this->generarReportesDiarios($idPlanta, $year, $month);
        }else{
            $reportes = [
                "MENSUALES" => $this->generarReporteMensual($idPlanta, $year, $month),
                "DIARIOS" => $this->generarReportesDiarios($idPlanta, $year, $month)
            ];
            return $reportes;
        }
    }

    
}
