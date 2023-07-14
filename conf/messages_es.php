<?php

/**
 * se definen los mensajes del sistema en español.
 *
 * @author modelBuilder
 *
 */


include_once('messages_labels_es.php');

define('CYT_MSG_PROYECTO_NO_SELECCIONADO', 'No se ha seleccionado el proyecto, presione en el ícono Proyectos (al centro-superior de la pantalla) para seleccionarlo', true);

define('CYT_MSG_FIN_PERIODO_ALTAS', 'El período para presentar las Solicitudes ha Finalizado', true);

//PDF
define('CYT_MSG_PROYECTO_PDF_TITLE', 'VISUALIZAR PROYECTO', true);
define('CYT_MSG_PROYECTO_PDF_HEADER_TITLE', 'GESTION DE PROYECTOS', true);
define('CYT_MSG_PROYECTO_PDF_PAGINA', 'Página', true);
define('CYT_MSG_PROYECTO_PDF_PAGINA_DE', 'de', true);

/* TIPOS DE PROYECTO */

define('CYT_MSG_TIPO_PROYECTO_TITLE_LIST', 'Tipos de proyecto', true);
define('CYT_MSG_TIPO_PROYECTO_TITLE_ADD', 'Agregar ' . CYT_LBL_TIPO_PROYECTO, true);
define('CYT_MSG_TIPO_PROYECTO_TITLE_UPDATE', 'Modificar ' . CYT_LBL_TIPO_PROYECTO , true);
define('CYT_MSG_TIPO_PROYECTO_TITLE_VIEW', 'Visualizar ' . CYT_LBL_TIPO_PROYECTO , true);
define('CYT_MSG_TIPO_PROYECTO_TITLE_DELETE', 'Borrar ' . CYT_LBL_TIPO_PROYECTO , true);

define('CYT_MSG_TIPO_PROYECTO_NOMBRE_REQUIRED', CYT_LBL_TIPO_PROYECTO_NOMBRE . ' es requerido', true);

/* PROYECTOS */

define('CYT_MSG_PROYECTO_TITLE_LIST', 'Proyectos', true);
define('CYT_MSG_PROYECTO_TITLE_ADD', 'Agregar ' . CYT_LBL_PROYECTO, true);
define('CYT_MSG_PROYECTO_TITLE_UPDATE', 'Modificar ' . CYT_LBL_PROYECTO , true);
define('CYT_MSG_PROYECTO_TITLE_VIEW', 'Visualizar ' . CYT_LBL_PROYECTO , true);
define('CYT_MSG_PROYECTO_TITLE_DELETE', 'Borrar ' . CYT_LBL_PROYECTO , true);

define('CYT_MSG_PROYECTO_FINALIDAD', "Finalidad", true);
define('CYT_MSG_PROYECTO_ANTECEDENTES', "Antecedentes", true);
define('CYT_MSG_PROYECTO_FUNCIONES', "Funciones", true);

/*define('CYT_MSG_PROYECTO_DENOMINACION_REQUIRED', CYT_LBL_PROYECTO_DENOMINACION . ' es requerido', true);
define('CYT_MSG_PROYECTO_TIPO_PROYECTO_REQUIRED', CYT_LBL_PROYECTO_TIPO_PROYECTO . ' es requerido', true);
define('CYT_MSG_PROYECTO_ESPECIALIDAD_REQUIRED', CYT_LBL_PROYECTO_ESPECIALIDAD . ' es requerido', true);
define('CYT_MSG_PROYECTO_OBJETIVOS_REQUIRED', CYT_LBL_PROYECTO_OBJETIVOS . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_FINALIDAD, true);
define('CYT_MSG_PROYECTO_LINEAS_REQUIRED', CYT_LBL_PROYECTO_LINEAS . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_FINALIDAD, true);
define('CYT_MSG_PROYECTO_JUSTIFICACION_REQUIRED', CYT_LBL_PROYECTO_JUSTIFICACION . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_FINALIDAD, true);
define('CYT_MSG_PROYECTO_FUNCIONES_REQUIRED', CYT_LBL_PROYECTO_FUNCIONES . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_FUNCIONES, true);
define('CYT_MSG_PROYECTO_PRODUCCION_REQUIRED', CYT_LBL_PROYECTO_PRODUCCION . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_ANTECEDENTES, true);
define('CYT_MSG_PROYECTO_PROYECTOS_REQUIRED', CYT_LBL_PROYECTO_PROYECTOS . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_ANTECEDENTES, true);
define('CYT_MSG_PROYECTO_RRHH_REQUIRED', CYT_LBL_PROYECTO_RRHH . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_ANTECEDENTES, true);
define('CYT_MSG_PROYECTO_REGLAMENTO_REQUIRED', CYT_LBL_PROYECTO_REGLAMENTO . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_FUNCIONES, true);
define('CYT_MSG_PROYECTO_INFRAESTRUCTURA_REQUIRED', CYT_LBL_PROYECTO_INFRAESTRUCTURA . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_FUNCIONES, true);
define('CYT_MSG_PROYECTO_EQUIPAMIENTO_REQUIRED', CYT_LBL_PROYECTO_EQUIPAMIENTO . ' es requerido, ubicado en menú '.CYT_MSG_PROYECTO_FUNCIONES, true);
define('CYT_MSG_PROYECTO_OBSERVACIONES_REQUIRED', CYT_LBL_PROYECTO_OBSERVACIONES . ' es requerido', true);
*/
define('CYT_MSG_PROYECTO_ELIMINAR_PROHIBIDO', 'Sólo se pueden eliminar las unidades con estado CREADA', true);
define('CYT_MSG_PROYECTO_MODIFICAR_PROHIBIDO', 'Sólo se pueden modificar las unidades con estado CREADA', true);


