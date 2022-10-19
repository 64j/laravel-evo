<?php

declare(strict_types=1);

namespace App;

use App\Events\OnLoadSettings;
use App\Events\OnLogPageHit;
use App\Events\OnMakePageCacheKey;
use App\Events\OnWebPageInit;
use App\Models\SiteContent;
use App\Models\SiteTemplate;
use App\Models\SystemSetting;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * @property Request $request
 */
class Core extends Application
{
    /**
     * @var array
     */
    public array $config = [];

    /**
     * @var string
     */
    protected string $documentMethod;

    /**
     * @var mixed
     */
    protected $documentIdentifier;

    /**
     * @var string|null
     */
    protected ?string $documentContent = null;

    /**
     * @var string|null
     */
    protected ?string $systemCacheKey = null;

    /**
     * @var string|null
     */
    protected ?string $cacheKey = null;

    /**
     * @var array
     */
    protected array $documentObject = [];

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return app()->runningInConsole() || Session::get('mgrValidated');
    }

    /**
     * @return array
     */
    protected function getSettings(): array
    {
        $this->config = Cache::rememberForever('evo.settings', function () {
            return SystemSetting::query()
                ->pluck('setting_value', 'setting_name')
                ->toArray();
        });

        OnLoadSettings::dispatch($this->config);

        return $this->config;
    }

    /**
     * @param $event
     * @param array $params
     *
     * @return void
     */
    public function evalPlugins($event, array $params)
    {
        extract($params);

        foreach ($event['plugins'] as $plugin) {
            $properties = array_map(
                fn($property) => current($property)['value'] ?? null,
                json_decode($plugin['properties'], true)
            );
            extract($properties);
            eval($plugin['plugincode']);
        }
    }

    /**
     * @param string $key
     * @param $default
     *
     * @return mixed
     */
    public function getConfig(string $key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * @param string|null $key
     * @param mixed $value
     *
     * @return array
     */
    public function setConfig(?string $key, $value): array
    {
        return Arr::set($this->config, $key, $value);
    }

    /**
     * check if site is offline
     *
     * @return boolean
     */
    public function checkSiteStatus(): bool
    {
        if ($this->getConfig('site_status')) {
            return true;
        }

        if ($this->isLoggedin()) {
            return true;
        }  // site online
        // site offline but launched via the manager

        return false; // site is offline
    }

    /**
     * @param string $method
     *
     * @return string|void
     */
    public function getDocumentIdentifier(string $method)
    {
        if ($method === 'alias') {
            return $this->request->getPathInfo();
        }

        $id = $this->request->get('id');
        if ($id) {
            if (preg_match('@^[1-9]\d*$@', $id)) {
                return $id;
            }
            $this->sendErrorPage();
        } elseif (Str::contains($this->request->getRequestUri(), 'index.php/')) {
            $this->sendErrorPage();
        } else {
            return $this->getConfig('site_start');
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|ResponseFactory|Response
     */
    public function executeParser()
    {
        $this->getSettings();

        if ($this->request->isMethod('get')) {
            $this->cacheKey = 'evo.doc.' . md5($this->request->getRequestUri());
        }

        if ($this->checkSiteStatus()) {
            //$this->updatePubStatus();
            //$this->documentMethod = filter_input(INPUT_GET, 'q') ? 'alias' : 'id';
            $this->documentMethod = 'alias';
            $this->documentIdentifier = $this->getDocumentIdentifier($this->documentMethod);
        } else {
        }

        if ($this->documentMethod !== 'alias') {
            OnWebPageInit::dispatch();

            if ($this->getConfig('track_visitors') == 1) {
                OnLogPageHit::dispatch();
            }

            if ($this->getConfig('seostrict') == '1') {
                //$this->sendStrictURI();
            }

            return response($this->prepareResponse());
        }

        if ($this->getConfig('use_alias_path') == 1) {
            $alias = ltrim($this->documentIdentifier, '/');
            $key = 'evo.documentListing.' . $this->documentIdentifier;

            if (Cache::has($key)) {
                $this->documentIdentifier = Cache::get($key);
            } else {
                $doc = $alias ? SiteContent::query()
                    ->firstWhere('alias', $alias) : SiteContent::query()
                    ->firstWhere('id', $this->getConfig('site_start'));

                if ($doc) {
                    $this->documentIdentifier = $doc->getKey();
                    $this->documentObject = $doc->toArray();

                    Cache::forever($key, $this->documentIdentifier);
                } else {
                    $this->sendErrorPage();
                }
            }
        } else {
        }

        $this->documentMethod = 'id';

        OnWebPageInit::dispatch();

        if ($this->getConfig('track_visitors') == 1) {
            OnLogPageHit::dispatch();
        }

        if ($this->getConfig('seostrict') == 1) {
            //$this->sendStrictURI();
        }

        return response($this->prepareResponse());
    }

    /**
     * @param $id
     *
     * @return array|mixed|null|string
     */
    public function makePageCacheKey($id)
    {
        $hash = $id;
        $tmp = null;
        $params = [];
        $cacheKey = $this->getSystemCacheKey();
        if (!empty($cacheKey)) {
            $hash = $cacheKey;
        } else {
            if (!empty($_GET)) {
                // Sort GET parameters so that the order of parameters on the HTTP request don't affect the generated cache ID.
                $params = $_GET;
                ksort($params);
                $hash .= '_' . md5(http_build_query($params));
            }
        }

        $evtOut = OnMakePageCacheKey::dispatch(...[&$hash, $id, $params]);
        if (is_array($evtOut) && count($evtOut) > 0) {
            $tmp = array_pop($evtOut);
        }

        return empty($tmp) ? $hash : $tmp;
    }

    /**
     * @return string|null
     */
    public function getSystemCacheKey(): ?string
    {
        return $this->systemCacheKey;
    }

    /**
     * @return array
     */
    public function getDocumentObjectFromCache(): array
    {
        return Cache::get($this->cacheKey)[0] ?? [];
    }

    /**
     * @return string|null
     */
    public function getDocumentFromCache(): ?string
    {
        return Cache::get($this->cacheKey)[1] ?? null;
    }

    /**
     * @return string
     */
    protected function prepareResponse(): string
    {
        if ($this->getConfig('enable_cache') == 2 && $this->isLoggedIn()) {
            $this->setConfig('enable_cache', 0);
        }

        if ($this->getConfig('enable_cache')) {
            $this->documentObject = $this->getDocumentObjectFromCache();
            $this->documentContent = $this->getDocumentFromCache();
        }

        if (!is_null($this->documentContent)) {
            return $this->documentContent;
        }

        $this->documentObject = $this->getDocumentObject(
            $this->documentMethod,
            $this->documentIdentifier,
            'prepareResponse'
        );

        if ($this->documentObject['hide_from_tree'] == 1) {
            $this->setConfig('track_visitors', 0);
        }

        if ($this->documentObject['deleted'] == 1) {
            $this->sendErrorPage();
        } elseif ($this->documentObject['published'] == 0) {
            $this->_sendErrorForUnpubPage();
        } elseif ($this->documentObject['type'] === 'reference') {
            $this->_sendRedirectForRefPage($this->documentObject['content']);
        }

        $this->documentContent = $this->documentObject['content'];

        return $this->outputContent();
    }

    /**
     * @param string $documentMethod
     * @param $documentIdentifier
     * @param string $string
     *
     * @return array
     */
    protected function getDocumentObject(string $documentMethod, $documentIdentifier, string $string): array
    {
        return SiteContent::query()
            //->withoutProtected()
            ->firstWhere('site_content.' . $documentMethod, $documentIdentifier)
            ->toArray();
    }

    /**
     * @return string
     */
    protected function outputContent(): string
    {
        $template = SiteTemplate::query()
            ->firstWhere('id', $this->documentObject['template']);

        if (View::exists($template['templatealias'])) {
            $this->documentContent = View::make($template['templatealias'], [
                'data' => $this->documentObject,
            ])->render();
        } else {
            $this->documentContent = Blade::render($template['content'], [
                'data' => $this->documentObject,
            ]);
        }

        Cache::forever($this->cacheKey, [
            $this->documentObject,
            $this->documentContent
        ]);

        return $this->documentContent;
    }

    /**
     * @return never
     */
    public function sendErrorPage()
    {
        return $this->abort(404);
    }
}
