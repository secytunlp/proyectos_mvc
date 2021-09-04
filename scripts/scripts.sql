###########################################Integrantes con estado pendiente#####################################################################3
SELECT proyecto.ds_codigo as proyecto_ds_codigo , tipoinvestigador.ds_tipoinvestigador as tipoinvestigador_ds_tipoinvestigador , 
CONCAT(docente.ds_apellido,', ', docente.ds_nombre) AS Investigador,
CONCAT(docente.nu_precuil, '-',docente.nu_documento,'-',docente.nu_postcuil) AS CUIL,
categoria.ds_categoria as categoria_ds_categoria , estadointegrante.ds_estado as estadointegrante_ds_estado , cyt_integrante_estado.dt_alta as cyt_integrante_estado_dt_alta ,
cyt_integrante_estado.dt_baja as cyt_integrante_estado_dt_baja , cyt_integrante_estado.dt_cambio as cyt_integrante_estado_dt_cambio ,
cyt_integrante_estado.fechaDesde as cyt_integrante_estado_fechaDesde 
  FROM integrante LEFT JOIN proyecto ON(integrante.cd_proyecto = proyecto.cd_proyecto) 
  LEFT JOIN docente ON(integrante.cd_docente = docente.cd_docente) 
  LEFT JOIN titulo ON(integrante.cd_titulo = titulo.cd_titulo) 
  LEFT JOIN titulo Titulopost ON(integrante.cd_titulopost = Titulopost.cd_titulo) 
  LEFT JOIN categoria ON(integrante.cd_categoria = categoria.cd_categoria) 
  LEFT JOIN carrerainv ON(integrante.cd_carrerainv = carrerainv.cd_carrerainv) 
  LEFT JOIN organismo ON(integrante.cd_organismo = organismo.cd_organismo) 
  LEFT JOIN universidad ON(integrante.cd_universidad = universidad.cd_universidad) 
  LEFT JOIN cargo ON(integrante.cd_cargo = cargo.cd_cargo) 
  LEFT JOIN deddoc ON(integrante.cd_deddoc = deddoc.cd_deddoc) 
  LEFT JOIN facultad ON(integrante.cd_facultad = facultad.cd_facultad) 
  LEFT JOIN unidad LugarTrabajo ON(integrante.cd_unidad = LugarTrabajo.cd_unidad) 
  INNER JOIN cyt_integrante_estado ON(cyt_integrante_estado.integrante_oid = integrante.oid) 
  LEFT JOIN estadointegrante ON(cyt_integrante_estado.estado_oid = estadointegrante.cd_estado) 
  LEFT JOIN tipoinvestigador ON(cyt_integrante_estado.tipoinvestigador_oid = tipoinvestigador.cd_tipoinvestigador) 
  WHERE   cyt_integrante_estado.estado_oid <> 3 AND (fechaHasta is null)  
  ORDER BY  proyecto.ds_codigo ASC ,  docente.ds_apellido ASC ,   docente.ds_nombre ASC


####################################### Exportar proyectos al sistema Incentivos de la SIU ##################################################
####################################### Calcular presupuestos de proyectos ##################################################################
SELECT `proyecto`,`monto` AS '2019', proyecto.nu_duracion 
FROM `aux_subsidios_proyectos` 
INNER JOIN proyecto ON aux_subsidios_proyectos.proyecto = proyecto.ds_codigo 
WHERE proyecto.dt_ini ='2019-01-01'



#######################################Proyectos##################################################
SELECT P.`ds_codigo` ,'' as extendido, `ds_titulo` , `dt_ini` , `dt_fin` , `dt_ini` , F.ds_facultad, P.ds_abstract1, 
'P' as moneda, 0 as presupuesto, CASE P.ds_tipo WHEN 'A' THEN 'IA' ELSE CASE P.ds_tipo WHEN 'B' THEN 'IB' ELSE 'DE' END END AS Actividad, 
'' AS ds_disciplina, '' as ds_especialidad, P.ds_clave1, P.ds_clave2, P.ds_clave3, '' AS ds_clave4
FROM `proyecto` P 
INNER JOIN facultad F ON P.cd_facultad = F.cd_facultad 