/* PROYECTOES FACULTADES*/
//define('CYT_MSG_PROYECTO_FACULTAD_FACULTAD_REQUIRED', CYT_LBL_PROYECTO_FACULTADES_FACULTAD . ' es requerido', true);
define('CYT_MSG_PROYECTO_FACULTAD_REQUIRED', 'Debe asignar al menos una dependencia académica', true);

define('CYT_MSG_PROYECTO_FACULTAD_ASIGNAR', 'Asignar Dependencia', true);
define('CYT_MSG_PROYECTO_FACULTAD', "Indique las dependencias académicas para la unidad", true);

/* INTEGRANTES */

define('CYT_MSG_INTEGRANTE_TITLE_LIST', 'Integrantes', true);
define('CYT_MSG_INTEGRANTE_TITLE_ADD', 'Agregar ' . CYT_LBL_INTEGRANTE, true);
define('CYT_MSG_INTEGRANTE_TITLE_UPDATE', 'Modificar ' . CYT_LBL_INTEGRANTE , true);
define('CYT_MSG_INTEGRANTE_TITLE_VIEW', 'Visualizar ' . CYT_LBL_INTEGRANTE , true);
define('CYT_MSG_INTEGRANTE_TITLE_DELETE', 'Borrar ' . CYT_LBL_INTEGRANTE , true);
define('CYT_MSG_INTEGRANTE_TITLE_BAJA', 'Dar de baja ' . CYT_LBL_INTEGRANTE, true);
define('CYT_MSG_INTEGRANTE_TITLE_CAMBIAR', 'Cambiar Colaborador ' , true);
define('CYT_MSG_INTEGRANTE_TITLE_CAMBIAR_HS', 'Cambiar Dedicación Horaria ' , true);
define('CYT_MSG_INTEGRANTE_TITLE_CAMBIAR_TIPO', 'Cambiar Tipo de Integrante ' , true);

