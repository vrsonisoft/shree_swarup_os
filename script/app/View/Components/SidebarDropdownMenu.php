<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarDropdownMenu extends Component
{
    public $name;
    public $icon;
    public $customIcon;
    public $active = false;
    public $isAddon = false;

    public function __construct($name, $icon, $active, $customIcon = null, $isAddon = false)
    {
        $this->name = $name;
        $this->icon = $this->setIcon($icon);
        $this->active = $active;
        $this->customIcon = $customIcon;
        $this->isAddon = $isAddon;
    }

    public function setIcon($icon)
    {
        switch ($icon) {
            case 'menu':
                $this->icon = '<i class="ti ti-tools-kitchen-2 text-lg"></i>';
                break;
            case 'table':
                $this->icon = '<i class="ti ti-table text-lg"></i>';
                break;
            case 'payments':
                $this->icon = '<i class="ti ti-credit-card text-lg"></i>';
                break;
            case 'reports':
                $this->icon = '<i class="ti ti-chart-bar text-lg"></i>';
                break;
            case 'orders':
                $this->icon = '<i class="ti ti-shopping-bag text-lg"></i>';
                break;
            case 'expenses':
                $this->icon = '<i class="ti ti-wallet text-lg"></i>';
                break;
            case 'delivery':
                $this->icon = '<i class="ti ti-truck text-lg"></i>';
                break;
            case 'landing':
                $this->icon = '<i class="ti ti-browser text-lg"></i>';
                break;
            case 'settings':
                $this->icon = '<i class="ti ti-adjustments-horizontal text-lg"></i>';
                break;
            case 'tutorials':
                $this->icon = '<i class="ti ti-school text-lg"></i>';
                break;
            case 'dashboard':
                $this->icon = '<i class="ti ti-layout-dashboard text-lg"></i>';
                break;
            default:
                $this->icon = '<i class="ti ti-point text-lg"></i>';
                break;
        }

        return $this->icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-dropdown-menu');
    }
}
