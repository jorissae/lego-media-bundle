# LegoMediaBundle

A media file attachment tool and media tool for Symfony 4 Lego projects. 
This tool exists without the lego layer  , it is "lle/attachmentBundle" the code concern the file attachment to an entity is the same.

## Attachment on entity

### Lego use

In your configurator (add the brick)
```php
<?php
use Idk\LegoMediaBundle\Brick\Attachment;
$this->addIndexComponent(Attachment::class);
$this->addShowComponent(Attachment::class);
```
the component auto configure by context (edit, show, new or index)
the new context is the same that index (the brick show a form which ask an entity by autocompletion)


### Easy use

```twig
{{ lgo_render_attachment(entity) }}
```

You can use several attachment on the same template

```twig
{{ lgo_render_attachment(item) }}

{%  for examen in item.examens  %}
    <h3>{{ examen }}</h3>
    {{ lgo_render_attachment(examen) }}
{%  endfor %}
```

## Configurations

with default value

```yaml
framework:
    translator:
        fallbacks: ['fr']

lego_attachment:
    directory: data/attachment #directory of files is registred
```

Thanks to use