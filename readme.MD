# Бандл для Symfony+Битрикс, дающий возможность использовать Twig 

***INTERNAL***

В результате в контейнере появляется сервис `twig.instance` (и `twig`) со сконфигурированным экземпляром Twig. Плюс Twig автоматически подцепляется к системе после загрузки контейнера.

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
    cache_dir: '/bitrix/cache/twig'
    autoescape: 'name'
    autoescape_service: ~
    autoescape_service_method: ~
    base_template_class: 'Twig\Template'
    debug: '%kernel.debug%'
    strict_variables: '%kernel.debug%'
```

## Прочее

Если на проекте используется [пакет](https://github.com/ProklUng/tools.twig) с поддержкой твиговского движка
в компонентах, то в экземпляр того Твига автоматически перебрасываются все зарегистрированные в контейнере
`extensions` (то, что отмечено в конфигах тэгом `twig.extension`) и `runtimes` (тэг `twig.runtime`).

Также эта штука поддается использованию автономно, без контейнера.

Где-нибудь в `init.php` (для `extensions`; для `runtimes` класс обработчик - `Prokl\BitrixOrdinaryToolsBundle\Services\Twig\TwigRuntimesBag`):

```php
use Prokl\BitrixTwigBundle\Services\Twig\TwigExtensionsBag;
use Bitrix\Main\EventManager;

$events = [new Local\TwigExtension, Local\FooExtension::class];
$handler = new TwigExtensionsBag($events);

$eventManager = EventManager::getInstance();
$eventManager->addEventHandler(
    '',
    'onAfterTwigTemplateEngineInited',
    [$handler, 'handle']
);
```

Если [пакет](https://github.com/ProklUng/tools.twig) не установлен, то соответствующие сервисы
удаляется на стадии компиляции контейнера.

Изначальная конфигурация [пакета](https://github.com/ProklUng/tools.twig) имеет приоритет над прокидываемым
снаружи.