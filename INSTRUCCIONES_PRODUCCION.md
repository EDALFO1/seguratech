# 📋 Instrucciones para Ejecutar Recibos de Afiliación en Producción

## Prerequisitos
- Acceso al panel de control del hosting (cPanel, Plesk, etc.)
- Acceso a phpMyAdmin o herramienta similar de SQL
- Credenciales de la base de datos de producción

---

## Opción 1: Usar phpMyAdmin (Recomendado)

### Pasos:

1. **Accede a phpMyAdmin**
   - Abre tu panel de control (cPanel/Plesk)
   - Busca "phpMyAdmin" o accede directamente a `https://tudominio.com/phpmyadmin`
   - Login con tus credenciales

2. **Selecciona tu base de datos**
   - En el panel izquierdo, selecciona la BD de tu app (ej: `seguratech`)

3. **Abre la pestaña SQL**
   - Haz clic en la pestaña "SQL" en la parte superior

4. **Copia y pega el script**
   - Abre el archivo: `SQL_PRODUCCION_RECIBOS_AFILIACION.sql`
   - Copia TODO el contenido (desde `-- 1. CREAR TABLA...` hasta el final)
   - Pégalo en el campo de SQL de phpMyAdmin

5. **Ejecuta el script**
   - Haz clic en el botón **"Ejecutar"** o **"Go"**
   - Deberías ver mensajes de confirmación de que se creó la tabla y se insertaron los datos

6. **Verifica**
   - Ve a la pestaña "Bases de datos" 
   - Busca la tabla `recibos_afiliacion`
   - Verifica que aparece en la lista

---

## Opción 2: Usar MySQL/MariaDB desde Terminal (si tienes acceso)

Si tienes acceso por SSH o línea de comandos:

```bash
mysql -h localhost -u usuario -pcontraseña nombre_bd < SQL_PRODUCCION_RECIBOS_AFILIACION.sql
```

Reemplaza:
- `usuario` → tu usuario de BD
- `contraseña` → tu contraseña de BD
- `nombre_bd` → nombre de tu base de datos

---

## Opción 3: Ejecutar por Partes

Si phpMyAdmin tiene límite de tamaño, ejecuta por partes:

### Parte 1: Crear tabla
```sql
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
```

### Parte 2: Insertar módulo
```sql
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
```

### Parte 3: Asignar a roles
```sql
SET @modulo_id = (SELECT `id` FROM `modulos` WHERE `slug` = 'recibos_afiliacion');
SET @admin_id = (SELECT `id` FROM `roles` WHERE `nombre` = 'admin');
SET @asesor_id = (SELECT `id` FROM `roles` WHERE `nombre` = 'asesor');
SET @invitado_id = (SELECT `id` FROM `roles` WHERE `nombre` = 'invitado');

INSERT INTO `rol_modulo` (`rol_id`, `modulo_id`, `created_at`, `updated_at`)
VALUES
  (@admin_id, @modulo_id, NOW(), NOW()),
  (@asesor_id, @modulo_id, NOW(), NOW()),
  (@invitado_id, @modulo_id, NOW(), NOW())
ON DUPLICATE KEY UPDATE
  `updated_at` = NOW();
```

### Parte 4: Asignar a empresas
```sql
SET @modulo_id = (SELECT `id` FROM `modulos` WHERE `slug` = 'recibos_afiliacion');

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
```

---

## ✅ Verificación

Después de ejecutar, verifica que todo está bien:

```sql
-- Verificar tabla creada
SELECT * FROM `modulos` WHERE `slug` = 'recibos_afiliacion';

-- Verificar estructura tabla
DESCRIBE `recibos_afiliacion`;

-- Verificar roles asignados
SELECT r.nombre, COUNT(rm.modulo_id) as modulos
FROM roles r
LEFT JOIN rol_modulo rm ON r.id = rm.rol_id
WHERE r.nombre IN ('admin', 'asesor', 'invitado')
GROUP BY r.id;

-- Verificar empresas asignadas
SELECT COUNT(*) as total_empresas_con_modulo 
FROM `empresa_modulo` 
WHERE `modulo_id` = (SELECT `id` FROM `modulos` WHERE `slug` = 'recibos_afiliacion');
```

---

## 🚀 Después de Ejecutar

1. **Recarga la aplicación** en navegador
2. **Limpia cache** si es necesario (CTRL+SHIFT+DEL en navegador)
3. **Verifica en el menú** que aparece "Recibos de Afiliación" bajo Facturación
4. **Prueba crear un recibo** de afiliación

---

## ⚠️ Notas Importantes

- Este script es **idempotente** (seguro ejecutar varias veces)
- Usa `INSERT ... ON DUPLICATE KEY UPDATE` para evitar duplicados
- Las foreignkeys aseguran la integridad referencial
- Si algo falla, revisa los permisos de usuario en BD
- Mantén una copia de seguridad antes de ejecutar en producción

---

## 📧 Si Tienes Problemas

- Verifica que existen las tablas: `empresas`, `afiliados`, `roles`, `modulos`
- Confirma que el usuario de BD tiene permisos de CREATE, INSERT
- Si hay error de foreign key, asegúrate de que empresas y afiliados existen

