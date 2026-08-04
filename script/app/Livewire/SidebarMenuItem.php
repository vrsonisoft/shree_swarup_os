<?php

namespace App\Livewire;

use Livewire\Component;

class SidebarMenuItem extends Component
{

    public $name;
    public $link;
    public $icon;
    public $active = false;
    public $customIcon;
    public $navigate = true;
    public $isAddon = false;

    public function mount($customIcon = null, $isAddon = false, $navigate = true)
    {
        $this->icon = $this->setIcon($this->icon);
        $this->customIcon = $customIcon;
        $this->isAddon = $isAddon;
        $this->navigate = $navigate;
    }


    public function setIcon($icon)
    {
        switch ($icon) {
            case 'menu':
                $this->icon = '<i class="ti ti-tools-kitchen-2 text-lg"></i>';
                break;

            case 'pos':
                $this->icon = '<i class="ti ti-device-desktop text-lg"></i>';
                break;

            case 'orders':
                $this->icon = '<i class="ti ti-shopping-bag text-lg"></i>';
                break;

            case 'customers':
                $this->icon = '<i class="ti ti-users text-lg"></i>';
                break;

            case 'dashboard':
                $this->icon = '<i class="ti ti-layout-dashboard text-lg"></i>';
                break;

            case 'staff':
                $this->icon = '<i class="ti ti-shield-lock text-lg"></i>';
                break;

            case 'payments':
                $this->icon = '<i class="ti ti-credit-card text-lg"></i>';
                break;

            case 'settings':
                $this->icon = '<i class="ti ti-settings text-lg"></i>';
                break;

            case 'reservations':
                $this->icon = '<i class="ti ti-calendar-event text-lg"></i>';
                break;

            case 'restaurants':
                $this->icon = '<i class="ti ti-building-store text-lg"></i>';
                break;

            case 'packages':
                $this->icon = '<i class="ti ti-package text-lg"></i>';
                break;

            case 'billing':
                $this->icon = '<i class="ti ti-file-invoice text-lg"></i>';
                break;

            case 'offline-plan-request':
                $this->icon = '<i class="ti ti-clock-pause text-lg"></i>';
                break;

            case 'landing':
                $this->icon = '<i class="ti ti-browser text-lg"></i>';
                break;

            case 'waiterRequest':
                $this->icon = '<i class="ti ti-bell-ringing text-lg"></i>';
                break;

            case 'delivery':
                $this->icon = '<i class="ti ti-truck-delivery text-lg"></i>';
                break;

            case 'ai':
                $this->icon = '<i class="ti ti-sparkles text-lg"></i>';
                break;

            default:
                $this->icon = '<i class="ti ti-point text-lg"></i>';
                break;
        }

        return $this->icon;
    }

    public function render()
    {
        return view('livewire.sidebar-menu-item');
    }
}
