# HelpersBundle

Librería con clases y elementos que reutilizo habitualmente

## Funcionalidades

### BodyListener, convierte request JSON

Si se envía una Request JSON convierte el body de esa Request en parámetros de Symfony.

### ParamConverter, crea Commands desde parámetros

Desde una Request con parámetros construye un objeto de tipo Command.

El converter se llama "array2command_converter".
Opciones:

- "param": nombre de un parameto dentro del JSON o "_root" si tiene en cuenta todo el objeto JSON desde la raiz.
- "include_route_params" [true|false], si es true hace un array_merge() entre los parámetros de la request y los parámetros de la ruta.

El converter también ejecuta el validador sobre el objeto de tipo comando y lanza una excepción de tipo
*ValidationException* si tiene errores.

```
/**
 * @Route(path="/test/{id}")
 * @ParamConverter("productCommand", class="AppBundle\Command\Message\NewProduct", options={"param": "_root", "include_route_params": true}, converter="array2command_converter")
 */
public function testAction($productCommand)
{
    dump($productCommand);
}
```

### Constraint Validator: ChoiceFromConfig

Es prácticamente igual al validator Choice de Symfony pero saca las posibles opciones de la config de parameters.yml

```
use Fer\HelpersBundle\Validator\Constraints as CustomAssert;

/**
 * @Assert\NotBlank()
 * @CustomAssert\ChoiceFromConfig(configEntry="project.authors")
 */
public $person;
```

Son las mismas opciones del Choice de Symfony pero en vez de "choices" tiene un
"configEntry" que debe apuntar a un array en los parámetros.

```
project.authors:
      - fernando
      - fran
```

### TbbcRestUtil ValidationErrorFactory
Si el bundle TbbcRestUtil está configurado se puede utilizar la clase *ValidationErrorFactory*
que crea una  Error Response legible para mostrar en JSON a partir de una excepción de tipo *ValidationException*.


```
tbbc_rest_util:
    error:
        use_bundled_factories: true
        exception_mapping:
            Array2CommandConverterException:
                class: "Fer\\HelpersBundle\\Exception\\Array2CommandConverterException"
                factory: validation_errors
                http_status_code: 400
                error_code: 400101
                error_message: "Invalid input"
                error_more_info_url: ""
```

### Traits

#### ClassToArrayTrait

Define un método protected classToArray() que devuelve un array asociativo con las properties de la clase y sus valores.

#### ArrayToPropertiesTrait

Define un método protected arrayToProperties($dataArray) que coge un array asociativo y le asigna los valores
a las properties de la clase.

### CQRS

#### UuidGenerator

Clase *UuidGenerator* que define un método estático *generate()* que devuelve un string tipo Uuid4

#### RepositoryInterface
Interface que define los métodos básico que debe implementar un Repository:

- nextIdentity() devuelve un objeto tipo ID nuevo
- getOfIdentity(AggregateIdInterface $id)) Devuelve un objeto que corresponde con el ID pasado
- save(AggregateRootInterface $entity) persiste un Entity
- remove(AggregateRootInterface $entity) Borra una entidad
- findAll() Devuelve toda la colección de una entidad

#### DefaultDomainEvent

Es una clase abstracta que deberían implementar todos los eventos de dominio.
En el constructor se le puede pasar un array asociativo para inicializar las properties del evento.

Los eventos de dominio deben definir una constante EVENT_NAME con el nombre del evento que será
el que se asocie con su listener correspondiente.

#### DefaultCommand

Es una clase abstracta que deben implementar todos los comandos.
En el constructor se le puede pasar un array asociativo para inicializar las properties del comando.

Los comandos deben definir una constante COMMAND_NAME con el nombre del comando que será
el que se asocie con su handler correspondiente.

Define una función estática mapProperties($command, $entity) que inicializa un comando a partir de una entidad.
