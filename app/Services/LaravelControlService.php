<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class LaravelControlService
{
    protected array $config;

    /**
     * Route registry for automated testing.
     * key      = route identifier
     * name     = display name
     * path     = URL path
     * children = sub-routes (testable pages)
     */
    protected array $routes = [
        'new_product_develop' => [
            'name' => 'NPD Request',
            'path' => '/new_product_develop',
            'children' => [
                'create' => [
                    'name' => 'Create',
                    'path' => '/new_product_develop/create',
                    'test_steps' => [
                        [
                            'id'       => 'brand',
                            'label'    => 'Brand',
                            'action'   => 'select',
                            'selector' => '#brand_id',
                            'value'    => 'user_brand',
                        ],
                        [
                            'id'       => 'barcode',
                            'label'    => 'Barcode',
                            'action'   => 'highlight',
                            'selector' => '#barcodeTest',
                            'wait_for' => 'value_filled',
                        ],
                        [
                            'id'       => 'code',
                            'label'    => 'รหัสสินค้า',
                            'action'   => 'highlight',
                            'selector' => '#code',
                            'wait_for' => 'value_filled',
                        ],
                        [
                            'id'       => 'doc_no',
                            'label'    => 'หมายเลขเอกสาร',
                            'action'   => 'type',
                            'selector' => '#DOC_NO',
                            'value'    => 'DOC-LC-001',
                        ],
                        [
                            'id'       => 'job_refno',
                            'label'    => 'Job Ref. No.',
                            'action'   => 'type',
                            'selector' => '#JOB_REFNO',
                            'value'    => 'CSCP-68001',
                        ],
                        [
                            'id'       => 'cust_oem',
                            'label'    => 'Customer (OEM)',
                            'action'   => 'type',
                            'selector' => '#CUST_OEM',
                            'value'    => 'OEM Test Co., Ltd.',
                        ],
                        [
                            'id'       => 'npd',
                            'label'    => 'Product Co-ordinator',
                            'action'   => 'select_first',
                            'selector' => '#NPD',
                        ],
                        [
                            'id'       => 'pdm',
                            'label'    => 'Marketing Manager',
                            'action'   => 'select_first',
                            'selector' => '#PDM',
                        ],
                        [
                            'id'       => 'name_eng',
                            'label'    => 'ชื่อผลิตภัณฑ์',
                            'action'   => 'type',
                            'selector' => '#NAME_ENG',
                            'value'    => 'NPD Product Test LC',
                        ],
                        [
                            'id'       => 'category',
                            'label'    => 'ประเภทผลิตภัณฑ์',
                            'action'   => 'select_first',
                            'selector' => '#CATEGORY',
                        ],
                    ],
                ],
                // 'edit' => [
                //     'name' => 'Edit',
                //     'path' => '/new_product_develop/edit',
                // ],
            ],
        ],
        'product_master' => [
            'name' => 'Product Master',
            'path' => '/product_master/pd_master',
            'children' => [
                'create' => [
                    'name' => 'Create',
                    'path' => '/product_master/pd_master/create',
                    'test_steps' => [
                        [
                            'id' => 'brand',
                            'label' => 'Brand',
                            'action' => 'select',
                            'selector' => '#BRAND',
                            'value' => 'user_brand',
                        ],
                        [
                            'id' => 'number',
                            'label' => 'รหัสที่ต้องการ',
                            'action' => 'select_first',
                            'selector' => '#NUMBER',
                            'wait_for' => 'options_loaded',
                        ],
                        [
                            'id' => 'barcode',
                            'label' => 'รหัส Barcode',
                            'action' => 'highlight',
                            // 'selector' => '#ID_BARCODE',
                            'selector' => '#ID_BARCODE, #BARCODE',
                            'wait_for' => 'value_filled',
                        ],
                        [
                            'id' => 'name_thai',
                            'label' => 'ชื่อภาษาไทย',
                            'action' => 'type',
                            'selector' => '#NAME_THAI',
                            'value' => 'สินค้าทดสอบ LC',
                        ],
                        [
                            'id' => 'short_thai',
                            'label' => 'ชื่อย่อภาษาไทย',
                            'action' => 'type',
                            'selector' => '#SHORT_THAI',
                            'value' => 'ทดสอบ LC',
                        ],
                        [
                            'id' => 'name_eng',
                            'label' => 'ชื่อภาษาอังกฤษ',
                            'action' => 'type',
                            'selector' => '#NAME_ENG',
                            'value' => 'Test Product LC',
                        ],
                        [
                            'id' => 'short_eng',
                            'label' => 'ชื่อย่อภาษาอังกฤษ',
                            'action' => 'type',
                            'selector' => '#SHORT_ENG',
                            'value' => 'Test LC',
                        ],
                    ],
                ],
                'edit' => [
                    'name' => 'Edit',
                    'path' => '/product_master/pd_master/edit',
                ],
            ],
        ],
        'warehouse' => [
            'name' => 'Warehouse (KM)',
            'path' => '/warehouse/dimension',
            'children' => [
                'edit' => [
                    'name' => 'Edit',
                    'path' => '/warehouse/dimension/edit',
                    'test_steps' => [
                        [
                            'id' => 'brand',
                            'label' => 'Brand',
                            'action' => 'select',
                            'selector' => '#BRAND',
                            'value' => 'user_brand',
                        ],
                    ],
                ],
            ],
        ],
    ];

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig(): void
    {
        $configPath = config_path('laravel-control/laravel-control.json');

        if (File::exists($configPath)) {
            $this->config = json_decode(File::get($configPath), true) ?? [];
        } else {
            $this->config = [
                'commands' => [
                    'checkout' => 'Switch route for automated testing'
                ],
                'shortcuts' => [
                    'openTerminal' => 'ctrl+`',
                    'openLaravelGraph' => 'ctrl+shift+`'
                ],
                'defaults' => [
                    'promptPrefix' => 'laravel ',
                    'welcomeMessage' => "Laravel Control: type 'laravel help' for available commands"
                ]
            ];
        }
    }

    /**
     * Get all available routes as branches for the graph (including children).
     */
    public function getBranches(): array
    {
        $currentRoute = session('lc_current_route');

        $branches = [];
        foreach ($this->routes as $key => $route) {
            $branch = [
                'name'    => $route['name'],
                'key'     => $key,
                'path'    => $route['path'],
                'current' => $key === $currentRoute,
            ];

            // Include children if any
            if (!empty($route['children'])) {
                $branch['children'] = [];
                foreach ($route['children'] as $childKey => $child) {
                    $fullKey = $key . '/' . $childKey;
                    $childData = [
                        'name' => $child['name'],
                        'key'  => $fullKey,
                        'path' => $child['path'],
                    ];
                    if (!empty($child['test_steps'])) {
                        $childData['test_steps'] = $child['test_steps'];
                    }
                    $branch['children'][] = $childData;
                }
            }

            $branches[] = $branch;
        }

        $groups = [
            [
                'brand'    => 'Product Master',
                'branches' => $branches,
            ],
        ];

        $currentName = null;
        $found = $this->findRoute($currentRoute ?? '');
        if ($found) {
            $currentName = $found['name'];
        }

        return [
            'groups'  => $groups,
            'current' => $currentName,
            'total'   => count($branches),
        ];
    }

    /**
     * Find a route by key, path, or name (searches parents and children).
     */
    protected function findRoute(string $search): ?array
    {
        if (empty($search)) {
            return null;
        }

        // 1. Exact key match on parent
        if (isset($this->routes[$search])) {
            $route = $this->routes[$search];
            return ['key' => $search, 'name' => $route['name'], 'path' => $route['path']];
        }

        foreach ($this->routes as $parentKey => $route) {
            // 2. Match parent by path
            $normalizedSearch = '/' . ltrim($search, '/');
            if ($route['path'] === $normalizedSearch) {
                return ['key' => $parentKey, 'name' => $route['name'], 'path' => $route['path']];
            }

            // 3. Match parent by name
            if (strcasecmp($route['name'], $search) === 0) {
                return ['key' => $parentKey, 'name' => $route['name'], 'path' => $route['path']];
            }

            // 4. Search children
            if (!empty($route['children'])) {
                foreach ($route['children'] as $childKey => $child) {
                    $fullKey = $parentKey . '/' . $childKey;

                    // Match by full key (e.g. product_master/create)
                    if ($fullKey === $search) {
                        return ['key' => $fullKey, 'name' => $child['name'], 'path' => $child['path']];
                    }

                    // Match by child path (e.g. /product_master/pd_master/create)
                    if ($child['path'] === $normalizedSearch) {
                        return ['key' => $fullKey, 'name' => $child['name'], 'path' => $child['path']];
                    }

                    // Match by child name
                    if (strcasecmp($child['name'], $search) === 0) {
                        return ['key' => $fullKey, 'name' => $child['name'], 'path' => $child['path']];
                    }
                }
            }
        }

        return null;
    }

    /**
     * Checkout: switch to a route for automated testing.
     */
    public function checkout(string $routeKey): array
    {
        // Handle '-' for switching to previous route
        if ($routeKey === '-') {
            $previousKey = session('lc_previous_route');
            if (!$previousKey) {
                return [
                    'success' => false,
                    'message' => 'No previous route to switch to',
                ];
            }
            $routeKey = $previousKey;
        }

        $found = $this->findRoute($routeKey);

        if (!$found) {
            return [
                'success' => false,
                'message' => "Route '{$routeKey}' not found",
                'hint'    => "Use 'laravel branch' to see available routes",
            ];
        }

        $previousRoute = session('lc_current_route');
        session(['lc_previous_route' => $previousRoute]);
        session(['lc_current_route' => $found['key']]);

        return [
            'success' => true,
            'message' => "Switched to '{$found['name']}' ({$found['path']})",
            'route'   => $found['path'],
            'name'    => $found['name'],
            'key'     => $found['key'],
        ];
    }

    /**
     * Handle terminal commands.
     */
    public function handleCommand(string $rawCommand): array
    {
        $command = preg_replace('/^laravel\s+/i', '', trim($rawCommand));
        $parts = preg_split('/\s+/', $command, 2);
        $cmd = strtolower($parts[0] ?? '');
        $args = $parts[1] ?? '';

        switch ($cmd) {
            case 'checkout':
            case 'switch':
                if (empty($args)) {
                    return [
                        'success' => false,
                        'message' => 'Usage: laravel checkout <route>',
                        'hint'    => "Use 'laravel branch' to see available routes",
                    ];
                }
                return $this->checkout(trim($args));

            case 'branch':
            case 'branches':
                $data = $this->getBranches();
                return [
                    'success' => true,
                    'type'    => 'branch',
                    'message' => 'Available routes:',
                    'data'    => [
                        'branches' => $this->flattenBranches($data),
                        'current'  => $data['current'],
                    ],
                ];

            case 'status':
                return $this->getStatus();

            case 'help':
                return [
                    'success' => true,
                    'type'    => 'info',
                    'message' => implode("\n", [
                        'Available commands:',
                        '  laravel branch                        - List available routes',
                        '  laravel checkout <route>              - Switch to a route',
                        '  laravel checkout -                    - Switch to previous route',
                        '  laravel status                        - Show current route',
                        '  laravel clear                         - Clear terminal',
                        '  laravel help                          - Show this help',
                    ]),
                ];

            case 'clear':
                return [
                    'success' => true,
                    'type'    => 'clear',
                    'message' => '',
                ];

            default:
                return [
                    'success' => false,
                    'message' => "Unknown command: '{$cmd}'",
                    'hint'    => "Type 'laravel help' for available commands",
                ];
        }
    }

    /**
     * Get current status.
     */
    public function getStatus(): array
    {
        $currentKey = session('lc_current_route');
        $found = $this->findRoute($currentKey ?? '');

        return [
            'success' => true,
            'type'    => 'info',
            'message' => $found
                ? "On route: {$found['name']} ({$found['path']})"
                : 'No route selected',
        ];
    }

    /**
     * Get config.
     */
    public function getConfig(): array
    {
        return [
            'success' => true,
            'config'  => $this->config,
            'routes'  => $this->routes,
        ];
    }

    /**
     * Get checkout history.
     */
    public function getHistory(): array
    {
        return [
            'success' => true,
            'history' => session('lc_history', []),
        ];
    }

    /**
     * Get pipeline/sales data for a specific route.
     */
    public function getShow(string $branch): array
    {
        return [
            'success'   => true,
            'pipelines' => $this->getSalesData($branch),
        ];
    }

    /**
     * Get pipeline/sales data for all routes.
     */
    public function getShowAll(): array
    {
        return [
            'success'   => true,
            'pipelines' => $this->getSalesData(null),
        ];
    }

    protected function flattenBranches(array $data): array
    {
        $branches = [];
        foreach ($data['groups'] as $group) {
            foreach ($group['branches'] as $branch) {
                $branches[] = $branch;
            }
        }
        return $branches;
    }

    protected function getSalesData(?string $route): array
    {
        // TODO: Connect to actual sales/transaction data source
        return [];
    }
}
