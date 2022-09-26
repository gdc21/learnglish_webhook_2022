<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00046.php';
class EstadisticasCliente extends UniversalDatabase {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00046 ();
	}

    ##################################################
    #Retorna id, nombre y tiempo en minutos por niveles en perfiles, niveles y fechas especificas
    ##################################################
    public function tiempo_por_niveles($perfiles, $niveles, $fecha_ini, $fecha_fin){
        $this->query = "	
            SELECT DISTINCT
                ( niveles.LGF0140002 ) AS nivel,
                niveles.LGF0140001 AS id_nivel,
                ifnull( SUM( TIMESTAMPDIFF( MINUTE, log_session.lgf0360004, log_session.lgf0360005 )), 0 ) AS tiempo
            FROM
                lg00030 AS rel_inst_modulos,
                lg00027 AS instituciones,
                lg00014 AS niveles,
                lg00015 AS modulos,
                lg00036 AS log_session,
                lg00001 as usuarios 
            WHERE
                instituciones.LGF0270001 = rel_inst_modulos.LGF0300002 
                AND modulos.LGF0150004 = niveles.LGF0140001 
                AND rel_inst_modulos.LGF0300003 = modulos.LGF0150001 
                and usuarios.LGF0010001 = log_session.LGF0360002
                
                and usuarios.LGF0010023 = niveles.LGF0140001
                and usuarios.LGF0010024 = rel_inst_modulos.LGF0300003
                and usuarios.LGF0010038 = instituciones.LGF0270001
                
                and usuarios.LGF0010007 in ($perfiles)
                and niveles.LGF0140001 in ($niveles)
                
                AND instituciones.LGF0270013 BETWEEN TIMESTAMP ( '$fecha_ini' ) AND DATE_ADD(TIMESTAMP ( '$fecha_fin' ),INTERVAL '1439:59' MINUTE_SECOND) 
                and log_session.LGF0360004 BETWEEN TIMESTAMP ('$fecha_ini') AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )  
                AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )  
            GROUP BY nivel";

        return $this->doSelect();
    }


    ##################################################
    #Retorna id, nombre y tiempo en minutos(personas_act_inac) agrupados por institucion por perfiles, fechas y si
    # han o no estado activos ($activos)
    ##################################################
    public function tiempo_por_institucion_activos_inactivos($perfil, $activos, $fecha_ini, $fecha_fin){
        if($activos){
            $this->query = "select 
                    LGF0270001 AS id,
                    LGF0270002 AS nombre,
                    count(DISTINCT(log_session.LGF0360002)) as personas_act_inac
                from lg00027 AS instituciones, lg00036 AS log_session, lg00001 as usuarios 
                where
                    instituciones.LGF0270001 = usuarios.LGF0010038
                    and log_session.LGF0360002 = usuarios.LGF0010001 
                    and log_session.LGF0360002  in (
                        SELECT DISTINCT(usuarios.LGF0010001) 
                            FROM
                                lg00036 AS log_session, lg00001 AS usuarios 
                            WHERE
                                usuarios.LGF0010007 in ($perfil)
                                AND usuarios.LGF0010001 = log_session.LGF0360002 										
                                AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                                AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
                                AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                                AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )  
                    ) 
                    GROUP BY
                    instituciones.LGF0270002;";
        }else{
            $this->query = "SELECT
                    LGF0270001 AS id,
                    LGF0270002 AS nombre,
                    count(DISTINCT ( usuarios.LGF0010001 )) total_registrados
                FROM
                    lg00001 AS usuarios,
                    lg00027 AS instituciones
                WHERE
                    instituciones.LGF0270001 = usuarios.LGF0010038 
                    and usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND ) 
                    AND LGF0010007 IN ($perfil)
                    GROUP BY id";

        }

        return $this->doSelect();
    }
    public function tiempo_por_institucion($perfil, $fecha_ini, $fecha_fin){
        $this->query = "SELECT 
            LGF0270001 as id,
            LGF0270002 as nombre,
            LGF0270028 as cct,
            ifnull( SUM( TIMESTAMPDIFF( MINUTE, log_session.lgf0360004, log_session.lgf0360005 )), 0 ) AS tiempo
            from lg00036 as log_session, lg00027 AS instituciones, (
                SELECT
                    usuarios.LGF0010001 as id_usuario,
                    LGF0010038 as id_inst
                FROM
                    lg00001 AS usuarios
                WHERE
                    LGF0010007 IN ( $perfil ) 
                    AND LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND ) 
            ) as usuarios 
            where usuarios.id_usuario = log_session.LGF0360002 and usuarios.id_inst = instituciones.LGF0270001
                AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
            GROUP BY instituciones.LGF0270002";

        return $this->doSelect();
    }

    public function tiempo_conexion_acumulado($perfil, $fecha_ini, $fecha_fin, $nivel = '', $cct = ''){
        $complementoNivel = '';

        $complementoCCT1   = '';
        $complementoCCT2   = '';

        if($nivel != ''){
            $complementoNivel = " AND LGF0010023 = $nivel ";
        }
        if($cct != ''){
            $complementoCCT1   = ", lg00027 AS instituciones ";
            $complementoCCT2   = " AND instituciones.LGF0270001 = $cct AND instituciones.LGF0270001 = usuarios.LGF0010038 ";
        }

        $this->query = "SELECT ifnull(SUM(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005)), 0) AS tiempo 
           FROM lg00036 AS log_session WHERE log_session.LGF0360002 
           IN (
                SELECT LGF0010001 
                FROM lg00001 AS usuarios      $complementoCCT1
                WHERE LGF0010007 IN ($perfil) $complementoCCT2
                $complementoNivel
                AND LGF0010030
                BETWEEN TIMESTAMP('$fecha_ini') 
                AND DATE_ADD(TIMESTAMP('$fecha_fin'), INTERVAL '1439:59' MINUTE_SECOND) 
           ) AND log_session.LGF0360004
            BETWEEN TIMESTAMP('$fecha_ini') 
            AND DATE_ADD(TIMESTAMP('$fecha_fin'), INTERVAL '1439:59' MINUTE_SECOND) ";

        return $this->doSelect();
    }

    public function escuelas_beneficiadas_lista($fecha_ini, $fecha_fin){
        $this->query = "SELECT distinct(instituciones.LGF0270001) as id, instituciones.LGF0270002 as escuela, instituciones.LGF0270028 AS cct 
            FROM lg00030 AS rel_inst_modulos, lg00027 AS instituciones 
            WHERE instituciones.LGF0270001 = rel_inst_modulos.LGF0300002 
            and instituciones.LGF0270013 
            BETWEEN TIMESTAMP('$fecha_ini') 
            AND DATE_ADD(TIMESTAMP('$fecha_fin'), INTERVAL '1439:59' MINUTE_SECOND) ";

        return $this->doSelect();
    }

    public function niveles_beneficiados($fecha_ini, $fecha_fin){
        $this->query = "SELECT distinct(niveles.LGF0140002) as nivel, niveles.LGF0140001 as id 
            FROM lg00030 AS rel_inst_modulos, lg00027 AS instituciones, lg00014 AS niveles, lg00015 AS modulos
            WHERE 
            instituciones.LGF0270001 = rel_inst_modulos.LGF0300002 
            AND modulos.LGF0150004 = niveles.LGF0140001
            AND rel_inst_modulos.LGF0300003 = modulos.LGF0150001
            and instituciones.LGF0270013 BETWEEN TIMESTAMP('$fecha_ini') 
            AND DATE_ADD(TIMESTAMP('$fecha_fin'), INTERVAL '1439:59' MINUTE_SECOND)";

        return $this->doSelect();
    }

    public function escuelas_beneficiadas($fecha_ini, $fecha_fin){
        $this->query = "SELECT 
            (
                SELECT COUNT(distinct(rel_inst_modulos.LGF0300002)) AS total_escuelas
                FROM lg00030 AS rel_inst_modulos, lg00027 AS instituciones
                WHERE instituciones.LGF0270001 = rel_inst_modulos.LGF0300002
                and rel_inst_modulos.LGF0300003 IN (1) 
                and instituciones.LGF0270013 BETWEEN 
                    TIMESTAMP('$fecha_ini') AND 
                    DATE_ADD(TIMESTAMP('$fecha_fin'), INTERVAL '1439:59' MINUTE_SECOND)
            ) AS pre,
            (
                SELECT COUNT(distinct(rel_inst_modulos.LGF0300002)) AS total_escuelas
                FROM lg00030 AS rel_inst_modulos, lg00027 AS instituciones
                WHERE instituciones.LGF0270001 = rel_inst_modulos.LGF0300002
                and rel_inst_modulos.LGF0300003 IN (2,3,4,5,6,7)
                and instituciones.LGF0270013 BETWEEN 
                    TIMESTAMP('$fecha_ini') AND 
                    DATE_ADD(TIMESTAMP('$fecha_fin'), INTERVAL '1439:59' MINUTE_SECOND)
            ) AS pri,
            (
                SELECT COUNT(distinct(rel_inst_modulos.LGF0300002)) AS total_escuelas
                FROM lg00030 AS rel_inst_modulos, lg00027 AS instituciones
                WHERE instituciones.LGF0270001 = rel_inst_modulos.LGF0300002
                and rel_inst_modulos.LGF0300003 IN (8,9,10)  
                and instituciones.LGF0270013 BETWEEN 
                    TIMESTAMP('$fecha_ini') AND 
                    DATE_ADD(TIMESTAMP('$fecha_fin'), INTERVAL '1439:59' MINUTE_SECOND)
            ) AS sec";

        return $this->doSelect();
    }

    public function estadisticasPorFecha_Alm_Doc($perfil, $fecha_ini, $fecha_fin){
        #Si son docentes buscamos el nivel segun la institucion perteneciente
        #nivel 1 = modulos 1
        #nivel 2 = modulos 2,3,4,5,6,7
        #nivel 3 = modulos 8,9,10
        if($perfil == 6){
            $niveles1 = " LGF0010038 in (select LGF0300002 from lg00030 where LGF0300003 in (1)) ";
            $niveles2 = " LGF0010038 in (select LGF0300002 from lg00030 where LGF0300003 in (2,3,4,5,6,7)) ";
            $niveles3 = " LGF0010038 in (select LGF0300002 from lg00030 where LGF0300003 in (8,.9,10)) ";
        }
        #Si son alumnos el nivel esta designado en la culumna 23
        elseif ($perfil == 2){
            $niveles1 = " LGF0010023 = 1 ";
            $niveles2 = " LGF0010023 = 2 ";
            $niveles3 = " LGF0010023 = 3 ";
        }
        $this->query = "SELECT 
            LGF0140002 AS nombre_nivel,
            
            (SELECT count(distinct(usuarios.LGF0010001)) FROM lg00001 AS usuarios
               WHERE usuarios.LGF0010030 BETWEEN TIMESTAMP('$fecha_ini') AND DATE_ADD(timestamp('$fecha_fin'), INTERVAL '1439:59' minute_second)  
               AND LGF0010007 = $perfil AND upper(LGF0010021) = 'H' AND $niveles1
            ) AS H_registrados,
            (SELECT count(distinct(usuarios.LGF0010001)) FROM lg00001 AS usuarios
               WHERE usuarios.LGF0010030 BETWEEN TIMESTAMP('$fecha_ini') AND DATE_ADD(timestamp('$fecha_fin'), INTERVAL '1439:59' minute_second)  
               AND LGF0010007 = $perfil AND upper(LGF0010021) = 'M' AND $niveles1
            ) AS M_registrados,
            (SELECT H_registrados + M_registrados) AS T_registrados,
            
            (SELECT COUNT( DISTINCT(usuarios.LGF0010001) ) 
                FROM
                    lg00036 AS log_session, lg00001 AS usuarios 
                WHERE
                    usuarios.LGF0010007 = $perfil 
                    AND usuarios.LGF0010001 = log_session.LGF0360002 
                    AND upper( usuarios.LGF0010021 ) = 'H' 
                    AND $niveles1
                    AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
                    AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
		            AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )  
            ) AS H_activos, 
            (SELECT COUNT( DISTINCT(usuarios.LGF0010001) ) 
                FROM
                    lg00036 AS log_session, lg00001 AS usuarios 
                WHERE
                    usuarios.LGF0010007 = $perfil 
                    AND usuarios.LGF0010001 = log_session.LGF0360002 
                    AND upper( usuarios.LGF0010021 ) = 'M' 
                    AND $niveles1
                    AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
                    AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
		            AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND ) 
            ) AS M_activos, 
            (SELECT H_activos + M_activos) AS T_activos
             
            FROM lg00014 WHERE LGF0140001 = 1 
                         UNION 
            SELECT 
            LGF0140002 AS nombre_nivel,
            
            (SELECT count(distinct(usuarios.LGF0010001)) FROM lg00001 AS usuarios
               WHERE usuarios.LGF0010030 BETWEEN TIMESTAMP('$fecha_ini') AND DATE_ADD(timestamp('$fecha_fin'), INTERVAL '1439:59' minute_second)  
               AND LGF0010007 = $perfil AND upper(LGF0010021) = 'H' AND $niveles2
            ) AS H_registrados,
            (SELECT count(distinct(usuarios.LGF0010001)) FROM lg00001 AS usuarios
               WHERE usuarios.LGF0010030 BETWEEN TIMESTAMP('$fecha_ini') AND DATE_ADD(timestamp('$fecha_fin'), INTERVAL '1439:59' minute_second)  
               AND LGF0010007 = $perfil AND upper(LGF0010021) = 'M' AND $niveles2
            ) AS M_registrados,
            (SELECT H_registrados + M_registrados) AS T_registrados,
            
            (SELECT COUNT( DISTINCT(usuarios.LGF0010001) ) 
                FROM
                    lg00036 AS log_session, lg00001 AS usuarios 
                WHERE
                    usuarios.LGF0010007 = $perfil 
                    AND usuarios.LGF0010001 = log_session.LGF0360002 
                    AND upper( usuarios.LGF0010021 ) = 'H' 
                    AND $niveles2
                    AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
                    AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
		            AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND ) 
            ) AS H_activos, 
            (SELECT COUNT( DISTINCT(usuarios.LGF0010001) ) 
                FROM
                    lg00036 AS log_session, lg00001 AS usuarios 
                WHERE
                    usuarios.LGF0010007 = $perfil 
                    AND usuarios.LGF0010001 = log_session.LGF0360002 
                    AND upper( usuarios.LGF0010021 ) = 'M' 
                    AND $niveles2
                    AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
                    AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
		            AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND ) 
            ) AS M_activos, 
            (SELECT H_activos + M_activos) AS T_activos
            
            FROM lg00014 WHERE LGF0140001 = 2 
                         UNION 
            SELECT 
            LGF0140002 AS nombre_nivel,
            
            (SELECT count(distinct(usuarios.LGF0010001)) FROM lg00001 AS usuarios
               WHERE usuarios.LGF0010030 BETWEEN TIMESTAMP('$fecha_ini') AND DATE_ADD(timestamp('$fecha_fin'), INTERVAL '1439:59' minute_second)  
               AND LGF0010007 = $perfil AND upper(LGF0010021) = 'H' AND $niveles3
            ) AS H_registrados,
            (SELECT count(distinct(usuarios.LGF0010001)) FROM lg00001 AS usuarios
               WHERE usuarios.LGF0010030 BETWEEN TIMESTAMP('$fecha_ini') AND DATE_ADD(timestamp('$fecha_fin'), INTERVAL '1439:59' minute_second)  
               AND LGF0010007 = $perfil AND upper(LGF0010021) = 'M' AND $niveles3
            ) AS M_registrados,
            (SELECT H_registrados + M_registrados) AS T_registrados,
            
            (SELECT COUNT( DISTINCT(usuarios.LGF0010001) ) 
                FROM
                    lg00036 AS log_session, lg00001 AS usuarios 
                WHERE
                    usuarios.LGF0010007 = $perfil 
                    AND usuarios.LGF0010001 = log_session.LGF0360002 
                    AND upper( usuarios.LGF0010021 ) = 'H' 
                    AND $niveles3
                    AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
                    AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
		            AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND ) 
            ) AS H_activos, 
            (SELECT COUNT( DISTINCT(usuarios.LGF0010001) ) 
                FROM
                    lg00036 AS log_session, lg00001 AS usuarios 
                WHERE
                    usuarios.LGF0010007 = $perfil 
                    AND usuarios.LGF0010001 = log_session.LGF0360002 
                    AND upper( usuarios.LGF0010021 ) = 'M' 
                    AND $niveles3
                    AND log_session.LGF0360004 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
                    AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND )
                    AND usuarios.LGF0010030 BETWEEN TIMESTAMP ( '$fecha_ini' ) 
		            AND DATE_ADD( TIMESTAMP ( '$fecha_fin' ), INTERVAL '1439:59' MINUTE_SECOND ) 
            ) AS M_activos, 
            (SELECT H_activos + M_activos) AS T_activos
             
            FROM lg00014 WHERE LGF0140001 = 3;";

        return $this->doSelect();
    }

	public function actualizarEstadisticasCliente($lg00001a, $lg00001b) {
		return $this->crud->update ( $lg00001a, $lg00001b );
	}

	public function crearEstadisticasCliente($lg00046) {
		return $this->crud->create ( $lg00046 );
	}

    public function obtenerEstadisticasCliente($lg00046="",$total=false) {
        return $this->crud->read($lg00046,$total);
    }

	public function leerEstadisticasCliente($id_registro) {
        $this->query = "SELECT lg00046.*,LGF0280002 
            from lg00046, lg00028 as clientes 
            where LGF0460001 = $id_registro 
            AND LGF0460002 = clientes.LGF0280001";
		return $this->doSelect();
	}

	public function eliminaEstadisticasCliente($lg00046) {
		return $this->crud->delete ( $lg00046 );
	}

}