WHERE P.cd_tipoacreditacion =1
AND P.cd_estado =5
AND P.dt_ini = '2019-01-01'
#######################################Integrantes##################################################
SELECT D.ds_nombre, D.ds_apellido, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, P.ds_codigo, 
CASE IE.tipoInvestigador_oid WHEN 1 THEN 1 ELSE 0 END AS Director, CASE IE.tipoInvestigador_oid WHEN 1 THEN 'D' ELSE 
CASE IE.tipoInvestigador_oid WHEN 2 THEN 'C' ELSE CASE IE.tipoInvestigador_oid WHEN 3 THEN 'I' ELSE CASE IE.tipoInvestigador_oid 
WHEN 5 THEN 'B' ELSE CASE IE.tipoInvestigador_oid WHEN 4 THEN 'I' ELSE 0 END END END END END AS Funcion 
FROM integrante I INNER JOIN docente D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN cyt_integrante_estado IE ON I.oid = IE.integrante_oid AND IE.fechaHasta IS NULL
WHERE P.cd_tipoacreditacion =1
AND P.cd_estado =5
AND P.dt_ini = '2019-01-01'
AND IE.tipoInvestigador_oid <> 6
AND (IE.estado_oid = 3 OR IE.estado_oid = 4 OR IE.estado_oid = 5 OR IE.estado_oid = 8 OR IE.estado_oid = 9) 
AND ((IE.estado_oid != 4 AND IE.estado_oid != 5 AND I.dt_baja > '2019-01-01') OR IE.estado_oid = 4 OR IE.estado_oid = 5 OR I.dt_baja IS NULL OR I.dt_baja = '0000-00-00')


#######################################Confirmaci贸n o rechazo de altas, bajas y cambios durante el a帽o##################################################
SELECT DISTINCT cyt_integrante_estado.integrante_oid 
FROM `cyt_integrante_estado` INNER JOIN cyt_user ON cyt_integrante_estado.user_oid = cyt_user.oid
INNER JOIN cyt_user_usergroup ON cyt_user.oid = cyt_user_usergroup.user_oid

WHERE `fechaDesde` >= '2018-01-01' AND `fechaDesde` < '2019-01-01' AND (cyt_user_usergroup.usergroup_oid = 14 OR cyt_user_usergroup.usergroup_oid = 1)

#######################################Con proyectos en ejecuci贸n sin scholar##################################################
SELECT D.* FROM docente D
WHERE D.cd_universidad IN (11,0) AND EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.dt_fin > '2019-01-01' AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2019-01-01') 
AND I.cd_docente = D.cd_docente) AND NOT EXISTS (SELECT `google_scholar_con_dni`.dni FROM `google_scholar_con_dni` 
WHERE `google_scholar_con_dni`.dni = D.nu_documento)

#######################################Directores de 2 proyectos en ejecuci贸n##################################################
SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, 
CAT.ds_categoria as Categoria, F.ds_facultad, CASE WHEN (D.cd_carrerainv IS NULL OR D.cd_carrerainv = 11) THEN ''  ELSE CONCAT(carrerainv.ds_carrerainv, '-', organismo.ds_codigo) END carrera
FROM docente D 

LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
 
LEFT JOIN carrerainv ON D.cd_carrerainv = carrerainv.cd_carrerainv LEFT JOIN organismo ON D.cd_organismo = organismo.cd_organismo
LEFT JOIN facultad F ON F.cd_facultad = D.cd_facultad
WHERE EXISTS (
SELECT I.cd_docente, count(I.cd_docente) as directores
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 

WHERE P.cd_tipoacreditacion = 1 AND P.cd_estado=5 AND dt_fin > '2018-12-31' AND I.cd_tipoinvestigador = 1 AND D.cd_docente = I.cd_docente
 AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2019-01-01') 
GROUP BY I.cd_docente
HAVING (count(I.cd_docente)>1))


#######################################Director e integrate en 2 proyectos en ejecuci贸n  ##################################################
SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, 
CAT.ds_categoria as Categoria, F.ds_facultad, CASE WHEN (D.cd_carrerainv IS NULL OR D.cd_carrerainv = 11) THEN ''  ELSE CONCAT(carrerainv.ds_carrerainv, '-', organismo.ds_codigo) END carrera
FROM docente D 

LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
 
LEFT JOIN carrerainv ON D.cd_carrerainv = carrerainv.cd_carrerainv LEFT JOIN organismo ON D.cd_organismo = organismo.cd_organismo
LEFT JOIN facultad F ON F.cd_facultad = D.cd_facultad
WHERE EXISTS (
SELECT I.cd_docente, count(I.cd_docente) as directores
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 

WHERE P.cd_tipoacreditacion = 1 AND P.cd_estado=5 AND dt_fin > '2018-12-31' AND D.cd_docente = I.cd_docente
 AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2019-01-01') AND EXISTS (
 SELECT I2.cd_docente
FROM proyecto P2 LEFT JOIN integrante I2 ON P2.cd_proyecto = I2.cd_proyecto 

WHERE P2.cd_tipoacreditacion = 1 AND P2.cd_estado=5 AND P2.dt_fin > '2018-12-31' AND I2.cd_tipoinvestigador = 1 
 AND (I2.dt_baja IS NULL OR I2.dt_baja = '0000-00-00' OR I2.dt_baja > '2019-01-01') AND I.cd_docente = I2.cd_docente)
GROUP BY I.cd_docente
HAVING (count(I.cd_docente)>1))

#######################################Director y codirector de 2 proyectos en ejecuci贸n##################################################
SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, 
CAT.ds_categoria as Categoria, F.ds_facultad, CASE WHEN (D.cd_carrerainv IS NULL OR D.cd_carrerainv = 11) THEN ''  ELSE CONCAT(carrerainv.ds_carrerainv, '-', organismo.ds_codigo) END carrera
FROM docente D 

LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
 
LEFT JOIN carrerainv ON D.cd_carrerainv = carrerainv.cd_carrerainv LEFT JOIN organismo ON D.cd_organismo = organismo.cd_organismo
LEFT JOIN facultad F ON F.cd_facultad = D.cd_facultad
WHERE EXISTS (
SELECT I.cd_docente, count(I.cd_docente) as directores
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 

WHERE P.cd_tipoacreditacion = 1 AND P.cd_estado=5 AND dt_fin > '2018-12-31' AND D.cd_docente = I.cd_docente AND (I.cd_tipoinvestigador = 2 OR I.cd_tipoinvestigador = 1)
 AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2019-01-01') AND EXISTS (
 SELECT I2.cd_docente
FROM proyecto P2 LEFT JOIN integrante I2 ON P2.cd_proyecto = I2.cd_proyecto 

WHERE P2.cd_tipoacreditacion = 1 AND P2.cd_estado=5 AND P2.dt_fin > '2018-12-31' AND I2.cd_tipoinvestigador = 1 
 AND (I2.dt_baja IS NULL OR I2.dt_baja = '0000-00-00' OR I2.dt_baja > '2019-01-01') AND I.cd_docente = I2.cd_docente)
GROUP BY I.cd_docente
HAVING (count(I.cd_docente)>1))

####################################### CATEGORIZADOS, CARGOS y CARRERA ############################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Investigador, D.nu_documento, CA.ds_categoria, F.ds_facultad, C.ds_cargo, CAR.ds_carrerainv, O.ds_codigo 
FROM docente D 
LEFT JOIN categoria CA ON D.cd_categoria = CA.cd_categoria
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad 
LEFT JOIN cargo C ON D.cd_cargo = C.cd_cargo
LEFT JOIN carrerainv CAR ON D.cd_carrerainv = CAR.cd_carrerainv
LEFT JOIN organismo O ON D.cd_organismo = O.cd_organismo
WHERE ( D.cd_universidad IS NULL OR D.cd_universidad IN (0,11)) AND D.cd_categoria IN (6,7,8,9,10)

