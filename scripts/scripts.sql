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
####################################### Calcular presupuestos de proyectos (no usar) ##################################################################
SELECT `proyecto`,`monto` AS '2020', proyecto.nu_duracion
FROM `aux_subsidios_proyectos` 
INNER JOIN proyecto ON aux_subsidios_proyectos.proyecto = proyecto.ds_codigo 
WHERE proyecto.dt_ini ='2020-01-01'



#######################################Proyectos##################################################
SELECT P.`ds_codigo` ,'' as extendido, `ds_titulo` , `dt_ini` , `dt_fin` , `dt_ini` , F.ds_facultad, P.ds_abstract1, 
'P' as moneda, 0 as presupuesto, CASE P.ds_tipo WHEN 'A' THEN 'IA' ELSE CASE P.ds_tipo WHEN 'B' THEN 'IB' ELSE 'DE' END END AS Actividad, 
'' AS ds_disciplina, '' as ds_especialidad, substring(P.ds_clave1,1,25), substring(P.ds_clave2,1,25), substring(P.ds_clave3,1,25), '0' AS ds_clave4
FROM `proyecto` P 
INNER JOIN facultad F ON P.cd_facultad = F.cd_facultad 

WHERE P.cd_tipoacreditacion =1
AND P.cd_estado =5
AND P.dt_ini = '2021-01-01'

#######################################Integrantes##################################################
SELECT D.ds_nombre, D.ds_apellido, CONCAT(LPAD(D.nu_precuil,2,0),'-',LPAD(D.nu_documento,8,'0'),'-',LPAD(D.nu_postcuil,1,0)) AS CUIL, P.ds_codigo,
CASE IE.tipoInvestigador_oid WHEN 1 THEN 1 ELSE 0 END AS Director, CASE IE.tipoInvestigador_oid WHEN 1 THEN 'D' ELSE 
CASE IE.tipoInvestigador_oid WHEN 2 THEN 'C' ELSE CASE IE.tipoInvestigador_oid WHEN 3 THEN 'I' ELSE CASE IE.tipoInvestigador_oid 
WHEN 5 THEN 'B' ELSE CASE IE.tipoInvestigador_oid WHEN 4 THEN 'I' ELSE 0 END END END END END AS Funcion 
FROM integrante I INNER JOIN docente D ON I.cd_docente = D.cd_docente
INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto
INNER JOIN cyt_integrante_estado IE ON I.oid = IE.integrante_oid AND IE.fechaHasta IS NULL
WHERE P.cd_tipoacreditacion =1
AND P.cd_estado =5
AND P.dt_ini = '2020-01-01'
AND IE.tipoInvestigador_oid <> 6
AND (IE.estado_oid = 3 OR IE.estado_oid = 4 OR IE.estado_oid = 5 OR IE.estado_oid = 8 OR IE.estado_oid = 9) 
AND ((IE.estado_oid != 4 AND IE.estado_oid != 5 AND I.dt_alta < '2021-01-01' AND I.dt_baja > '2020-01-01') OR IE.estado_oid = 4 OR IE.estado_oid = 5 OR (I.dt_baja IS NULL AND I.dt_alta < '2021-01-01') OR (I.dt_baja = '0000-00-00' AND I.dt_alta < '2021-01-01'))


#######################################Confirmación o rechazo de altas, bajas y cambios durante el año##################################################
SELECT DISTINCT cyt_integrante_estado.integrante_oid 
FROM `cyt_integrante_estado` INNER JOIN cyt_user ON cyt_integrante_estado.user_oid = cyt_user.oid
INNER JOIN cyt_user_usergroup ON cyt_user.oid = cyt_user_usergroup.user_oid

WHERE `fechaDesde` >= '2018-01-01' AND `fechaDesde` < '2019-01-01' AND (cyt_user_usergroup.usergroup_oid = 14 OR cyt_user_usergroup.usergroup_oid = 1)

#######################################Con proyectos en ejecución sin scholar##################################################
SELECT D.* FROM docente D
WHERE D.cd_universidad IN (11,0) AND EXISTS (SELECT I.cd_docente FROM integrante I INNER JOIN proyecto P ON I.cd_proyecto = P.cd_proyecto 
WHERE P.dt_fin > '2019-01-01' AND (I.dt_baja IS NULL OR I.dt_baja = '0000-00-00' OR I.dt_baja > '2019-01-01') 
AND I.cd_docente = D.cd_docente) AND NOT EXISTS (SELECT `google_scholar_con_dni`.dni FROM `google_scholar_con_dni` 
WHERE `google_scholar_con_dni`.dni = D.nu_documento)