define('CYT_MSG_INTEGRANTE_APELLIDO_CV_REQUIRED', 'Para poder subir los archivos debe ingresar el apellido y CUIL del investigador', true);
define('CYT_MSG_INTEGRANTE_TIPO_INTEGRANTE_REQUIRED', CYT_LBL_TIPO_INTEGRANTE. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_APELLIDO_REQUIRED', CYT_LBL_INTEGRANTE_APELLIDO. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_NOMBRE_REQUIRED', CYT_LBL_INTEGRANTE_NOMBRE. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_MAIL_REQUIRED', CYT_LBL_DOCENTE_MAIL. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_CUIL_REQUIRED', CYT_LBL_INTEGRANTE_CUIL. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_CARRERAINV_REQUIRED', CYT_LBL_INTEGRANTE_CARRERAINV. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_CATEGORIA_REQUIRED', CYT_LBL_INTEGRANTE_CATEGORIA. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_ORGANISMO_REQUIRED', CYT_LBL_INTEGRANTE_ORGANISMO. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_BECA_REQUIRED', CYT_LBL_INTEGRANTE_BECA. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_CARGO_REQUIRED', CYT_LBL_INTEGRANTE_CARGO. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_DEDDOC_REQUIRED', CYT_LBL_INTEGRANTE_DEDDOC. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_FACULTAD_REQUIRED', CYT_LBL_INTEGRANTE_FACULTAD. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_LUGAR_TRABAJO_REQUIRED', CYT_LBL_INTEGRANTE_LUGAR_TRABAJO. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_HORAS_REQUIRED', CYT_LBL_INTEGRANTE_HORAS. ' es requerido', true);
define('CYT_MSG_INTEGRANTE_FECHA_BAJA_REQUIRED', CYT_LBL_INTEGRANTE_FECHA_BAJA . ' es requerido', true);
define('CYT_MSG_INTEGRANTE_CONSECUENCIAS_REQUIRED', 'Consecuencias es requerido', true);
define('CYT_MSG_INTEGRANTE_MOTIVOS_REQUIRED', 'Motivos es requerido', true);

define('CYT_MSG_INTEGRANTE_CUIL_FORMAT', 'El C.U.I.L. debe ser del formato xx-xxxxxxxx-x', true);

define('CYT_MSG_INTEGRANTE_SIN_CARGO_SIN_BECA', 'Si no posee cargo, debe ser becario o tener un cargo en la carrera de investigación', true);
define('CYT_MSG_INTEGRANTE_BECARIO_SIN_BECA', 'Si el integrante es TESISTA, BECARIO se debe especificar la Beca', true);
define('CYT_MSG_INTEGRANTE_SIN_CARGO', 'Debe especificar un cargo', true);
define('CYT_MSG_INTEGRANTE_SIN_DEDDOC', 'Debe especificar una dedicación', true);
define('CYT_MSG_INTEGRANTE_SIN_FECHA_CARGO', 'Debe especificar la fecha de obtención del cargo', true);
define('CYT_MSG_INTEGRANTE_SIN_ORGBECA', 'Debe especificar una institución en la beca', true);
define('CYT_MSG_INTEGRANTE_SIN_TIPOBECA', 'Debe especificar un tipo de beca', true);
define('CYT_MSG_INTEGRANTE_SIN_FECHA_BECA', 'Debe especificar las fechas de la beca', true);
define('CYT_MSG_INTEGRANTE_BECA_TERMINADA', 'La beca finalizó', true);
define('CYT_MSG_INTEGRANTE_ERROR_FECHA_BECA', 'La fecha de fin de la beca debe ser mayor a la de inicio', true);
define('CYT_MSG_INTEGRANTE_SIN_ORGANISMO', 'Debe especificar un organismo', true);
define('CYT_MSG_INTEGRANTE_SIN_CARRERAINV', 'Debe especificar un cargo en Carrera Investigador', true);
define('CYT_MSG_INTEGRANTE_MUCHOS_PROYECTOS', 'El docente ya es integrante y/o colaborador de 2 proyectos en ejecución o no tiene dedicación suficiente para ser integrante y/o colaborador de más de un proyecto (Los becarios sólo pueden ser integrantes de un solo proyecto) <br>Proyecto/s:', true);
define('CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_HORAS', 'Las hs. en el proyecto deben ser 4', true);
define('CYT_MSG_INTEGRANTE_DEDDOC_SIMPLE_COLAB_HORAS', 'Las hs. en el proyecto deben ser menor o igual a 4', true);
define('CYT_MSG_INTEGRANTE_EXTERNO_HORAS', 'Las hs. en el/los proyecto/s deben ser mayor que 3 y no superar 6', true);
define('CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS', 'Las hs. en el/los proyecto/s no deben superar 35', true);
define('CYT_MSG_INTEGRANTE_DEDDOC_EXCLUSIVA_HORAS_MIN', 'Las hs. en el proyecto deben ser mayor a 9', true);
define('CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS', 'Las hs. en el/los proyecto/s no deben superar 15', true);
define('CYT_MSG_INTEGRANTE_DEDDOC_SEMIEXCLUSIVA_HORAS_MIN', 'Las hs. en el proyecto deben ser mayor a 6', true);
define('CYT_MSG_INTEGRANTE_SIN_TITULO', 'Debe especificar un título de grado', true);
define('CYT_MSG_INTEGRANTE_SIN_MATERIAS_ADEUDADAS', 'Debe especificar Carrera, Total de materia y Materias adeudadas (si no es estudiante complete el título de grado)', true);
define('CYT_MSG_INTEGRANTE_SIN_FECHA_BECA_ESTIMULO', 'Debe especificar las fechas de la Beca de Estímulo a las Vocaciones Científicas', true);
define('CYT_MSG_COLABORADOR_CON_CARGO', 'Los COLABORADORES no deben tener cargo docente ni Beca ni cargo en la Carrera de Investigación', true);
define('CYT_MSG_COLABORADOR_CON_OTRO_PROYECTO', 'El docente ya forma parte de otro proyecto en ejecución', true);
define('CYT_MSG_INTEGRANTE_BECARIO_HORAS', 'Las hs. en el proyecto deben ser 40', true);
define('CYT_MSG_INTEGRANTE_BECARIO_HORAS_2', 'Las hs. en el/los proyecto/s no deben superar 40', true);
define('CYT_MSG_INTEGRANTE_BECARIO_HORAS_3', 'Las hs. en el/los proyecto/s no deben superar 30', true);
define('CYT_MSG_INTEGRANTE_BECA_ESTIMULO_HORAS', 'Las hs. en el proyecto deben ser 12', true);

define('CYT_MSG_INTEGRANTE_ALTA_FUERA_PERIODO', 'Fecha de alta fuera del período', true);

define('CYT_MSG_INTEGRANTE_ELIMINAR_PROHIBIDO', 'Sólo se pueden eliminar los investigadores con estado ALTA CREADA', true);
define('CYT_MSG_INTEGRANTE_MODIFICAR_PROHIBIDO', 'Sólo se pueden modificar los investigadores con estado ALTA CREADA', true);
define('CYT_MSG_INTEGRANTE_ENVIAR_PROHIBIDO', 'Sólo se pueden enviar los investigadores con estado ALTA CREADA, BAJA CREADA, CAMBIO CREADO, CAMBIO HS. CREADO ó CAMBIO TIPO CREADO', true);
define('CYT_MSG_INTEGRANTE_VER_PROHIBIDO', 'Sólo se pueden ver los PDFs de los investigadores con estado ALTA CREADA, ALTA RECIBIDA, BAJA CREADA, BAJA RECIBIDA, CAMBIO CREADO, CAMBIO RECIBIDO, CAMBIO HS. CREADO, CAMBIO HS. RECIBIDO, CAMBIO TIPO CREADO ó CAMBIO TIPO RECIBIDO', true);
define('CYT_MSG_INTEGRANTE_ADMITIR_PROHIBIDO', 'Sólo se pueden admitir los investigadores con estado ALTA RECIBIDA, BAJA RECIBIDA, CAMBIO RECIBIDO, CAMBIO HS. RECIBIDO ó CAMBIO TIPO RECIBIDO', true);
define('CYT_MSG_INTEGRANTE_RECHAZAR_PROHIBIDO', 'Sólo se pueden rechazar los investigadores con estado ALTA RECIBIDA, BAJA RECIBIDA, CAMBIO RECIBIDO, CAMBIO HS. RECIBIDO ó CAMBIO TIPO RECIBIDO', true);
define('CYT_MSG_INTEGRANTE_BAJA_PROHIBIDO', 'No se pueden dar de baja a los investigadores que tienen estados pendientes de confirmación', true);
define('CYT_MSG_INTEGRANTE_BAJA_PROHIBIDO2', 'No se pueden dar de baja a los Directores ni Codirectores', true);
define('CYT_MSG_INTEGRANTE_BAJA_PROHIBIDO3', 'El investigador ya tiene una fecha de baja', true);
define('CYT_MSG_INTEGRANTE_BAJA_FUERA_PERIODO', 'Fecha de baja fuera del período', true);

define('CYT_MSG_INTEGRANTE_MIN_CATEGORIZADOS', 'Proyecto con menos de $1 integrantes categorizados con lugar de trabajo en la U.N.L.P. (Debe tildar la opción)', true);
define('CYT_MSG_INTEGRANTE_MIN_MAYOR_DEDICACION', 'Proyecto con menos de $1 integrantes con mayor dedicación en la Unidad Académica que se presenta el proyecto (Debe tildar la opción)', true);
define('CYT_MSG_INTEGRANTE_MIN_INTEGRANTES', 'Proyecto con menos de $1 integrantes', true);
define('CYT_MSG_INTEGRANTE_MIN_HORAS_TOTALES', 'La suma de dedicaciones horarias de los miembros es menor a $1 hs. semanales', true);


define('CYT_MSG_INTEGRANTE_CAMBIO_PROHIBIDO', 'No se pueden cambiar a los investigadores que tienen estados pendientes de confirmación', true);
define('CYT_MSG_INTEGRANTE_CAMBIO_PROHIBIDO2', 'Sólo se pueden cambiar los COLABORADORES', true);
define('CYT_MSG_INTEGRANTE_CAMBIO_PROHIBIDO3', 'El investigador tiene fecha de baja', true);

define('CYT_MSG_INTEGRANTE_CAMBIO_TIPO_PROHIBIDO', 'NO se pueden cambiar los tipos de los DIRECTORES, CODIRECTORS o COLABORADORES', true);
define('CYT_MSG_INTEGRANTE_CAMBIO_TIPO_PROHIBIDO2', 'NO se pueden cambiar los tipos de los integrates con estado CAMBIO TIPO CREADO', true);

define('CYT_MSG_INTEGRANTE_CAMBIO_HS_PROHIBIDO', 'No se puede cambiar la dedicación horaria de los investigadores que tienen estados pendientes de confirmación', true);

define('CYT_MSG_INTEGRANTE_CAMBIO_HS_FUERA_PERIODO', 'Fecha de cambio fuera del período', true);
define('CYT_MSG_INTEGRANTE_CAMBIO_HS_IGUAL', 'No modificó las horas', true);

define('CYT_MSG_INTEGRANTE_CV_REQUERIDO', 'Falta subir el Curriculum', true);
define('CYT_MSG_INTEGRANTE_ACTIVIDADES_REQUERIDO', 'Falta subir el Plan de Trabajo', true);

define('CYT_MSG_INTEGRANTE_RESOLUCION_BECA_REQUERIDO', 'Falta subir la resolución de la beca', true);
define('CYT_MSG_INTEGRANTE_RESOLUCION_TESIS_REQUERIDO', 'Falta subir el certificado de alumno de Doctorado/Maestría', true);

define('CYT_MSG_INTEGRANTE_CV_PROBLEMA', 'Hubo un error al subir el Curriculum, intente nuevamente, si el problema persiste envíenos un mail a proyectos.secyt@presi.unlp.edu.ar', true);
define('CYT_MSG_INTEGRANTE_ACTIVIDADES_PROBLEMA', 'Hubo un error al subir el Plan de Trabajo, intente nuevamente, si el problema persiste envíenos un mail a proyectos.secyt@presi.unlp.edu.ar', true);
define('CYT_MSG_INTEGRANTE_RESOLUCION_BECA_PROBLEMA', 'Hubo un error al subir la Resolución de la Beca, intente nuevamente, si el problema persiste envíenos un mail a proyectos.secyt@presi.unlp.edu.ar', true);


define('CYT_MSG_INTEGRANTE_CAMPO_REQUIRED', 'Es requerido', true);
/* PROYECTOES TIPO ESTADO */
define('CYT_MSG_PROYECTO_TIPO_ESTADO_TITLE_LIST', 'Estados', true);
define('CYT_MSG_PROYECTO_TIPO_ESTADO_CAMBIAR', 'Cambiar-estado', true);

define('CYT_MSG_PROYECTO_TIPO_ESTADO_PROYECTO_REQUIRED', CYT_LBL_PROYECTO. ' es requerido', true);
define('CYT_MSG_PROYECTO_TIPO_ESTADO_TIPO_ESTADO_REQUIRED', CYT_LBL_TIPO_ESTADO. ' es requerido', true);

define('CYT_MSG_INTEGRANTE_FECHA_CAMBIO_REQUIRED', CYT_LBL_INTEGRANTE_FECHA_CAMBIO . ' es requerido', true);

define('CYT_MSG_INTEGRANTE_CAMBIO_HS_PROHIBIDO2', 'No se puede cambiar la dedicacción horaria de los COLABORADORES', true);

define('CYT_MSG_INTEGRANTE_ANULAR_PROHIBIDO', 'Sólo se pueden anular los cambios los investigadores con estado BAJA CREADA, CAMBIO CREADO ó CAMBIO HS. CREADO', true);

define('CYT_MSG_INTEGRANTE_SOLICITUD_ANULAR', 'Anular baja/cambio', true);

define('CYT_LBL_INTEGRANTE_ELIMINAR_ALTA_PREGUNTA', 'Confirma eliminar el Alta creada?', true);

/* INVESTIGADORES */

define('CYT_MSG_DOCENTE_TITLE_LIST', 'Investigadores', true);
define('CYT_MSG_DOCENTE_TITLE_ADD', 'Agregar ' . CYT_LBL_DOCENTE, true);
define('CYT_MSG_DOCENTE_TITLE_UPDATE', 'Modificar ' . CYT_LBL_DOCENTE , true);


?>