####################################### Becarios CONICET ############################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Investigador, D.nu_documento, CA.ds_categoria, F.ds_facultad, C.ds_cargo, CAR.ds_carrerainv, O.ds_codigo, D.bl_becario, D.ds_tipobeca, D.ds_orgbeca 
FROM docente D 
LEFT JOIN categoria CA ON D.cd_categoria = CA.cd_categoria
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad 
LEFT JOIN cargo C ON D.cd_cargo = C.cd_cargo
LEFT JOIN carrerainv CAR ON D.cd_carrerainv = CAR.cd_carrerainv
LEFT JOIN organismo O ON D.cd_organismo = O.cd_organismo
WHERE D.ds_orgbeca = 'CONICET' AND EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.cd_estado = 5 AND P.dt_ini < '2019-01-01' AND P.dt_fin > '2018-01-01' AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2018-01-01') 
AND I.cd_docente = D.cd_docente)


####################################### Investigadores CIC ############################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Investigador, D.nu_documento, CA.ds_categoria, F.ds_facultad, C.ds_cargo, CAR.ds_carrerainv, O.ds_codigo 
FROM docente D 
LEFT JOIN categoria CA ON D.cd_categoria = CA.cd_categoria
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad 
LEFT JOIN cargo C ON D.cd_cargo = C.cd_cargo
LEFT JOIN carrerainv CAR ON D.cd_carrerainv = CAR.cd_carrerainv
LEFT JOIN organismo O ON D.cd_organismo = O.cd_organismo
WHERE D.cd_organismo = 1 AND EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.cd_estado = 5 AND P.dt_ini < '2019-01-01' AND P.dt_fin > '2018-01-01' AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2018-01-01') 
AND I.cd_docente = D.cd_docente)


####################################### Investigadores sin carrera con proyectos en ejecucion ############################################################
SELECT 
CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, CAT.ds_categoria as Categoria, D.nu_dedinv as Ded_Inv, CI.ds_carrerainv, O.ds_codigo,
FI.ds_facultad as Facultad_Int,CASE  WHEN beca.cd_beca IS NULL THEN (CASE WHEN D.dt_beca >= '2020-01-01' THEN D.ds_tipobeca ELSE (CASE WHEN D.dt_becaEstimulo >= '2020-01-01' THEN 'EVC' ELSE '' END) END) ELSE beca.ds_tipobeca END as beca,CASE  WHEN beca.cd_beca IS NULL THEN (CASE WHEN D.dt_beca >= '2020-01-01' THEN D.ds_orgbeca ELSE (CASE WHEN D.dt_becaEstimulo >= '2020-01-01' THEN 'EVC' ELSE '' END) END) ELSE 'UNLP' END as beca
FROM docente D 

LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN carrerainv CI ON CI.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo O ON O.cd_organismo = D.cd_organismo
LEFT JOIN beca ON D.cd_docente = beca.cd_docente AND beca.dt_hasta >= '2020-01-01'
LEFT JOIN facultad FI ON FI.cd_facultad = D.cd_facultad

WHERE (D.cd_universidad IN (11,0) OR D.cd_universidad is NULL) AND EXISTS (SELECT I2.cd_docente FROM integrante I2 INNER JOIN proyecto P2 ON I2.cd_proyecto = P2.cd_proyecto 
WHERE P2.dt_fin > '2020-01-01' AND P2.cd_estado IN (5,6,8) AND I2.cd_tipoinvestigador !=6 AND (I2.dt_baja IS NULL OR I2.dt_baja = '0000-00-00' OR I2.dt_baja > '2020-01-01') 
AND I2.cd_docente = D.cd_docente )

####################################### Investigadores con cargo y sin facultad ############################################################
SELECT 
CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, CAT.ds_categoria as Categoria, CI.ds_carrerainv, O.ds_codigo,
FI.ds_facultad as Facultad_Int,CASE  WHEN beca.cd_beca IS NULL THEN (CASE WHEN D.dt_beca >= '2020-01-01' THEN D.ds_tipobeca ELSE (CASE WHEN D.dt_becaEstimulo >= '2020-01-01' THEN 'EVC' ELSE '' END) END) ELSE beca.ds_tipobeca END as beca,CASE  WHEN beca.cd_beca IS NULL THEN (CASE WHEN D.dt_beca >= '2020-01-01' THEN D.ds_orgbeca ELSE (CASE WHEN D.dt_becaEstimulo >= '2020-01-01' THEN 'EVC' ELSE '' END) END) ELSE 'UNLP' END as beca
FROM docente D 

LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN carrerainv CI ON CI.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo O ON O.cd_organismo = D.cd_organismo
LEFT JOIN beca ON D.cd_docente = beca.cd_docente AND beca.dt_hasta >= '2020-01-01'
LEFT JOIN facultad FI ON FI.cd_facultad = D.cd_facultad

WHERE D.cd_cargo in (1,2,3,4,5,7,8,9,10,11,12,13) AND (D.cd_facultad IN (574,0) OR D.cd_facultad is NULL) AND EXISTS (SELECT I2.cd_docente FROM integrante I2 INNER JOIN proyecto P2 ON I2.cd_proyecto = P2.cd_proyecto 
WHERE P2.dt_fin > '2020-01-01' AND P2.cd_estado IN (5,6,8) AND I2.cd_tipoinvestigador !=6 AND (I2.dt_baja IS NULL OR I2.dt_baja = '0000-00-00' OR I2.dt_baja > '2020-01-01') 
AND I2.cd_docente = D.cd_docente )

####################################### Investigadores con cargo que no est谩n en alfab茅tico ############################################################
SELECT 
CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, C.ds_cargo as Cargo, DED.ds_deddoc as Ded_Doc, CAT.ds_categoria as Categoria, CI.ds_carrerainv, O.ds_codigo,
FI.ds_facultad as Facultad_Int,CASE  WHEN beca.cd_beca IS NULL THEN (CASE WHEN D.dt_beca >= '2020-01-01' THEN D.ds_tipobeca ELSE (CASE WHEN D.dt_becaEstimulo >= '2020-01-01' THEN 'EVC' ELSE '' END) END) ELSE beca.ds_tipobeca END as beca,CASE  WHEN beca.cd_beca IS NULL THEN (CASE WHEN D.dt_beca >= '2020-01-01' THEN D.ds_orgbeca ELSE (CASE WHEN D.dt_becaEstimulo >= '2020-01-01' THEN 'EVC' ELSE '' END) END) ELSE 'UNLP' END as beca
FROM docente D 

LEFT JOIN cargo C ON C.cd_cargo = D.cd_cargo
LEFT JOIN deddoc DED ON DED.cd_deddoc = D.cd_deddoc
LEFT JOIN categoria CAT ON CAT.cd_categoria = D.cd_categoria
LEFT JOIN carrerainv CI ON CI.cd_carrerainv = D.cd_carrerainv
LEFT JOIN organismo O ON O.cd_organismo = D.cd_organismo
LEFT JOIN beca ON D.cd_docente = beca.cd_docente AND beca.dt_hasta >= '2020-01-01'
LEFT JOIN facultad FI ON FI.cd_facultad = D.cd_facultad

WHERE D.cd_cargo in (1,2,3,4,5,7,8,9,10,11,12,13) AND NOT EXISTS (SELECT cargos_alfabetico.dni FROM `cargos_alfabetico` WHERE `escalafon` LIKE 'Docente' AND cargos_alfabetico.dni = D.nu_documento )


####################################### Prorrogar proyectos en ejecuci髇 ############################################################

UPDATE 
`proyecto` 
INNER JOIN integrante ON proyecto.cd_proyecto = integrante.cd_proyecto
INNER JOIN cyt_integrante_estado ON integrante.oid = cyt_integrante_estado.integrante_oid AND cyt_integrante_estado.fechaHasta is null and cyt_integrante_estado.tipoInvestigador_oid=1 
SET  proyecto.dt_fin = DATE(DATE_ADD(proyecto.dt_fin, INTERVAL 1 YEAR)), cyt_integrante_estado.motivo = CONCAT(motivo, '.\r\nProyecto prorrogado por pandemia el ',now())
WHERE proyecto.`dt_fin` > '2019-12-31'  AND proyecto.cd_estado = 5 AND cyt_integrante_estado.motivo IS NOT NULL;

UPDATE 
`proyecto` 
INNER JOIN integrante ON proyecto.cd_proyecto = integrante.cd_proyecto
INNER JOIN cyt_integrante_estado ON integrante.oid = cyt_integrante_estado.integrante_oid AND cyt_integrante_estado.fechaHasta is null and cyt_integrante_estado.tipoInvestigador_oid=1 
SET  proyecto.dt_fin = DATE(DATE_ADD(proyecto.dt_fin, INTERVAL 1 YEAR)), cyt_integrante_estado.motivo = CONCAT('Proyecto prorrogado por pandemia el ',now())
WHERE proyecto.`dt_fin` > '2019-12-31'  AND proyecto.cd_estado = 5 AND cyt_integrante_estado.motivo IS NULL;