#######################################Directores de 2 proyectos en ejecución##################################################
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


#######################################Director e integrate en 2 proyectos en ejecución  ##################################################
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

#######################################Director y codirector de 2 proyectos en ejecución##################################################
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

####################################### CATEGORIZADOS II que NO son profesores ############################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Investigador, D.nu_documento, CA.ds_categoria, F.ds_facultad, CONCAT(C.ds_cargo,' - ', DED.ds_deddoc) as Cargo, CONCAT (CAR.ds_carrerainv,' - ', O.ds_codigo) as Carrera 
FROM docente D 
LEFT JOIN categoria CA ON D.cd_categoria = CA.cd_categoria
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad 
LEFT JOIN cargo C ON D.cd_cargo = C.cd_cargo
LEFT JOIN deddoc DED ON D.cd_deddoc = DED.cd_deddoc
LEFT JOIN carrerainv CAR ON D.cd_carrerainv = CAR.cd_carrerainv
LEFT JOIN organismo O ON D.cd_organismo = O.cd_organismo
WHERE ( D.cd_universidad IS NULL OR D.cd_universidad IN (0,11)) AND D.cd_categoria IN (7) AND C.cd_cargo NOT IN (1,2,3,7,8,9)

####################################### CATEGORIZADOS III con Carrera ############################################################

SELECT CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Investigador, D.nu_documento, CA.ds_categoria, F.ds_facultad, CONCAT(C.ds_cargo,' - ', DED.ds_deddoc) as Cargo, CONCAT (CAR.ds_carrerainv,' - ', O.ds_codigo) as Carrera 
FROM docente D 
LEFT JOIN categoria CA ON D.cd_categoria = CA.cd_categoria
LEFT JOIN facultad F ON D.cd_facultad = F.cd_facultad 
LEFT JOIN cargo C ON D.cd_cargo = C.cd_cargo
LEFT JOIN deddoc DED ON D.cd_deddoc = DED.cd_deddoc
LEFT JOIN carrerainv CAR ON D.cd_carrerainv = CAR.cd_carrerainv
LEFT JOIN organismo O ON D.cd_organismo = O.cd_organismo
WHERE ( D.cd_universidad IS NULL OR D.cd_universidad IN (0,11)) AND D.cd_categoria IN (8) AND CAR.cd_carrerainv IN (1,2,3,4,5,6,8,9,12,13)

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

####################################### Investigadores con cargo que no están en alfabético ############################################################
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


####################################### Prorrogar proyectos en ejecuci�n ############################################################

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

####################################### Prorrogar proyectos en ejecuci�n con ds_codigo############################################################

UPDATE 
`proyecto` 
INNER JOIN integrante ON proyecto.cd_proyecto = integrante.cd_proyecto
INNER JOIN cyt_integrante_estado ON integrante.oid = cyt_integrante_estado.integrante_oid AND cyt_integrante_estado.fechaHasta is null and cyt_integrante_estado.tipoInvestigador_oid=1 
SET  proyecto.dt_fin = DATE(DATE_ADD(proyecto.dt_fin, INTERVAL 1 YEAR)), cyt_integrante_estado.motivo = CONCAT(motivo, '.\r\nProyecto prorrogado por pandemia el ',now())
WHERE proyecto.ds_codigo in ('11/I226','11/I227','11/I228','11/X768','11/X769','11/X775','11/X778','11/X779','11/X780','11/X781','11/X784','11/X786','11/X787','11/X789','11/X794','11/X795','11/X799','11/H809','11/H810','11/H814','11/H816','11/H817','11/H818','11/H819','11/H820','11/H822','11/H824','11/H826','11/H827','11/H829','11/H830','11/H832','11/B327','11/G148','11/G148','11/G150','11/G151','11/G148','11/S049','11/S050','11/P276','11/P279','11/P282','11/P283','11/P284','11/N828','11/N830','11/N831','11/N832','11/N833','11/N835','11/T083','11/O118','11/O120','11/O121','11/O125','11/A332','11/A333','11/X858','11/X859','11/X861','11/X864','11/X865','11/X890','11/E171','11/E172','11/E173','11/E174','11/E175','11/E178','11/V268','11/V275','11/B359','11/B360','11/B361','11/B362','11/B363','11/B364','11/B366','11/B371','11/U178','11/U180','11/H873','11/H875','11/H876','11/H877','11/H878','11/H879','11/H880','11/H902','11/H903','11/J170','11/J172','11/T097','11/T098','11/T100','11/T101','11/T106','11/T107','11/M216','11/M224','11/N887','11/N888','11/N889','11/N890','11/N892','11/N893','11/N895','11/P304','11/P305','11/P306','11/P307','11/P309','11/P310','11/P313','11/P314','11/O133','11/O134','11/O136','11/O141','11/O142','11/O144','11/S057','11/S059','11/S060','PPID/U010','PPID/B012','PPID/B014','PPID/B015','PPID/A010','PPID/A011','PPID/A012','PPID/J002','PPID/J003','PPID/X046','PPID/X048','PPID/N033','PPID/I011','PPID/I012','PPID/H051','PPID/H052','PPID/H053','PPID/H054','PPID/H056','PPID/H058','PPID/H059','PPID/H060','PPID/H061','PPID/H062','PPID/P024','PPID/P025','PPID/P026','PPID/S027') AND cyt_integrante_estado.motivo IS NOT NULL;

