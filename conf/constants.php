<?php




//envío de emails.


//desarrollo.
define('CDT_POP_MAIL_FROM', 'proyectos.secyt@presi.unlp.edu.ar');
define('CDT_POP_MAIL_FROM_NAME', 'Gestión de Proyectos SeCyT U.N.L.P.');
define('CDT_POP_MAIL_HOST', 'smtp.presi.unlp.edu.ar');
define('CDT_POP_MAIL_PORT', '465');
define('CDT_POP_MAIL_SMTP_SECURE', 'ssl');
define('CDT_POP_MAIL_USERNAME', 'proyectos.secyt');
define('CDT_POP_MAIL_PASSWORD', 'cytPro06');
define('CDT_MAIL_ENVIO_POP', true);


define("CDT_DEBUG_LOG", true);
define("CDT_ERROR_LOG", true);
define("CDT_MESSAGE_LOG", true);
define("CDT_TEST_MODE", true);

define('CYT_TIPO_INTEGRANTE_DIRECTOR', '1');
define('CYT_TIPO_INTEGRANTE_CODIRECTOR', '2');
define('CYT_TIPO_INTEGRANTE_FORMADO', '3');
define('CYT_TIPO_INTEGRANTE_EN_FORMACION', '4');
define('CYT_TIPO_INTEGRANTE_BECARIO', '5');
define('CYT_TIPO_INTEGRANTE_COLABORADOR', '6');

define('CYT_ESTADO_ALTA_CREADA', 1);
define('CYT_ESTADO_ALTA_RECIBIDA', 2);
define('CYT_ESTADO_INTEGRANTE', 3);
define('CYT_ESTADO_BAJA_CREADA', 4);
define('CYT_ESTADO_BAJA_RECIBIDA', 5);
define('CYT_ESTADO_CAMBIO_CREADO', 6);
define('CYT_ESTADO_CAMBIO_RECIBIDO', 7);

define('CYT_CD_GROUPS_MOSTRAR', '12,13,14,15');

define('CYT_TIPO_INVESTIGADOR_MOSTRADOS', '3,4,5,6');
define('CYT_TIPO_INVESTIGADOR_MOSTRADOS_SIN_COLABORADOR', '3,4,5');

define('CYT_CARGOS_MOSTRADOS', '1,2,3,4,5,7,8,9,10,11,12,13');

define('CYT_YEAR', 2020);

define('CYT_PERIODO', 1);

define('CYT_CD_UNIVERSIDAD_UNLP', '11');

define('CYT_MAYORES_DEDICACIONES', '1,2');

define('CYT_CARGOS_EMERITOS_CONSULTOS', '12,13');

define('CYT_CD_DEDDOC_EXCLUSIVA', '1');
define('CYT_CD_DEDDOC_SEMIEXCLUSIVA', '2');
define('CYT_CD_DEDDOC_SIMPLE', '3');

define('CYT_FECHA_CIERRE', '2020-05-03 18:00:00');

//lista de permisos
define('CYT_FUNCTION_ENVIAR_SOLICITUD', '78');
define('CYT_FUNCTION_LISTAR_ESTADO', '52');
define('CYT_FUNCTION_ADMITIR_SOLICITUD', '69');
define('CYT_FUNCTION_RECHAZAR_SOLICITUD', '70');

define('CYT_MIN_INTEGRANTES', '3');
define('CYT_MIN_CATEGORIZADOS', '2');
define('CYT_MIN_MAYOR_DEDICACION', '2');
define('CYT_MIN_HS_TOTALES', '30');



?>