########################################## Informes para liquidaciones (cat distintas y dem醩) ########################################################

#####CAT distintas
SELECT CONCAT(aux_liquidacion.nu_precuil,'-',LPAD(aux_liquidacion.nu_documento,8,'0'),'-',aux_liquidacion.nu_postcuil) AS CUIL, CONCAT(aux_liquidacion.ds_apellido,', ',aux_liquidacion.ds_nombre) AS Investigador, aux_liquidacion.ds_categoria, aux_cat_2014.ds_categoria, facultad.ds_facultad
FROM `aux_liquidacion` 
LEFT JOIN aux_cat_2014 ON aux_cat_2014.nu_documento = aux_liquidacion.nu_documento
LEFT JOIN docente ON docente.nu_documento = aux_liquidacion.nu_documento
LEFT JOIN facultad ON docente.cd_facultad = facultad.cd_facultad
WHERE aux_liquidacion.ds_categoria != aux_cat_2014.ds_categoria AND aux_cat_2014.ds_categoria != ''

#####Sin CAT firme
SELECT CONCAT(aux_liquidacion.nu_precuil,'-',LPAD(aux_liquidacion.nu_documento,8,'0'),'-',aux_liquidacion.nu_postcuil) AS CUIL, CONCAT(aux_liquidacion.ds_apellido,', ',aux_liquidacion.ds_nombre) AS Investigador, aux_liquidacion.ds_categoria, aux_cat_2014.ds_categoria, facultad.ds_facultad
FROM `aux_liquidacion` 
LEFT JOIN aux_cat_2014 ON aux_cat_2014.nu_documento = aux_liquidacion.nu_documento
LEFT JOIN docente ON docente.nu_documento = aux_liquidacion.nu_documento
LEFT JOIN facultad ON docente.cd_facultad = facultad.cd_facultad
WHERE aux_cat_2014.ds_categoria = ''


#####NO salieron liquidados

SELECT  CONCAT(`aux_solic_inc`.nu_precuil,'-',LPAD(`aux_solic_inc`.nu_documento,8,'0'),'-',`aux_solic_inc`.nu_postcuil) AS CUIL, CONCAT(`aux_solic_inc`.ds_apellido,', ',`aux_solic_inc`.ds_nombre) AS Investigador, `aux_solic_inc`.ds_estado, aux_cat_2014.ds_categoria, facultad.ds_facultad 
FROM `aux_solic_inc` 
LEFT JOIN aux_cat_2014 ON aux_cat_2014.nu_documento = `aux_solic_inc`.nu_documento
LEFT JOIN docente ON docente.nu_documento = `aux_solic_inc`.nu_documento
LEFT JOIN facultad ON docente.cd_facultad = facultad.cd_facultad
WHERE NOT EXISTS (SELECT aux_liquidacion.`nu_documento` FROM `aux_liquidacion` WHERE aux_liquidacion.`nu_documento` = aux_solic_inc.nu_documento)

SELECT CONCAT(aux_liquidacion.nu_precuil,'-',LPAD(aux_liquidacion.nu_documento,8,'0'),'-',aux_liquidacion.nu_postcuil) AS CUIL, CONCAT(aux_liquidacion.ds_apellido,', ',aux_liquidacion.ds_nombre) AS Investigador, aux_liquidacion.ds_categoria, aux_cat_2014.ds_categoria, facultad.ds_facultad
FROM `aux_liquidacion` 
LEFT JOIN aux_cat_2014 ON aux_cat_2014.nu_documento = aux_liquidacion.nu_documento
LEFT JOIN docente ON docente.nu_documento = aux_liquidacion.nu_documento
LEFT JOIN facultad ON docente.cd_facultad = facultad.cd_facultad
WHERE aux_cat_2014.ds_categoria = ''


########################################Actualizar becas UNLP ################################################################################################