UPDATE 
`proyecto` 
INNER JOIN integrante ON proyecto.cd_proyecto = integrante.cd_proyecto
INNER JOIN cyt_integrante_estado ON integrante.oid = cyt_integrante_estado.integrante_oid AND cyt_integrante_estado.fechaHasta is null and cyt_integrante_estado.tipoInvestigador_oid=1 
SET  proyecto.dt_fin = DATE(DATE_ADD(proyecto.dt_fin, INTERVAL 1 YEAR)), cyt_integrante_estado.motivo = CONCAT('Proyecto prorrogado por pandemia el ',now())
WHERE proyecto.ds_codigo in ('11/I226','11/I227','11/I228','11/X768','11/X769','11/X775','11/X778','11/X779','11/X780','11/X781','11/X784','11/X786','11/X787','11/X789','11/X794','11/X795','11/X799','11/H809','11/H810','11/H814','11/H816','11/H817','11/H818','11/H819','11/H820','11/H822','11/H824','11/H826','11/H827','11/H829','11/H830','11/H832','11/B327','11/G148','11/G148','11/G150','11/G151','11/G148','11/S049','11/S050','11/P276','11/P279','11/P282','11/P283','11/P284','11/N828','11/N830','11/N831','11/N832','11/N833','11/N835','11/T083','11/O118','11/O120','11/O121','11/O125','11/A332','11/A333','11/X858','11/X859','11/X861','11/X864','11/X865','11/X890','11/E171','11/E172','11/E173','11/E174','11/E175','11/E178','11/V268','11/V275','11/B359','11/B360','11/B361','11/B362','11/B363','11/B364','11/B366','11/B371','11/U178','11/U180','11/H873','11/H875','11/H876','11/H877','11/H878','11/H879','11/H880','11/H902','11/H903','11/J170','11/J172','11/T097','11/T098','11/T100','11/T101','11/T106','11/T107','11/M216','11/M224','11/N887','11/N888','11/N889','11/N890','11/N892','11/N893','11/N895','11/P304','11/P305','11/P306','11/P307','11/P309','11/P310','11/P313','11/P314','11/O133','11/O134','11/O136','11/O141','11/O142','11/O144','11/S057','11/S059','11/S060','PPID/U010','PPID/B012','PPID/B014','PPID/B015','PPID/A010','PPID/A011','PPID/A012','PPID/J002','PPID/J003','PPID/X046','PPID/X048','PPID/N033','PPID/I011','PPID/I012','PPID/H051','PPID/H052','PPID/H053','PPID/H054','PPID/H056','PPID/H058','PPID/H059','PPID/H060','PPID/H061','PPID/H062','PPID/P024','PPID/P025','PPID/P026','PPID/S027') AND cyt_integrante_estado.motivo IS NULL;


####################################### DESProrrogar proyectos en ejecuci�n con ds_codigo############################################################

