# Extendable Domain Specific Language (DSL) implementation

Wikipedia defines:
```text
A domain-specific language (DSL) is a computer language specialized to a particular application domain.
```

Grammar of this implementation is partially inspired by basic arithmetic and Clojure language.

Syntax is very simple: `(<operation name> [... list of nodes])`

It's very easy to implement complicated equation:  
```text
(max
    ((+ {a} {b} {c}) * {-1.22})
    ({100.0} - {d})
    {3.1415}
)
```

## Basic usage

Expression are evaluated in global context which is represented `array`.

```php
$runtime = new Pilulka\DSL\Runtime();
$runtime->execute('{a}', ['a' => 1]); // 1        
$runtime->execute('{3.1415}', []); // 3.1415        
$runtime->execute('{"This is custom text!"}', []); // This is custom text!        
$runtime->execute('{a} + {b}', ['a' => 1, 'b' => 3]); // 4        
$runtime->execute('{a} - {b}', ['a' => 1, 'b' => 3]); // -2        
$runtime->execute('(max {a} {b})', ['a' => 1, 'b' => 3]); // 3        
$runtime->execute('(max {a} {b}) + {2.1}', ['a' => 1, 'b' => 3]); // 5.1
// ...        
```

## Extending

Most important thing about this DSL implementation is extendability.
You can extend syntax to your logic requirements by specifying list of operations in your domain context.

```php
class CastNumber implements OperationInterface {
    public function execute(array $inputs) {
        // implement serious logic with validation etc.
        return (float) $inputs[0];
    }
}

$runtime = new Pilulka\DSL\Runtime([
    'castNumber' => CastNumber::class,
]);

$runtime->execute('(castNumber {price})', ['price' => '123.5 USD']) // 123.5 
```

### Overloading operation loading

If you need to load your custom operations with external dependencies use your own `OperationLoader` by implementing `OperationLoaderInterface`.

I will recommend you to use some dependency injection container implementation and register your loader with it.

*Note: You will have to implement also internal operation loading. It's king of trivial task.*