##busco las que tienen distintas fechas y las corrijo a mano
SELECT becas_unlp_nuevas.* FROM `becas_unlp_nuevas`
INNER JOIN docente ON becas_unlp_nuevas.nu_documento = docente.nu_documento
INNER JOIN beca ON docente.cd_docente = beca.cd_docente
WHERE becas_unlp_nuevas.ds_tipobeca = beca.ds_tipobeca AND (becas_unlp_nuevas.dt_desde != beca.dt_desde OR becas_unlp_nuevas.dt_hasta != beca.dt_hasta);

##inserto las nuevas del a駉
INSERT INTO beca (cd_docente, bl_unlp, ds_tipobeca, dt_desde, dt_hasta)
SELECT docente.cd_docente, '1', becas_unlp_nuevas.ds_tipobeca, becas_unlp_nuevas.dt_desde, becas_unlp_nuevas.dt_hasta
FROM becas_unlp_nuevas 
INNER JOIN docente ON becas_unlp_nuevas.nu_documento = docente.nu_documento
WHERE NOT EXISTS (
SELECT bn2.nu_documento FROM becas_unlp_nuevas bn2
INNER JOIN docente D2 ON bn2.nu_documento = D2.nu_documento
INNER JOIN beca ON D2.cd_docente = beca.cd_docente
WHERE bn2.ds_tipobeca = beca.ds_tipobeca AND bn2.nu_documento = becas_unlp_nuevas.nu_documento); 



### me sobran
SELECT B.cd_beca, CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Docente, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) AS CUIL, B.`ds_tipobeca`,`dt_desde`,`dt_hasta` FROM `beca` B INNER JOIN docente D ON B.cd_docente = D.cd_docente WHERE bl_unlp = 1 AND dt_hasta >= '2021-01-01' AND NOT EXISTS (SELECT becas_unlp_nuevas.nu_documento FROM `becas_unlp_nuevas` WHERE becas_unlp_nuevas.nu_documento = D.nu_documento)
ORDER BY ds_apellido, ds_nombre


########################################Integrantes alumnos ################################################################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) as Investigador, CONCAT(D.nu_precuil,'-',LPAD(D.nu_documento,8,'0'),'-',D.nu_postcuil) AS CUIL, CONCAT(SUBSTRING(D.dt_nacimiento,9,2),'/',SUBSTRING(D.dt_nacimiento,6,2),'/',SUBSTRING(D.dt_nacimiento,1,4)) as Nacimiento, P.ds_codigo as Proyecto, E.ds_tipoacreditacion as Tipo_Proyecto, 
TI.ds_tipoinvestigador as Tipo, EI.ds_estado as Estado ,
CONCAT(SUBSTRING(I.dt_alta,9,2),'/',SUBSTRING(I.dt_alta,6,2),'/',SUBSTRING(I.dt_alta,1,4)) as Alta, 
CONCAT(SUBSTRING(I.dt_baja,9,2),'/',SUBSTRING(I.dt_baja,6,2),'/',SUBSTRING(I.dt_baja,1,4)) as Baja, 
I.nu_horasinv 
FROM proyecto P LEFT JOIN integrante I ON P.cd_proyecto = I.cd_proyecto 
LEFT JOIN docente D ON I.cd_docente = D.cd_docente
LEFT JOIN tipoacreditacion E ON E.cd_tipoacreditacion = P.cd_tipoacreditacion 
LEFT JOIN tipoinvestigador TI ON TI.cd_tipoinvestigador = I.cd_tipoinvestigador 


INNER JOIN cyt_integrante_estado IE ON I.oid = IE.integrante_oid AND IE.fechaHasta IS NULL

LEFT JOIN estadointegrante EI ON EI.cd_estado = I.cd_estado




WHERE P.cd_estado = 5 AND dt_ini < '2021-01-01' AND dt_fin >= '2020-01-01' AND D.bl_estudiante =1  AND (I.dt_alta != I.dt_baja OR I.dt_baja IS NULL) AND (I.dt_baja > '2020-12-31' OR I.dt_baja IS NULL) AND D.cd_cargo = 6 AND I.dt_alta < '2021-01-01'
ORDER BY D.ds_apellido, D.ds_nombre


