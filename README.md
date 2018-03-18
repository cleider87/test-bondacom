# README #
# API de localizaciones

NOTA: sólo se le apliqué seguridad a las rutas de /api/ por el método POST

usuario: admin
clave: foo

## Programas y librerias necesarias.

* PHP7
* MySQL
* Apache2 o superior
* Composer

## API

###API VERSION
```
GET /api/
```
##COUNTRIES:

###ALL COUNTRIES
```
GET  /api/country/
```

###CREATE COUNTRY
```
POST /api/country/
```

Body:
```javascript
{
    "country_name":"Venezuela",
    "iso_name": "VE"
}
```
##STRUCTURES:

###ALL STRUCTURES
```
GET  /api/structure/
```

###CREATE STRUCTURE
```
POST  /api/structure/
```

Body:
```javascript
{
    "country_id": "3",
    "level": "2",
    "level_name": "Ciudad",
    "final": "1"
}
```
##REGION 

###CHILDREN TREE 
```
GET /api/country/{iso_code}/region/children
```
###CHILDREN TREE BY NODE
```
GET /api/country/{iso_code}/region/{id_node}/children
```

###CREATE REGION
```
POST /api/region/
```
Body:
```javascript
{
    "structure_id": "1",
    "parent": "0",
    "region_name": "Tucumán"
}
```