UPDATE 
`proyecto` 
INNER JOIN integrante ON proyecto.cd_proyecto = integrante.cd_proyecto
INNER JOIN cyt_integrante_estado ON integrante.oid = cyt_integrante_estado.integrante_oid AND cyt_integrante_estado.fechaHasta is null and cyt_integrante_estado.tipoInvestigador_oid=1 
SET  proyecto.dt_fin = DATE(DATE_ADD(proyecto.dt_fin, INTERVAL -1 YEAR)), cyt_integrante_estado.motivo = CONCAT(motivo, '.\r\nProyecto se le quit� un a�o (error al dar pr�rroga por pandemia ',now())
WHERE proyecto.ds_codigo in ('11/X809','11/X810','11/X814','11/X816','11/X817','11/X818','11/X819','11/X820','11/X822','11/X824','11/X826','11/X827','11/X829','11/X830','11/X832') AND cyt_integrante_estado.motivo IS NOT NULL;


########################################## Informes para liquidaciones (cat distintas y dem�s) ########################################################

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
SELECT becas_unlp_nuevas.*, beca.* FROM `becas_unlp_nuevas`
INNER JOIN docente ON becas_unlp_nuevas.nu_documento = docente.nu_documento
INNER JOIN beca ON docente.cd_docente = beca.cd_docente
WHERE becas_unlp_nuevas.ds_tipobeca = beca.ds_tipobeca AND (becas_unlp_nuevas.dt_desde != beca.dt_desde OR becas_unlp_nuevas.dt_hasta != beca.dt_hasta);

##inserto las nuevas del a�o
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
SELECT B.cd_beca, CONCAT(D.ds_apellido,', ',D.ds_nombre) AS Docente, CONCAT(D.nu_precuil,'-',D.nu_documento,'-',D.nu_postcuil) AS CUIL, B.`ds_tipobeca`,`dt_desde`,`dt_hasta` FROM `beca` B INNER JOIN docente D ON B.cd_docente = D.cd_docente WHERE bl_unlp = 1 AND dt_hasta >= '2022-01-01' AND NOT EXISTS (SELECT becas_unlp_nuevas.nu_documento FROM `becas_unlp_nuevas` WHERE becas_unlp_nuevas.nu_documento = D.nu_documento)
ORDER BY ds_apellido, ds_nombre


########################################Integrantes alumnos sin EVC ################################################################

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




WHERE P.cd_estado = 5 AND dt_ini < '2022-01-01' AND dt_fin >= '2021-01-01' AND I.bl_becaEstimulo =0 AND (I.bl_estudiante =1 OR I.nu_materias !=0)  AND (I.dt_alta != I.dt_baja OR I.dt_baja IS NULL) AND (I.dt_baja > '2020-12-31' OR I.dt_baja IS NULL) AND (I.cd_cargo = 6 or I.cd_cargo is null) AND I.dt_alta < '2022-01-01'
ORDER BY D.ds_apellido, D.ds_nombre

########################################Integrantes con EVC ################################################################

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




WHERE P.cd_estado = 5 AND dt_ini < '2022-01-01' AND dt_fin >= '2021-01-01' AND I.bl_becaEstimulo =1 AND (I.dt_alta != I.dt_baja OR I.dt_baja IS NULL) AND (I.dt_baja > '2020-12-31' OR I.dt_baja IS NULL) AND I.dt_alta < '2022-01-01'
ORDER BY D.ds_apellido, D.ds_nombre

#############################################ACTUALIZAR LAS DISCIPLINAS EN BANCO EVALUADORES############################
CREATE TABLE `experticia_sigeva` (

`apellido` VARCHAR(254) NULL,
`nombre` VARCHAR(254) NULL,
`documento` VARCHAR(255) NULL,
`cuil` VARCHAR(255) NULL,
`resumen` text NULL,
`area1` VARCHAR(255) NULL,
`area2` VARCHAR(255) NULL,
`linea` VARCHAR(255) NULL)
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE TABLE `disciplina_sigeva` (

`apellido` VARCHAR(254) NULL,
`nombre` VARCHAR(254) NULL,
`documento` VARCHAR(255) NULL,
`cuil` VARCHAR(255) NULL,
`area` VARCHAR(255) NULL,
`disciplina1` VARCHAR(255) NULL,
`disciplina2` VARCHAR(255) NULL,
`desagregada` VARCHAR(255) NULL,
`campo` VARCHAR(255) NULL,
`especialidad` VARCHAR(255) NULL)
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE TABLE `evaluadores_unlp` (

`apellido` VARCHAR(254) NULL,
`nombre` VARCHAR(254) NULL,
`cuil` VARCHAR(255) NULL,
`documento` VARCHAR(255) NULL,

`facultad` VARCHAR(255) NULL)
ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_spanish_ci;

