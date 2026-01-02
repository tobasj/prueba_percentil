# Valuation Estimator (Symfony 4 / PHP 7.4)

## Prerrequisitos
- PHP 7.4
- Composer 2
- Node 16 (solo si ejecutas el frontend SSR aparte)
- Extensiones PHP: ctype, iconv

## Instalación
1) cd backend
2) composer install

## Ejecución API (dev)
1) cd backend
2) php -S 127.0.0.1:8000 -t public
   endpoint: http://127.0.0.1:8000/api/v1/valuation/estimate

## CORS
Permitido origen http://localhost:5173 para /api/* (nelmio/cors-bundle).

## Endpoint
- Método: `POST /api/v1/valuation/estimate`
- Body JSON:
  - brand: string
  - category: string
  - condition: new | good | fair
- Respuesta (ejemplo): base=100, price=198, min=178.2, max=217.8, adjustments: brand/category/condition multiplicadores.

## Arquitectura (hexagonal)
- UI: `ValuationController` (adaptador HTTP), validador dedicado `ValuationRequestValidator`.
- Aplicación: `EstimateValuationHandler` (caso de uso), DTOs `ValuationRequest/Response`.
- Dominio: VO/entidades (`ValuationInput`, `Estimate`, `Adjustment`, `ValuationResult`), servicio `ValuationService`, reglas (Chain of Responsibility: brand, category, condition, floor/ceiling).
- Infraestructura: repositorio mock `InMemoryBrandFactorRepository`, DI en `config/services.yaml`.

Patrones:
- Chain of Responsibility para reglas dinámicas y componibles.
- Validator separado para entrada HTTP.
- Repository (mock) preparado para reemplazo por Doctrine.
- DTO/VO para aislar dominio de transporte HTTP.

## Tests
- Ejecutar: `composer test` (PHPUnit 9).
- Cobertura: reglas individuales (`BrandRule`, `CategoryRule`, `ConditionRule`, `FloorCeilingRule`) y pipeline (`ValuationServiceTest`).

## Cómo extender reglas
- Crear nueva clase que implemente `RuleInterface`.
- Etiquetarla con `valuation.rule` en `services.yaml` (el orden en el archivo define la secuencia en el pipeline).

## Frontend (pendiente)
- Por implementar Vue 2 SSR + Webpack; este backend ya incluye CORS para `http://localhost:5173`.

## Frontend SSR (Vue 2)
- Ubicación: `front/`
- Prerrequisitos: Node 16; backend corriendo en `http://127.0.0.1:8000`.
- Instalación:
  1) `cd front`
  2) `npm install`
- Build y ejecución:
  - `npm run build` (genera bundles en `dist/`)
  - `npm run start` (SSR en `http://localhost:3000`)
  - Dev con reconstrucción: `npm run dev:ssr`
- Estructura clave:
  - `server.js`: servidor SSR con Express
  - `src/app.js`, `entry-client.js`, `entry-server.js`
  - `src/components/ValuationEstimator.vue`: formulario (brand/category/condition), estados loading/error/result, llamada a la API.
- Consumo API: POST a `http://127.0.0.1:8000/api/v1/valuation/estimate` (CORS habilitado para localhost:3000/5173).

## Ejemplo rápido (curl)
curl -X POST http://127.0.0.1:8000/api/v1/valuation/estimate \
  -H "Content-Type: application/json" \
  -d '{"brand":"Zara","category":"dress","condition":"new"}'


Respuesta esperada (aprox):
{
  "base": 100,
  "price": 198,
  "min": 178.2,
  "max": 217.8,
  "adjustments": [
    {"rule":"brand","type":"multiplier","value":1.1},
    {"rule":"category","type":"multiplier","value":1.2},
    {"rule":"condition","type":"multiplier","value":1.5}
  ]
}