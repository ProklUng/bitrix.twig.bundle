# Базовый бандл для Symfony+Битрикс, дающий возможность использовать Twig 

В результате в контейнере появляется сервис `twig.instance` (и `twig`) со сконфигурированным экземпляром Twig
(без всяких наворотов и продвинутых конфигураций).

Плюс Twig автоматически подцепляется к системе после загрузки контейнера.

## Установка

composer.json:

```json
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/proklung/bitrix.twig.bundle"
        }
    ]
```

```bash
composer require proklung/bitrix-twig-bundle
```

Подключить бандл в `standalone_bundles.php`:

```php
return [
 Prokl\BitrixTwigBundle\BitrixTwigBundle::class => ['all' => true],
];
```

Зависит от [пакет](https://github.com/ProklUng/core.framework.extension.bundle), где происходит обработка настроек в
файле `framework.yaml`

Типа:

```yaml
framework:
  twig:
    # Пути к шаблонам
    default_path: '%kernel.project_dir%/local/twig'
    paths:
      '%kernel.project_dir%/local/twig': ~
      # С namespace
      '%kernel.project_dir%/../../vendor/symfony/web-profiler-bundle/Resources/views': WebProfiler

    cache: false
    cache_dir: '%kernel.project_dir%/bitrix/cache/twig'
    autoescape: 'name'
    autoescape_service: ~
    autoescape_service_method: ~
    base_template_class: 'Twig\Template'
    debug: '%kernel.debug%'
    strict_variables: '%kernel.debug%'
```