SELECT evaluadores_unlp.*, group_concat(disciplina_sigeva.area separator ' - ') as `Gran_Area`, group_concat(disciplina_sigeva.disciplina1 separator ' - ') as `Disciplina_Primaria`, group_concat(disciplina_sigeva.disciplina2 separator ' - ') as `Disciplina_Secundaria`, group_concat(disciplina_sigeva.desagregada separator ' - ') as `Disciplina_Desagregada`, group_concat(disciplina_sigeva.campo separator ' - ') as `Campo_Aplicacion`, group_concat(disciplina_sigeva.especialidad separator ' - ') as `Especialidad`, group_concat(experticia_sigeva.resumen separator ' - ') as `Experticia`, group_concat(experticia_sigeva.area1 separator ' - ') as `Area_Actuacion_1`, group_concat(experticia_sigeva.area2 separator ' - ') as `Area_Actuacion_2`, group_concat(experticia_sigeva.linea separator ' - ') as `Linea_Investigacion`
FROM `evaluadores_unlp` LEFT JOIN experticia_sigeva ON evaluadores_unlp.documento = experticia_sigeva.documento
LEFT JOIN disciplina_sigeva ON evaluadores_unlp.documento = disciplina_sigeva.documento
GROUP BY evaluadores_unlp.documento
ORDER BY evaluadores_unlp.facultad, evaluadores_unlp.investigador


################################## Usuarios de las Secretar�as ######################################################

######WEBPROYECTOS
SELECT `ds_username`, `ds_name`, `ds_email`, facultad.ds_facultad 
FROM `cyt_user` INNER JOIN cyt_user_usergroup ON cyt_user.oid = cyt_user_usergroup.user_oid 
INNER JOIN facultad ON cyt_user.facultad_oid = facultad.cd_facultad 
WHERE cyt_user_usergroup.usergroup_oid = 13 
ORDER BY `facultad`.`ds_facultad` ASC 

######WEBVIAJES - WEBJOVENES
SELECT `ds_username`, `ds_name`, `ds_email`, facultad.ds_facultad 
FROM `cyt_user` INNER JOIN cyt_user_usergroup ON cyt_user.oid = cyt_user_usergroup.user_oid 
INNER JOIN facultad ON cyt_user.facultad_oid = facultad.cd_facultad 
WHERE cyt_user_usergroup.usergroup_oid = 9
ORDER BY `facultad`.`ds_facultad` ASC 

#################################### Pierden la cat por no presentarse en 2014 ######################################
SELECT CONCAT(LPAD(aux_obligados_cat_2014.nu_precuil,2,0),'-',LPAD(aux_obligados_cat_2014.nu_documento,8,'0'),'-',LPAD(aux_obligados_cat_2014.nu_postcuil,1,0)) AS CUIL, aux_obligados_cat_2014.ds_investigador, categoria.ds_categoria, facultad.ds_facultad 
FROM `aux_obligados_cat_2014` 
LEFT JOIN docente ON aux_obligados_cat_2014.nu_documento = docente.nu_documento
INNER JOIN categoria ON docente.cd_categoria = categoria.cd_categoria
INNER JOIN facultad ON docente.cd_facultad = facultad.cd_facultad
WHERE NOT EXISTS (SELECT aux_cat_2014.nu_documento FROM aux_cat_2014 WHERE aux_cat_2014.nu_documento = aux_obligados_cat_2014.nu_documento)
ORDER BY facultad.ds_facultad, aux_obligados_cat_2014.ds_investigador

#################################### Obligados a Categorizarse en 2023 ######################################
SELECT CONCAT(LPAD(docente.nu_precuil,2,0),'-',LPAD(docente.nu_documento,8,'0'),'-',LPAD(docente.nu_postcuil,1,0)) AS CUIL, CONCAT(auxiliar.apellido,',',auxiliar.nombre) AS Investigador, categoria.ds_categoria, facultad.ds_facultad 
FROM `auxiliar` 
LEFT JOIN docente ON auxiliar.nu_documento = docente.nu_documento
INNER JOIN categoria ON docente.cd_categoria = categoria.cd_categoria
INNER JOIN facultad ON docente.cd_facultad = facultad.cd_facultad
WHERE NOT EXISTS (SELECT aux_cat_2014.nu_documento FROM aux_cat_2014 WHERE aux_cat_2014.nu_documento = auxiliar.nu_documento)
ORDER BY facultad.ds_facultad, auxiliar.apellid,auxiliar.nombre

