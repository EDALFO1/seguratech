-- ========================================
-- SCRIPT SQL PARA PRODUCCIÓN
-- Módulo: Recibos de Afiliación
-- Fecha: 2026-06-23
-- ========================================

-- 1. CREAR TABLA recibos_afiliacion
-- ========================================
CREATE TABLE IF NOT EXISTS `recibos_afiliacion` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint unsigned NOT NULL,
  `numero` int unsigned NOT NULL,
  `afiliado_id` bigint unsigned NOT NULL,
  `fecha` date NOT NULL,
  `concepto` varchar(500) NOT NULL,
  `valor` decimal(12,2) NOT NULL,
  `estado_pago` enum('pendiente','pagado') NOT NULL DEFAULT 'pendiente',
  `fecha_pago` date NULL,
  `notas` longtext NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `recibos_afiliacion_empresa_id_numero_unique` (`empresa_id`,`numero`),
  FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`afiliado_id`) REFERENCES `afiliados` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2. INSERTAR MÓDULO recibos_afiliacion en tabla modulos
-- ========================================
INSERT INTO `modulos` (`slug`, `nombre`, `descripcion`, `grupo`, `orden`, `activo`, `created_at`, `updated_at`)
VALUES (
  'recibos_afiliacion',
  'Recibos de Afiliación',
  NULL,
  'operativo',
  3,
  1,
  NOW(),
  NOW()
)
ON DUPLICATE KEY UPDATE
  `nombre` = 'Recibos de Afiliación',
  `grupo` = 'operativo',
  `orden` = 3,
  `activo` = 1,
  `updated_at` = NOW();


-- 3. ASIGNAR MÓDULO recibos_afiliacion A LOS ROLES
-- Admin, Asesor, Invitado (mismo acceso que "recibos")
-- ========================================
-- Obtener IDs de módulo y roles
SET @modulo_id = (SELECT `id` FROM `modulos` WHERE `slug` = 'recibos_afiliacion');
SET @admin_id = (SELECT `id` FROM `roles` WHERE `nombre` = 'admin');
SET @asesor_id = (SELECT `id` FROM `roles` WHERE `nombre` = 'asesor');
SET @invitado_id = (SELECT `id` FROM `roles` WHERE `nombre` = 'invitado');

-- Insertar si no existen
INSERT INTO `rol_modulo` (`rol_id`, `modulo_id`, `created_at`, `updated_at`)
VALUES
  (@admin_id, @modulo_id, NOW(), NOW()),
  (@asesor_id, @modulo_id, NOW(), NOW()),
  (@invitado_id, @modulo_id, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `updated_at` = NOW();


-- 4. ASIGNAR MÓDULO recibos_afiliacion A TODAS LAS EMPRESAS
-- ========================================
INSERT INTO `empresa_modulo` (`empresa_id`, `modulo_id`, `created_at`, `updated_at`)
SELECT e.`id`, @modulo_id, NOW(), NOW()
FROM `empresas` e
WHERE NOT EXISTS (
  SELECT 1 FROM `empresa_modulo` em
  WHERE em.`empresa_id` = e.`id`
    AND em.`modulo_id` = @modulo_id
)
ON DUPLICATE KEY UPDATE
  `updated_at` = NOW();


-- ========================================
-- VERIFICACIÓN - ejecuta esto para confirmar:
-- ========================================
-- SELECT * FROM `modulos` WHERE `slug` = 'recibos_afiliacion';
-- SELECT * FROM `recibos_afiliacion` LIMIT 1;
-- SELECT COUNT(*) as total_empresas_con_modulo FROM `empresa_modulo` WHERE `modulo_id` = (SELECT `id` FROM `modulos` WHERE `slug` = 'recibos_afiliacion');
